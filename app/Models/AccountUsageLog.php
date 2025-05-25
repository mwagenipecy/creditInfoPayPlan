<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountUsageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'reports_used',
        'remaining_reports',
        'action_type',
        'metadata',
        'used_at',
    ];

    protected $casts = [
        'used_at' => 'datetime',
        'metadata' => 'array',
        'reports_used' => 'integer',
        'remaining_reports' => 'integer',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }


    // Action type constants
    const ACTION_TYPES = [
        'REPORT_GENERATION' => 'report_generation',
        'ACCOUNT_CLOSURE' => 'account_closure',
        'MANUAL_ADJUSTMENT' => 'manual_adjustment',
        'REFUND' => 'refund',
        'BONUS_ALLOCATION' => 'bonus_allocation',
    ];

    /**
     * Get the account that this usage log belongs to
     */


    /**
     * Scope to get usage logs for a specific account
     */
    public function scopeForAccount($query, $accountId)
    {
        return $query->where('account_id', $accountId);
    }

    /**
     * Scope to get usage logs by action type
     */
    public function scopeByActionType($query, $actionType)
    {
        return $query->where('action_type', $actionType);
    }

    /**
     * Scope to get usage logs within a date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('used_at', [$startDate, $endDate]);
    }

    /**
     * Scope to get recent usage logs
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('used_at', '>=', now()->subDays($days));
    }

    /**
     * Check if this log is for report generation
     */
    public function isReportGeneration(): bool
    {
        return $this->action_type === self::ACTION_TYPES['REPORT_GENERATION'];
    }

    /**
     * Check if this log is for account closure
     */
    public function isAccountClosure(): bool
    {
        return $this->action_type === self::ACTION_TYPES['ACCOUNT_CLOSURE'];
    }

    /**
     * Get the user who triggered this usage (from metadata)
     */
    public function getTriggeredByUserAttribute()
    {
        return $this->metadata['user_id'] ?? null;
    }

    /**
     * Get the creditinfo_id related to this usage (from metadata)
     */
    public function getCreditinfoIdAttribute()
    {
        return $this->metadata['creditinfo_id'] ?? null;
    }



}
