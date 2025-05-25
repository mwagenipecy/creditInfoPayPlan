<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Account;
use App\Models\PaymentCallbackLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentCallbackController extends Controller
{
    public function handlePaymentCallback(Request $request)
    {
        $callbackLog = null;
        
        try {
            // First, log the callback regardless of validation
            $callbackLog = $this->logCallback($request);

            Log::info('Payment callback received', [
                'callback_log_id' => $callbackLog->id,
                'headers' => $request->headers->all(),
                'body' => $request->all(),
                'ip' => $request->ip(),
            ]);

            // Validate the callback request
            $validator = Validator::make($request->all(), [
                'order_id' => 'required|string',
                'status' => 'required|string|in:success,failed,pending,cancelled',
                'payment_reference' => 'nullable|string',
                'amount' => 'nullable|numeric',
                'transaction_id' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                $errorMessage = 'Payment callback validation failed';
                $callbackLog->markAsFailed($errorMessage, json_encode($validator->errors()->toArray()));
                
                Log::error($errorMessage, [
                    'callback_log_id' => $callbackLog->id,
                    'errors' => $validator->errors(),
                    'request_data' => $request->all(),
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid callback data',
                    'errors' => $validator->errors(),
                    'callback_id' => $callbackLog->id,
                ], 400);
            }

            // Try to find the payment
            $payment = Payment::where('order_id', $request->order_id)->first();

            if (!$payment) {
                $errorMessage = 'Payment not found for callback';
                $callbackLog->markAsFailed($errorMessage, "Order ID: {$request->order_id} not found in payments table");
                
                Log::error($errorMessage, [
                    'callback_log_id' => $callbackLog->id,
                    'order_id' => $request->order_id,
                    'request_data' => $request->all(),
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment not found',
                    'callback_id' => $callbackLog->id,
                ], 404);
            }

            // Mark callback as matched since we found the payment
            $callbackLog->markAsMatched($payment->id, 'Payment found and matched successfully');

            // Map callback status to our status
            $statusMapping = [
                'success' => Payment::STATUSES['COMPLETED'],
                'failed' => Payment::STATUSES['FAILED'],
                'pending' => Payment::STATUSES['PROCESSING'],
                'cancelled' => Payment::STATUSES['CANCELLED'],
            ];

            $newStatus = $statusMapping[$request->status] ?? Payment::STATUSES['FAILED'];

            // Prepare payment response data
            $paymentResponse = [
                'callback_status' => $request->status,
                'payment_reference' => $request->payment_reference,
                'transaction_id' => $request->transaction_id,
                'amount' => $request->amount,
                'callback_received_at' => now()->toISOString(),
                'payment_gateway_response' => $request->except(['order_id', 'status']),
                'callback_log_id' => $callbackLog->id,
            ];

            // Use database transaction for payment update and account creation
            DB::beginTransaction();

            // Update payment status
            $payment->updateStatus(
                $newStatus,
                $paymentResponse,
                $request->payment_reference
            );

            // Create account if payment is completed
            if ($newStatus === Payment::STATUSES['COMPLETED']) {
                $account = $this->createAccount($payment);
                $callbackLog->markAsProcessed("Payment completed and account created: {$account->account_number}");
            } else {
                $callbackLog->markAsProcessed("Payment status updated to: {$newStatus}");
            }

            DB::commit();

            Log::info('Payment callback processed successfully', [
                'callback_log_id' => $callbackLog->id,
                'payment_id' => $payment->id,
                'order_id' => $payment->order_id,
                'status' => $newStatus,
            ]);

            // Trigger any post-payment processing (notifications, emails, etc.)
            $this->postPaymentProcessing($payment);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment callback processed successfully',
                'order_id' => $payment->order_id,
                'callback_id' => $callbackLog->id,
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($callbackLog) {
                $callbackLog->markAsFailed($e->getMessage(), $e->getTraceAsString());
            }
            
            Log::error('Error processing payment callback', [
                'callback_log_id' => $callbackLog?->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process payment callback',
                'callback_id' => $callbackLog?->id,
            ], 500);
        }
    }

    private function logCallback(Request $request): PaymentCallbackLog
    {
        $callbackStatus = in_array($request->status, ['success', 'failed', 'pending', 'cancelled']) 
            ? $request->status 
            : PaymentCallbackLog::CALLBACK_STATUSES['UNKNOWN'];

        return PaymentCallbackLog::create([
            'order_id' => $request->order_id,
            'callback_status' => $callbackStatus,
            'processing_status' => PaymentCallbackLog::PROCESSING_STATUSES['UNMATCHED'],
            'payment_reference' => $request->payment_reference,
            'transaction_id' => $request->transaction_id,
            'amount' => $request->amount,
            'currency' => $request->currency ?? 'TZS',
            'callback_payload' => $request->all(),
            'request_headers' => $request->headers->all(),
            'source_ip' => $request->ip(),
            'callback_received_at' => now(),
        ]);
    }

    private function createAccount(Payment $payment)
    {
        try {
            // Check if account already exists for this payment
            $existingAccount = Account::where('payment_id', $payment->id)->first();
            if ($existingAccount) {
                Log::info('Account already exists for payment', [
                    'payment_id' => $payment->id,
                    'account_id' => $existingAccount->id,
                ]);
                return $existingAccount;
            }

            // Generate unique account number
            $accountNumber = $this->generateAccountNumber();

            // Determine package details based on payment amount
            $packageDetails = $this->getPackageDetails($payment->amount);

            // Create new account
            $account = Account::create([
                'account_number' => $accountNumber,
                'company_id' => $payment->company_id,
                'user_id' => $payment->user_id,
                'payment_id' => $payment->id,
                'total_reports' => $packageDetails['total_reports'],
                'remaining_reports' => $packageDetails['total_reports'],
                'status' => 'active',
                'valid_from' => now(),
                'valid_until' => now()->addDays($packageDetails['validity_days']),
                'amount_paid' => $payment->amount,
                'package_type' => $packageDetails['package_type'],
            ]);

            Log::info('Account created successfully', [
                'account_id' => $account->id,
                'account_number' => $account->account_number,
                'payment_id' => $payment->id,
                'user_id' => $payment->user_id,
                'package_type' => $packageDetails['package_type'],
            ]);

            return $account;
        } catch (\Exception $e) {
            Log::error('Error creating account', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    private function generateAccountNumber()
    {
        do {
            // Generate account number format: ACC + timestamp + random 4 digits
            $accountNumber = 'ACC' . date('ymd') . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (Account::where('account_number', $accountNumber)->exists());

        return $accountNumber;
    }

    private function getPackageDetails($amount)
    {
        // Define package details based on payment amount
        // You can adjust these values based on your business logic
        $packages = [
            5000 => [
                'package_type' => 'Basic Package',
                'total_reports' => 10,
                'validity_days' => 30,
            ],
            10000 => [
                'package_type' => 'Standard Package',
                'total_reports' => 25,
                'validity_days' => 60,
            ],
            20000 => [
                'package_type' => 'Premium Package',
                'total_reports' => 50,
                'validity_days' => 90,
            ],
            50000 => [
                'package_type' => 'Enterprise Package',
                'total_reports' => 150,
                'validity_days' => 180,
            ],
        ];

        // Find the appropriate package based on amount
        $selectedPackage = null;
        foreach ($packages as $packageAmount => $packageDetails) {
            if ($amount >= $packageAmount) {
                $selectedPackage = $packageDetails;
            }
        }

        // Default package if no match found
        return $selectedPackage ?? [
            'package_type' => 'Basic Package',
            'total_reports' => 5,
            'validity_days' => 30,
        ];
    }

    private function postPaymentProcessing(Payment $payment)
    {
        Log::info('Starting post-payment processing', [
            'payment_id' => $payment->id,
            'status' => $payment->status,
        ]);

        // Add your post-payment logic here
        // Examples:
        // - Send confirmation email/SMS
        // - Update order status
        // - Trigger inventory updates
        // - Send notifications
        // - Update user credits/balance

        if ($payment->isCompleted()) {
            // Payment successful - do something
            Log::info('Payment completed successfully', [
                'payment_id' => $payment->id,
                'order_id' => $payment->order_id,
                'amount' => $payment->amount,
            ]);

            // Get the created account for this payment
            $account = Account::where('payment_id', $payment->id)->first();
            if ($account) {
                Log::info('Account created for completed payment', [
                    'payment_id' => $payment->id,
                    'account_id' => $account->id,
                    'account_number' => $account->account_number,
                    'package_type' => $account->package_type,
                ]);
            }

            // Example: Dispatch job for order fulfillment
            // ProcessSuccessfulPayment::dispatch($payment);
        } else if ($payment->isFailed()) {
            // Payment failed - do something
            Log::info('Payment failed', [
                'payment_id' => $payment->id,
                'order_id' => $payment->order_id,
            ]);

            // Example: Notify user of failure
            // NotifyPaymentFailure::dispatch($payment);
        }
    }

    /**
     * Get unmatched callback logs for manual review
     */
    public function getUnmatchedCallbacks(Request $request)
    {
        $query = PaymentCallbackLog::unmatched()
            ->orderBy('callback_received_at', 'desc');

        if ($request->has('date_from')) {
            $query->where('callback_received_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('callback_received_at', '<=', $request->date_to);
        }

        if ($request->has('callback_status')) {
            $query->byCallbackStatus($request->callback_status);
        }

        $callbacks = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'status' => 'success',
            'data' => $callbacks,
        ]);
    }

    /**
     * Manually process an unmatched callback
     */
    public function processUnmatchedCallback(Request $request, $callbackLogId)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|string|exists:payments,order_id',
            'action' => 'required|string|in:match,ignore',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid request data',
                'errors' => $validator->errors(),
            ], 400);
        }

        try {
            $callbackLog = PaymentCallbackLog::findOrFail($callbackLogId);

            if (!$callbackLog->isUnmatched()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Callback has already been processed',
                ], 400);
            }

            if ($request->action === 'match') {
                $payment = Payment::where('order_id', $request->order_id)->first();
                $callbackLog->markAsMatched($payment->id, $request->notes ?? 'Manually matched by admin');
                
                Log::info('Callback manually matched', [
                    'callback_log_id' => $callbackLog->id,
                    'payment_id' => $payment->id,
                    'matched_by' => auth()->user()?->id ?? 'system',
                ]);
            } else {
                $callbackLog->markAsFailed('Ignored by admin', $request->notes ?? 'Manually ignored by admin');
                
                Log::info('Callback manually ignored', [
                    'callback_log_id' => $callbackLog->id,
                    'ignored_by' => auth()->user()?->id ?? 'system',
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Callback processed successfully',
                'callback_log' => $callbackLog,
            ]);

        } catch (\Exception $e) {
            Log::error('Error processing unmatched callback', [
                'callback_log_id' => $callbackLogId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process callback',
            ], 500);
        }
    }
}