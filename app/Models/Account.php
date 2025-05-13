<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Correct namespace

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_number',
        'company_id',
        'user_id',
        'payment_id',
        'total_reports',
        'remaining_reports',
        'status',
        'last_used',
        'valid_from',
        'valid_until',
        'amount_paid',
        'package_type',
    ];

    protected $casts = [
        'last_used' => 'datetime',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'amount_paid' => 'decimal:2',
        'total_reports' => 'integer',
        'remaining_reports' => 'integer',
    ];

    // Define the allowed status values
    public const STATUSES = [
        'ACTIVE' => 'active',
        'INACTIVE' => 'inactive',
        'SUSPENDED' => 'suspended',
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

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function usageLogs()
    {
        return $this->hasMany(AccountUsageLog::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUSES['ACTIVE'])
                    ->where('valid_until', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('valid_until', '<', now())
                    ->orWhere('status', self::STATUSES['EXPIRED']);
    }

    public function scopeValidAccounts($query)
    {
        return $query->where('valid_from', '<=', now())
                    ->where('valid_until', '>', now())
                    ->where('status', self::STATUSES['ACTIVE']);
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Helper methods
    public function isActive()
    {
        return $this->status === self::STATUSES['ACTIVE'] && !$this->isExpired();
    }

    public function isExpired()
    {
        return $this->valid_until && $this->valid_until->isPast();
    }

    public function hasRemainingReports()
    {
        return $this->remaining_reports > 0 && $this->isActive();
    }

    public function daysRemaining()
    {
        if (!$this->valid_until) return 0;
        return max(0, now()->diffInDays($this->valid_until, false));
    }

    // Generate unique account number
    public static function generateAccountNumber($companyId, $userId)
    {
        $prefix = 'ACC';
        $timestamp = now()->format('Ymd');
        $companyCode = str_pad($companyId, 3, '0', STR_PAD_LEFT);
        $random = str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        
        do {
            $accountNumber = $prefix . $timestamp . $companyCode . $random;
            $exists = self::where('account_number', $accountNumber)->exists();
            if ($exists) {
                $random = str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
            }
        } while ($exists);
        
        return $accountNumber;
    }

    // Use credits (deduct reports)
    public function useCredits($reportsUsed = 1)
    {
        if (!$this->isActive()) {
            Log::warning('Attempted to use credits on inactive/expired account', [
                'account_id' => $this->id,
                'account_number' => $this->account_number,
                'status' => $this->status,
                'expired' => $this->isExpired(),
            ]);
            return false;
        }

        if (!$this->hasRemainingReports()) {
            Log::warning('Attempted to use credits on account with no remaining reports', [
                'account_id' => $this->id,
                'account_number' => $this->account_number,
                'remaining_reports' => $this->remaining_reports,
            ]);
            return false;
        }

        if ($this->remaining_reports < $reportsUsed) {
            Log::warning('Insufficient credits for request', [
                'account_id' => $this->id,
                'requested' => $reportsUsed,
                'available' => $this->remaining_reports,
            ]);
            return false;
        }

        Log::info('Using credits from account', [
            'account_id' => $this->id,
            'account_number' => $this->account_number,
            'reports_used' => $reportsUsed,
        ]);

        $this->update([
            'remaining_reports' => $this->remaining_reports - $reportsUsed,
            'last_used' => now(),
        ]);

        // Check if account should be marked as used up
        if ($this->remaining_reports <= 0) {
            $this->update(['status' => self::STATUSES['INACTIVE']]);
        }

        // Log the usage
        AccountUsageLog::create([
            'account_id' => $this->id,
            'reports_used' => $reportsUsed,
            'remaining_reports' => $this->remaining_reports,
            'action_type' => 'report_generation',
            'used_at' => now(),
        ]);

        Log::info('Credits used successfully', [
            'account_id' => $this->id,
            'new_remaining_reports' => $this->remaining_reports,
        ]);

        return true;
    }

    // Get total remaining reports for a user across all valid accounts
    public static function getTotalRemainingReports($userId, $companyId)
    {
        return self::where('user_id', $userId)
                  ->where('company_id', $companyId)
                  ->validAccounts()
                  ->sum('remaining_reports');
    }

    // Get the best account to use (oldest first, FIFO)
    public static function getAccountToUse($userId, $companyId)
    {
        return self::where('user_id', $userId)
                  ->where('company_id', $companyId)
                  ->validAccounts()
                  ->where('remaining_reports', '>', 0)
                  ->orderBy('valid_until', 'asc') // Use oldest accounts first
                  ->first();
    }

    // Mark expired accounts
    public static function markExpiredAccounts()
    {
        $expired = self::where('valid_until', '<', now())
                      ->where('status', '!=', self::STATUSES['EXPIRED'])
                      ->get();

        foreach ($expired as $account) {
            $account->update(['status' => self::STATUSES['EXPIRED']]);
            Log::info('Account marked as expired', [
                'account_id' => $account->id,
                'account_number' => $account->account_number,
                'expired_at' => $account->valid_until,
            ]);
        }

        return $expired->count();
    }
    
}
