<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Support\Facades\Log;

class AccountUsageService
{
    /**
     * Use credits for report generation
     * Uses FIFO (First In, First Out) approach for account usage
     */
    public function useCreditsForReport($userId, $companyId, $reportsNeeded = 1)
    {
        Log::info('Attempting to use credits for report', [
            'user_id' => $userId,
            'company_id' => $companyId,
            'reports_needed' => $reportsNeeded,
        ]);

        // Get total available reports across all valid accounts
        $totalAvailable = Account::getTotalRemainingReports($userId, $companyId);

        if ($totalAvailable < $reportsNeeded) {
            Log::warning('Insufficient credits across all accounts', [
                'user_id' => $userId,
                'total_available' => $totalAvailable,
                'reports_needed' => $reportsNeeded,
            ]);
            return false;
        }

        // Use credits from accounts (FIFO approach)
        $remainingToUse = $reportsNeeded;
        
        while ($remainingToUse > 0) {
            $account = Account::getAccountToUse($userId, $companyId);
            
            if (!$account) {
                Log::error('No valid account found despite having total credits', [
                    'user_id' => $userId,
                    'total_available' => $totalAvailable,
                    'remaining_to_use' => $remainingToUse,
                ]);
                return false;
            }

            $canUse = min($remainingToUse, $account->remaining_reports);
            
            if ($account->useCredits($canUse)) {
                $remainingToUse -= $canUse;
                Log::info('Used credits from account', [
                    'account_id' => $account->id,
                    'credits_used' => $canUse,
                    'remaining_to_use' => $remainingToUse,
                ]);
            } else {
                Log::error('Failed to use credits from account', [
                    'account_id' => $account->id,
                    'attempted_use' => $canUse,
                ]);
                return false;
            }
        }

        Log::info('Successfully used all required credits', [
            'user_id' => $userId,
            'reports_used' => $reportsNeeded,
        ]);

        return true;
    }

    /**
     * Get account summary for a user
     */
    public function getAccountSummary($userId, $companyId)
    {
        $accounts = Account::where('user_id', $userId)
                          ->where('company_id', $companyId)
                          ->orderBy('valid_until', 'asc')
                          ->get();

        $summary = [
            'total_accounts' => $accounts->count(),
            'active_accounts' => $accounts->where('status', Account::STATUSES['ACTIVE'])->count(),
            'expired_accounts' => $accounts->where('status', Account::STATUSES['EXPIRED'])->count(),
            'total_remaining_reports' => Account::getTotalRemainingReports($userId, $companyId),
            'accounts' => $accounts->map(function ($account) {
                return [
                    'account_number' => $account->account_number,
                    'remaining_reports' => $account->remaining_reports,
                    'days_remaining' => $account->daysRemaining(),
                    'status' => $account->status,
                    'expires_at' => $account->valid_until,
                ];
            }),
        ];

        return $summary;
    }
}