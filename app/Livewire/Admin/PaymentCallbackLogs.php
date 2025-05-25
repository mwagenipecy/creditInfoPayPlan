<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PaymentCallbackLog;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PaymentCallbackLogs extends Component
{
    use WithPagination;

    // Filter properties
    public $searchTerm = '';
    public $callbackStatusFilter = 'all';
    public $processingStatusFilter = 'all';
    public $dateFrom = '';
    public $dateTo = '';
    public $perPage = 20;
    
    // Modal properties
    public $showDetailsModal = false;
    public $selectedLog = null;
    public $showProcessModal = false;
    
    // Processing form properties
    public $manualOrderId = '';
    public $processAction = 'match';
    public $processNotes = '';
    
    protected $queryString = [
        'searchTerm' => ['except' => ''],
        'callbackStatusFilter' => ['except' => 'all'],
        'processingStatusFilter' => ['except' => 'all'],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
        'perPage' => ['except' => 20],
    ];

    public function mount()
    {
        // Set default date range to last 7 days
        $this->dateTo = now()->format('Y-m-d');
        $this->dateFrom = now()->subDays(7)->format('Y-m-d');
    }

    // Update methods for filters
    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    public function updatedCallbackStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedProcessingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    // Get callback logs with filters
    private function getCallbackLogs()
    {
        $query = PaymentCallbackLog::query();

        // Apply search filter
        if (!empty($this->searchTerm)) {
            $query->where(function($q) {
                $q->where('order_id', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('payment_reference', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('transaction_id', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('source_ip', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Apply callback status filter
        if ($this->callbackStatusFilter !== 'all') {
            $query->where('callback_status', $this->callbackStatusFilter);
        }

        // Apply processing status filter
        if ($this->processingStatusFilter !== 'all') {
            $query->where('processing_status', $this->processingStatusFilter);
        }

        // Apply date range filter
        if (!empty($this->dateFrom)) {
            $query->where('callback_received_at', '>=', $this->dateFrom . ' 00:00:00');
        }

        if (!empty($this->dateTo)) {
            $query->where('callback_received_at', '<=', $this->dateTo . ' 23:59:59');
        }

        return $query->latest('callback_received_at')->paginate($this->perPage);
    }

    // Get summary statistics
    private function getStatistics()
    {
        $baseQuery = PaymentCallbackLog::query();

        // Apply date filter to statistics
        if (!empty($this->dateFrom)) {
            $baseQuery->where('callback_received_at', '>=', $this->dateFrom . ' 00:00:00');
        }
        if (!empty($this->dateTo)) {
            $baseQuery->where('callback_received_at', '<=', $this->dateTo . ' 23:59:59');
        }

        $totalCallbacks = $baseQuery->count();
        $matchedCallbacks = $baseQuery->where('processing_status', 'matched')->count();
        $unmatchedCallbacks = $baseQuery->where('processing_status', 'unmatched')->count();
        $processedCallbacks = $baseQuery->where('processing_status', 'processed')->count();
        $failedCallbacks = $baseQuery->where('processing_status', 'failed')->count();
        $successfulCallbacks = $baseQuery->where('callback_status', 'success')->count();
        
        $successRate = $totalCallbacks > 0 ? round(($processedCallbacks / $totalCallbacks) * 100, 1) : 0;
        $matchRate = $totalCallbacks > 0 ? round(($matchedCallbacks / $totalCallbacks) * 100, 1) : 0;

        return [
            'total_callbacks' => $totalCallbacks,
            'matched_callbacks' => $matchedCallbacks,
            'unmatched_callbacks' => $unmatchedCallbacks,
            'processed_callbacks' => $processedCallbacks,
            'failed_callbacks' => $failedCallbacks,
            'successful_callbacks' => $successfulCallbacks,
            'success_rate' => $successRate,
            'match_rate' => $matchRate,
        ];
    }

    // Show callback details modal
    public function showDetails($logId)
    {
        $this->selectedLog = PaymentCallbackLog::find($logId);
        $this->showDetailsModal = true;
    }

    // Close details modal
    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->selectedLog = null;
    }

    // Show process modal for unmatched callbacks
    public function showProcessModal($logId)
    {
        $this->selectedLog = PaymentCallbackLog::find($logId);
        $this->showProcessModal = true;
        $this->manualOrderId = '';
        $this->processAction = 'match';
        $this->processNotes = '';
    }

    // Close process modal
    public function closeProcessModal()
    {
        $this->showProcessModal = false;
        $this->selectedLog = null;
        $this->manualOrderId = '';
        $this->processAction = 'match';
        $this->processNotes = '';
    }

    // Process unmatched callback manually
    public function processCallback()
    {
        if (!$this->selectedLog) {
            session()->flash('error', 'No callback selected for processing.');
            return;
        }

        if ($this->selectedLog->processing_status !== 'unmatched') {
            session()->flash('error', 'Only unmatched callbacks can be processed.');
            return;
        }

        $validator = Validator::make([
            'manualOrderId' => $this->manualOrderId,
            'processAction' => $this->processAction,
            'processNotes' => $this->processNotes,
        ], [
            'manualOrderId' => 'required_if:processAction,match|string',
            'processAction' => 'required|in:match,ignore',
            'processNotes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                session()->flash('error', $error);
            }
            return;
        }

        try {
            DB::beginTransaction();

            if ($this->processAction === 'match') {
                // Verify the payment exists
                $payment = Payment::where('order_id', $this->manualOrderId)->first();
                
                if (!$payment) {
                    session()->flash('error', 'Payment with order ID "' . $this->manualOrderId . '" not found.');
                    return;
                }

                // Update callback log as matched
                $this->selectedLog->update([
                    'processing_status' => 'matched',
                    'payment_id' => $payment->id,
                    'processed_at' => now(),
                    'processing_notes' => 'Manually matched by admin: ' . ($this->processNotes ?: 'No additional notes'),
                ]);

                $message = 'Callback successfully matched to payment: ' . $this->manualOrderId;
            } else {
                // Mark callback as ignored/failed
                $this->selectedLog->update([
                    'processing_status' => 'failed',
                    'processed_at' => now(),
                    'error_message' => 'Manually ignored by admin',
                    'processing_notes' => 'Manually ignored by admin: ' . ($this->processNotes ?: 'No additional notes'),
                ]);

                $message = 'Callback marked as ignored.';
            }

            DB::commit();
            session()->flash('success', $message);
            $this->closeProcessModal();

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error processing callback: ' . $e->getMessage());
        }
    }

    // Bulk actions
    public function bulkIgnoreUnmatched()
    {
        try {
            $updated = PaymentCallbackLog::where('processing_status', 'unmatched')
                ->where('callback_received_at', '>=', now()->subDays(30))
                ->update([
                    'processing_status' => 'failed',
                    'processed_at' => now(),
                    'error_message' => 'Bulk ignored - old unmatched callback',
                    'processing_notes' => 'Bulk action: Ignored old unmatched callbacks',
                ]);

            session()->flash('success', "Bulk ignored {$updated} old unmatched callbacks.");
        } catch (\Exception $e) {
            session()->flash('error', 'Error in bulk action: ' . $e->getMessage());
        }
    }

    // Clear filters
    public function clearFilters()
    {
        $this->searchTerm = '';
        $this->callbackStatusFilter = 'all';
        $this->processingStatusFilter = 'all';
        $this->dateFrom = now()->subDays(7)->format('Y-m-d');
        $this->dateTo = now()->format('Y-m-d');
        $this->resetPage();
    }

    // Refresh data
    public function refreshData()
    {
        $this->resetPage();
        session()->flash('success', 'Data refreshed successfully.');
    }

    // Helper methods for display
    public function getStatusBadgeClass($status, $type = 'callback')
    {
        if ($type === 'callback') {
            return match($status) {
                'success' => 'bg-green-100 text-green-800',
                'failed' => 'bg-red-100 text-red-800',
                'pending' => 'bg-yellow-100 text-yellow-800',
                'cancelled' => 'bg-gray-100 text-gray-800',
                'unknown' => 'bg-purple-100 text-purple-800',
                default => 'bg-gray-100 text-gray-800',
            };
        } else {
            return match($status) {
                'matched' => 'bg-blue-100 text-blue-800',
                'unmatched' => 'bg-orange-100 text-orange-800',
                'processed' => 'bg-green-100 text-green-800',
                'failed' => 'bg-red-100 text-red-800',
                default => 'bg-gray-100 text-gray-800',
            };
        }
    }

    public function render()
    {
        return view('livewire.admin.payment-callback-logs', [
            'callbackLogs' => $this->getCallbackLogs(),
            'statistics' => $this->getStatistics(),
        ]);
    }
}