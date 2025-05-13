<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentCallbackController extends Controller
{
    public function handlePaymentCallback(Request $request)
    {
        Log::info('Payment callback received', [
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
            Log::error('Payment callback validation failed', [
                'errors' => $validator->errors(),
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid callback data',
                'errors' => $validator->errors(),
            ], 400);
        }

        try {
            $payment = Payment::where('order_id', $request->order_id)->first();

            if (!$payment) {
                Log::error('Payment not found for callback', [
                    'order_id' => $request->order_id,
                    'request_data' => $request->all(),
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment not found',
                ], 404);
            }

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
            ];

            // Update payment status
            $payment->updateStatus(
                $newStatus,
                $paymentResponse,
                $request->payment_reference
            );

            Log::info('Payment callback processed successfully', [
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
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error processing payment callback', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process payment callback',
            ], 500);
        }
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
}
