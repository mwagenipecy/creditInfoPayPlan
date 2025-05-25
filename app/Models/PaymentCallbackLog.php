<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PaymentCallbackLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'callback_status',
        'processing_status',
        'payment_id',
        'payment_reference',
        'transaction_id',
        'amount',
        'currency',
        'callback_payload',
        'request_headers',
        'source_ip',
        'error_message',
        'processing_notes',
        'callback_received_at',
        'processed_at',
    ];

    protected $casts = [
        'callback_payload' => 'array',
        'request_headers' => 'array',
        'amount' => 'decimal:2',
        'callback_received_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    // Status constants
    const CALLBACK_STATUSES = [
        'SUCCESS' => 'success',
        'FAILED' => 'failed',
        'PENDING' => 'pending',
        'CANCELLED' => 'cancelled',
        'UNKNOWN' => 'unknown',
    ];

    const PROCESSING_STATUSES = [
        'MATCHED' => 'matched',
        'UNMATCHED' => 'unmatched',
        'PROCESSED' => 'processed',
        'FAILED' => 'failed',
    ];

    /**
     * Get the payment associated with this callback log
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Scope to get unmatched callbacks
     */
    public function scopeUnmatched($query)
    {
        return $query->where('processing_status', self::PROCESSING_STATUSES['UNMATCHED']);
    }

    /**
     * Scope to get matched callbacks
     */
    public function scopeMatched($query)
    {
        return $query->where('processing_status', self::PROCESSING_STATUSES['MATCHED']);
    }

    /**
     * Scope to get processed callbacks
     */
    public function scopeProcessed($query)
    {
        return $query->where('processing_status', self::PROCESSING_STATUSES['PROCESSED']);
    }

    /**
     * Scope to get failed callbacks
     */
    public function scopeFailed($query)
    {
        return $query->where('processing_status', self::PROCESSING_STATUSES['FAILED']);
    }

    /**
     * Scope to get callbacks by status
     */
    public function scopeByCallbackStatus($query, $status)
    {
        return $query->where('callback_status', $status);
    }

    /**
     * Scope to get callbacks from a specific date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('callback_received_at', [$startDate, $endDate]);
    }

    /**
     * Mark callback as processed
     */
    public function markAsProcessed($notes = null)
    {
        $this->update([
            'processing_status' => self::PROCESSING_STATUSES['PROCESSED'],
            'processed_at' => now(),
            'processing_notes' => $notes,
        ]);
    }

    /**
     * Mark callback as failed with error message
     */
    public function markAsFailed($errorMessage, $notes = null)
    {
        $this->update([
            'processing_status' => self::PROCESSING_STATUSES['FAILED'],
            'processed_at' => now(),
            'error_message' => $errorMessage,
            'processing_notes' => $notes,
        ]);
    }

    /**
     * Mark callback as matched
     */
    public function markAsMatched($paymentId, $notes = null)
    {
        $this->update([
            'processing_status' => self::PROCESSING_STATUSES['MATCHED'],
            'payment_id' => $paymentId,
            'processing_notes' => $notes,
        ]);
    }

    /**
     * Check if callback is unmatched
     */
    public function isUnmatched(): bool
    {
        return $this->processing_status === self::PROCESSING_STATUSES['UNMATCHED'];
    }

    /**
     * Check if callback is matched
     */
    public function isMatched(): bool
    {
        return $this->processing_status === self::PROCESSING_STATUSES['MATCHED'];
    }

    /**
     * Check if callback is processed
     */
    public function isProcessed(): bool
    {
        return $this->processing_status === self::PROCESSING_STATUSES['PROCESSED'];
    }

    /**
     * Check if callback processing failed
     */
    public function isFailed(): bool
    {
        return $this->processing_status === self::PROCESSING_STATUSES['FAILED'];
    }
}