<?php

namespace App\Livewire\Payment;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Log;

class Plan extends Component
{
    public $showModal = false;
    public $planName;
    public $statementCount = 1;
    public $payment;
    public $amount = 2500;
    public $descriptions = "MNO payment process";
    public $network;
    public $phone;
    public $acceptTerms = false;
    
    // Payment status tracking
    public $paymentStatus = 'idle'; // idle, processing, success, failed
    public $timeRemaining = 120; // 2 minutes in seconds
    public $errorMessage = '';
    public $paymentCheckInterval;
    
    protected $rules = [
        'network' => 'required|string',
        'phone' => 'required|min:9',
        'statementCount' => 'required|integer|min:1',
        'acceptTerms' => 'accepted'
    ];

    protected $listeners = [
        'checkPaymentStatus',
        'decrementTimer',
    ];

    public function mount()
    {
        // Initialize component
    }

    public function updatedStatementCount()
    {
        $this->amount = $this->statementCount * 2500;
    }

    public function openModal($planName, $defaultAmount)
    {
        $this->planName = $planName;
        $this->statementCount = $defaultAmount / 2500;
        $this->updatedStatementCount();
        $this->phone = '';
        $this->network = '';
        $this->acceptTerms = false;
        $this->paymentStatus = 'idle';
        $this->timeRemaining = 120;
        $this->errorMessage = '';
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->paymentStatus = 'idle';
        $this->timeRemaining = 120;
        $this->errorMessage = '';
        $this->clearTimers();
    }

    private function clearTimers()
    {
        // Clear any existing timers
        $this->js("
            if (window.paymentTimer) {
                clearInterval(window.paymentTimer);
                window.paymentTimer = null;
            }
            if (window.countdownTimer) {
                clearInterval(window.countdownTimer);
                window.countdownTimer = null;
            }
        ");
    }

    public function submitPayment()
    {
        $this->validate();

        Log::info('Initiating payment submission', [
            'user_id' => auth()->id(),
            'amount' => $this->amount,
            'network' => $this->network,
        ]);

        try {
            // Set payment status to processing
            $this->paymentStatus = 'processing';
            $this->timeRemaining = 120; // 2 minutes

            // Create payment record in database
            $this->initiatePayment();

            // Simulate API call to payment gateway
            sleep(2); // Simulate network delay

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.selcom.token'),
                'Content-Type' => 'application/json'
            ])->post('https://api.selcommobile.com/v1/payments/initiate', [
                'amount' => $this->amount,
                'mobile_number' => $this->phone,
                'network' => strtolower($this->network),
                'reference' => $this->payment->order_id,
                'description' => 'Purchase: ' . $this->planName,
            ]);

            if ($response->successful()) {
                Log::info('Payment gateway request successful', [
                    'order_id' => $this->payment->order_id,
                    'response' => $response->json(),
                ]);

                // Update payment with gateway response
                $this->payment->update([
                    'status' => Payment::STATUSES['PROCESSING'],
                    'payment_response' => $response->json(),
                ]);

                // Start payment monitoring
                $this->startPaymentMonitoring();
            } else {
                Log::error('Payment gateway request failed', [
                    'order_id' => $this->payment->order_id,
                    'response' => $response->body(),
                ]);

                $this->payment->updateStatus(Payment::STATUSES['FAILED'], $response->json());
                $this->paymentStatus = 'failed';
                $this->errorMessage = 'Payment gateway error: ' . $response->body();
            }
        } catch (\Exception $e) {
            Log::error('Payment submission error', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            if ($this->payment) {
                $this->payment->updateStatus(Payment::STATUSES['FAILED']);
            }
            
            $this->paymentStatus = 'failed';
            $this->errorMessage = 'An error occurred while processing payment. Please try again.';
        }
    }

    public function initiatePayment()
    {
        Log::info('Creating payment record', [
            'user_id' => auth()->id(),
            'amount' => $this->amount,
            'network_type' => $this->network,
        ]);

        try {
            $paymentService = new PaymentService();
            
            $this->payment = $paymentService->createPayment([
                'network_type' => strtoupper($this->network),
                'user_id' => auth()->id(),
                'company_id' => auth()->user()->company_id ?? 1,
                'mobile_number' => $this->phone,
                'descriptions' => $this->descriptions,
                'amount' => $this->amount,
                'device_ip' => request()->ip(),
            ]);

            Log::info('Payment record created successfully', [
                'payment_id' => $this->payment->id,
                'order_id' => $this->payment->order_id,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to create payment record', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);
            throw $e;
        }
    }

    private function startPaymentMonitoring()
    {
        // Start countdown timer for UI
        $this->js("
            window.countdownTimer = setInterval(() => {
                Livewire.dispatch('decrementTimer');
            }, 1000);
        ");

        // Start payment status checking
        $this->js("
            window.paymentTimer = setInterval(() => {
                Livewire.dispatch('checkPaymentStatus');
            }, 5000); // Check every 5 seconds
        ");
    }

    public function decrementTimer()
    {
        if ($this->timeRemaining > 0) {
            $this->timeRemaining--;
        } else {
            // Time expired
            $this->handlePaymentTimeout();
        }
    }

    private function handlePaymentTimeout()
    {
        Log::info('Payment timeout reached', [
            'payment_id' => $this->payment ? $this->payment->id : null,
            'order_id' => $this->payment ? $this->payment->order_id : null,
        ]);

        $this->clearTimers();
        
        if ($this->payment && $this->payment->status !== Payment::STATUSES['COMPLETED']) {
            $this->payment->updateStatus(Payment::STATUSES['EXPIRED']);
            $this->paymentStatus = 'failed';
            $this->errorMessage = 'Payment timeout. The transaction expired.';
        }
    }

    public function checkPaymentStatus()
    {
        if (!$this->payment) {
            return;
        }

        try {
            $this->payment->refresh();

            if ($this->payment->isCompleted()) {
                Log::info('Payment completed successfully', [
                    'payment_id' => $this->payment->id,
                    'order_id' => $this->payment->order_id,
                ]);

                $this->paymentStatus = 'success';
                $this->clearTimers();
                $this->dispatch('paymentCompleted', $this->payment->id);
            } elseif ($this->payment->isFailed()) {
                Log::info('Payment failed', [
                    'payment_id' => $this->payment->id,
                    'order_id' => $this->payment->order_id,
                ]);

                $this->paymentStatus = 'failed';
                $this->errorMessage = 'Payment was declined or failed. Please try again.';
                $this->clearTimers();
            }
            // Continue checking if still processing
        } catch (\Exception $e) {
            Log::error('Error checking payment status', [
                'error' => $e->getMessage(),
                'payment_id' => $this->payment ? $this->payment->id : null,
            ]);
        }
    }

    public function cancelPayment()
    {
        Log::info('Payment cancellation requested', [
            'payment_id' => $this->payment ? $this->payment->id : null,
            'order_id' => $this->payment ? $this->payment->order_id : null,
        ]);

        if ($this->payment) {
            $this->payment->updateStatus(Payment::STATUSES['CANCELLED']);
        }

        $this->clearTimers();
        $this->paymentStatus = 'failed';
        $this->errorMessage = 'Payment cancelled by user.';
        
        // Optionally close modal after a delay
        $this->js("setTimeout(() => { Livewire.dispatch('closeModal'); }, 3000);");
    }

    public function retryPayment()
    {
        Log::info('Payment retry requested', [
            'order_id' => $this->payment ? $this->payment->order_id : null,
        ]);

        $this->paymentStatus = 'idle';
        $this->timeRemaining = 120;
        $this->errorMessage = '';
        $this->clearTimers();
    }

    public function dehydrate()
    {
        // Clear timers when component is being dehydrated
        $this->clearTimers();
    }

    public function render()
    {
        return view('livewire.payment.plan');
    }
}