<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function createPayment(array $data)
    {
        Log::info('Creating new payment', [
            'user_id' => $data['user_id'],
            'amount' => $data['amount'],
            'network_type' => $data['network_type'],
        ]);

        try {
            DB::beginTransaction();

            // Generate unique order ID if not provided
            if (!isset($data['order_id'])) {
                $data['order_id'] = Payment::generateOrderId();
            }

            // Set initial status and timestamp
            $data['status'] = Payment::STATUSES['PENDING'];
            $data['payment_initiated_at'] = now();

            $payment = Payment::create($data);

            Log::info('Payment created successfully', [
                'payment_id' => $payment->id,
                'order_id' => $payment->order_id,
            ]);

            DB::commit();
            return $payment;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create payment', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);
            throw $e;
        }
    }

    public function processPayment(Payment $payment)
    {
        Log::info('Processing payment', [
            'payment_id' => $payment->id,
            'order_id' => $payment->order_id,
        ]);

        // Update status to processing
        $payment->updateStatus(Payment::STATUSES['PROCESSING']);

        // Here you would integrate with your payment gateway
        // For example, send request to MTN MoMo, Airtel Money, etc.
        
        return $payment;
    }

    
}