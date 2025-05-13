<?php

namespace App\Console\Commands;

use App\Models\Account;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MarkExpiredAccounts extends Command
{
    protected $signature = 'accounts:mark-expired';
    protected $description = 'Mark accounts that have passed their expiration date';

    public function handle()
    {
        $this->info('Checking for expired accounts...');
        
        $expiredCount = Account::markExpiredAccounts();
        
        $this->info("Marked {$expiredCount} accounts as expired.");
        
        Log::info('Expired accounts marked', ['count' => $expiredCount]);
        
        return 0;
    }

// pp console kernery
   // $schedule->command('accounts:mark-expired')->hourly();


   //usage now 


//    <?php

// namespace App\Http\Controllers;

// use App\Services\AccountUsageService;
// use Illuminate\Http\Request;

// class ReportController extends Controller
// {
//     protected $accountUsageService;

//     public function __construct(AccountUsageService $accountUsageService)
//     {
//         $this->accountUsageService = $accountUsageService;
//     }

//     public function generateReport(Request $request)
//     {
//         $user = auth()->user();
//         $companyId = $user->company_id;

//         // Check if user has sufficient credits
//         if (!$this->accountUsageService->useCreditsForReport($user->id, $companyId, 1)) {
//             return response()->json([
//                 'message' => 'Insufficient credits or all accounts have expired. Please purchase more reports.',
//                 'remaining_reports' => Account::getTotalRemainingReports($user->id, $companyId),
//             ], 400);
//         }

//         // Generate report logic...
        
//         return response()->json([
//             'message' => 'Report generated successfully',
//             'remaining_reports' => Account::getTotalRemainingReports($user->id, $companyId),
//         ]);
//     }

//     public function getAccountSummary()
//     {
//         $user = auth()->user();
//         $summary = $this->accountUsageService->getAccountSummary($user->id, $user->company_id);
        
//         return response()->json($summary);
//     }
// }


}

