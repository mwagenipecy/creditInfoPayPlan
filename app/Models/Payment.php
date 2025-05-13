<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'network_type',
        'order_id',
        'user_id',
        'company_id',
        'mobile_number',
        'descriptions',
        'amount',
        'token_number',
        'status',
        'device_ip',
        'payment_response',
        'payment_reference',
        'payment_initiated_at',
        'payment_completed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_initiated_at' => 'datetime',
        'payment_completed_at' => 'datetime',
        'payment_response' => 'array', // Cast JSON to array
    ];

    // Define the allowed network types
    public const NETWORK_TYPES = [
        'MTN' => 'MTN',
        'VODACOM' => 'VODACOM',
        'AIRTEL' => 'AIRTEL',
        'TIGO' => 'TIGO',
    ];

    // Define the allowed status values
    public const STATUSES = [
        'PENDING' => 'pending',
        'PROCESSING' => 'processing',
        'COMPLETED' => 'completed',
        'FAILED' => 'failed',
        'CANCELLED' => 'cancelled',
        'EXPIRED' => 'expired',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByNetwork($query, $network)
    {
        return $query->where('network_type', $network);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Helper methods
    public function isCompleted()
    {
        return $this->status === self::STATUSES['COMPLETED'];
    }

    public function isPending()
    {
        return $this->status === self::STATUSES['PENDING'];
    }

    public function isProcessing()
    {
        return $this->status === self::STATUSES['PROCESSING'];
    }

    public function isFailed()
    {
        return $this->status === self::STATUSES['FAILED'];
    }

    // Update payment status with logging
    public function updateStatus($status, $paymentResponse = null, $paymentReference = null)
    {
        Log::info('Updating payment status', [
            'payment_id' => $this->id,
            'order_id' => $this->order_id,
            'old_status' => $this->status,
            'new_status' => $status,
            'payment_reference' => $paymentReference,
        ]);

        $this->update([
            'status' => $status,
            'payment_response' => $paymentResponse,
            'payment_reference' => $paymentReference,
            'payment_completed_at' => in_array($status, ['completed', 'failed']) ? now() : null,
        ]);

        Log::info('Payment status updated successfully', [
            'payment_id' => $this->id,
            'order_id' => $this->order_id,
            'status' => $this->status,
        ]);
    }

    // Generate unique order ID
    public static function generateOrderId($prefix = 'ORD')
    {
        return $prefix . '_' . date('YmdHis') . '_' . rand(1000, 9999);
    }


    public function createAccount()
{
    if (!$this->isCompleted()) {
        Log::warning('Attempted to create account for incomplete payment', [
            'payment_id' => $this->id,
            'status' => $this->status,
        ]);
        return false;
    }

    Log::info('Creating new account for payment', [
        'payment_id' => $this->id,
        'user_id' => $this->user_id,
        'company_id' => $this->company_id,
        'amount' => $this->amount,
    ]);

    // Calculate reports based on amount (2500 per report)
    $reports = floor($this->amount / 2500);

    // Set validity period (30 days from now)
    $validFrom = now();
    $validUntil = now()->addDays(30);

    // Create new account for this payment
    $account = Account::create([
        'account_number' => Account::generateAccountNumber($this->company_id, $this->user_id),
        'company_id' => $this->company_id,
        'user_id' => $this->user_id,
        'payment_id' => $this->id,
        'total_reports' => $reports,
        'remaining_reports' => $reports,
        'status' => Account::STATUSES['ACTIVE'],
        'valid_from' => $validFrom,
        'valid_until' => $validUntil,
        'amount_paid' => $this->amount,
        'package_type' => $this->descriptions,
    ]);

    Log::info('New account created with expiration', [
        'account_id' => $account->id,
        'account_number' => $account->account_number,
        'total_reports' => $account->total_reports,
        'valid_until' => $account->valid_until->toDateTimeString(),
    ]);

    return $account;
}



}
