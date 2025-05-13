<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\AccountUsageLog;
use Carbon\Carbon;
class AccountUsageLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get all accounts
        $accounts = Account::all();
        
        foreach ($accounts as $account) {
            // Create some sample usage logs
            $usageCount = rand(1, $account->total_reports - $account->remaining_reports);
            
            for ($i = 0; $i < $usageCount; $i++) {
                AccountUsageLog::create([
                    'account_id' => $account->id,
                    'reports_used' => 1,
                    'remaining_reports' => $account->remaining_reports + ($usageCount - $i),
                    'action_type' => 'report_generation',
                    'used_at' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
                ]);
            }
        }
    }


}
