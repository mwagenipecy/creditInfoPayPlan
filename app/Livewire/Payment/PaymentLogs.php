<?php

namespace App\Livewire\Payment;

use App\Models\Payment;
use App\Models\User;
use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentLogs extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $networkFilter = '';
    public $userFilter = '';
    public $companyFilter = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $perPage = 15;
    public $viewMode = 'both'; // 'dashboard', 'table', 'both'
    public $dateRange = 'today'; // 'today', 'yesterday', 'last7days', 'last30days', 'custom'
    
    // Modal properties
    public $showDetailsModal = false;
    public $selectedPayment = null;
    
    protected $listeners = ['refreshPayments' => '$refresh'];
    
    public function mount()
    {
        $this->setDateRange();
    }

    private function setDateRange()
    {
        switch ($this->dateRange) {
            case 'today':
                $this->dateFrom = Carbon::today()->format('Y-m-d');
                $this->dateTo = Carbon::today()->format('Y-m-d');
                break;
            case 'yesterday':
                $this->dateFrom = Carbon::yesterday()->format('Y-m-d');
                $this->dateTo = Carbon::yesterday()->format('Y-m-d');
                break;
            case 'last7days':
                $this->dateFrom = Carbon::today()->subDays(6)->format('Y-m-d');
                $this->dateTo = Carbon::today()->format('Y-m-d');
                break;
            case 'last30days':
                $this->dateFrom = Carbon::today()->subDays(29)->format('Y-m-d');
                $this->dateTo = Carbon::today()->format('Y-m-d');
                break;
        }
    }

    // Modal methods
    public function showPaymentDetails($paymentId)
    {
        $this->selectedPayment = Payment::with(['user:id,name,email', 'company:id,company_name'])->find($paymentId);
        $this->showDetailsModal = true;
    }

    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->selectedPayment = null;
    }

    public function updatedDateRange()
    {
        if ($this->dateRange !== 'custom') {
            $this->setDateRange();
        }
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedNetworkFilter()
    {
        $this->resetPage();
    }

    public function updatedUserFilter()
    {
        $this->resetPage();
    }

    public function updatedCompanyFilter()
    {
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->dateRange = 'custom';
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->dateRange = 'custom';
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->networkFilter = '';
        $this->userFilter = '';
        $this->companyFilter = '';
        $this->dateRange = 'today';
        $this->setDateRange();
        $this->resetPage();
    }

    public function exportCsv()
    {
        $payments = $this->getPayments();
        
        $csvData = [];
        $csvData[] = [
            'ID', 'Order ID', 'Network', 'User ID', 'Company ID', 
            'Mobile Number', 'Amount', 'Status', 'Payment Reference',
            'Token Number', 'Created At', 'Payment Initiated', 'Payment Completed'
        ];
        
        foreach ($payments as $payment) {
            $csvData[] = [
                $payment->id,
                $payment->order_id,
                $payment->network_type,
                $payment->user_id,
                $payment->company_id,
                $payment->mobile_number,
                $payment->amount,
                $payment->status,
                $payment->payment_reference,
                $payment->token_number,
                $payment->created_at->format('Y-m-d H:i:s'),
                $payment->payment_initiated_at ? $payment->payment_initiated_at->format('Y-m-d H:i:s') : '',
                $payment->payment_completed_at ? $payment->payment_completed_at->format('Y-m-d H:i:s') : '',
            ];
        }
        
        $filename = 'payment-logs-' . Carbon::now()->format('Y-m-d-H-i-s') . '.csv';
        
        return response()->streamDownload(function () use ($csvData) {
            $handle = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function getStatusStats()
    {
        return Payment::query()
            ->when($this->dateFrom, fn($query) => $query->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($query) => $query->whereDate('created_at', '<=', $this->dateTo))
            ->selectRaw('status, COUNT(*) as count, SUM(amount) as total_amount')
            ->groupBy('status')
            ->get()
            ->mapWithKeys(fn($item) => [
                $item->status => [
                    'count' => $item->count,
                    'total_amount' => $item->total_amount,
                    'percentage' => 0
                ]
            ])
            ->toArray();
    }

    public function getNetworkStats()
    {
        return Payment::query()
            ->when($this->dateFrom, fn($query) => $query->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($query) => $query->whereDate('created_at', '<=', $this->dateTo))
            ->selectRaw('network_type, COUNT(*) as count, SUM(amount) as total_amount')
            ->groupBy('network_type')
            ->get()
            ->mapWithKeys(fn($item) => [
                $item->network_type => [
                    'count' => $item->count,
                    'total_amount' => $item->total_amount
                ]
            ])
            ->toArray();
    }

    public function getHourlyTrend()
    {
        return Payment::query()
            ->when($this->dateFrom, fn($query) => $query->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($query) => $query->whereDate('created_at', '<=', $this->dateTo))
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count, SUM(amount) as total_amount')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->mapWithKeys(fn($item) => [
                str_pad($item->hour, 2, '0', STR_PAD_LEFT) . ':00' => [
                    'count' => $item->count,
                    'total_amount' => $item->total_amount
                ]
            ])
            ->toArray();
    }

    public function getSuccessRate()
    {
        $total = Payment::query()
            ->when($this->dateFrom, fn($query) => $query->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($query) => $query->whereDate('created_at', '<=', $this->dateTo))
            ->count();

        $successful = Payment::query()
            ->when($this->dateFrom, fn($query) => $query->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($query) => $query->whereDate('created_at', '<=', $this->dateTo))
            ->where('status', 'completed')
            ->count();

        return $total > 0 ? round(($successful / $total) * 100, 2) : 0;
    }

    public function getTotalAmount()
    {
        return Payment::query()
            ->when($this->dateFrom, fn($query) => $query->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($query) => $query->whereDate('created_at', '<=', $this->dateTo))
            ->sum('amount');
    }

    // Add this method to get total payments count for the summary stats
    public function getTotalPayments()
    {
        return Payment::query()
            ->when($this->dateFrom, fn($query) => $query->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($query) => $query->whereDate('created_at', '<=', $this->dateTo))
            ->count();
    }

    public function getPayments()
    {
        $query = Payment::query()
            ->with(['user:id,name,email', 'company:id,company_name'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('order_id', 'like', '%' . $this->search . '%')
                      ->orWhere('mobile_number', 'like', '%' . $this->search . '%')
                      ->orWhere('payment_reference', 'like', '%' . $this->search . '%')
                      ->orWhere('token_number', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, fn($query) => $query->where('status', $this->statusFilter))
            ->when($this->networkFilter, fn($query) => $query->where('network_type', $this->networkFilter))
            ->when($this->userFilter, fn($query) => $query->where('user_id', $this->userFilter))
            ->when($this->companyFilter, fn($query) => $query->where('company_id', $this->companyFilter))
            ->when($this->dateFrom, fn($query) => $query->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($query) => $query->whereDate('created_at', '<=', $this->dateTo))
            ->orderBy('created_at', 'desc');

        return $this->perPage === 'all' ? $query->get() : $query->paginate($this->perPage);
    }

    public function getStatusBadgeClass($status)
    {
        return match($status) {
            'completed' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            'expired' => 'bg-orange-100 text-orange-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getNetworkBadgeClass($network)
    {
        return match($network) {
            'MTN' => 'bg-yellow-100 text-yellow-800',
            'VODACOM' => 'bg-red-100 text-red-800',
            'AIRTEL' => 'bg-blue-100 text-blue-800',
            'TIGO' => 'bg-green-100 text-green-800',
            'TTCL' => 'bg-purple-100 text-purple-800',
            'TPESA' => 'bg-indigo-100 text-indigo-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function render()
    {
        $statusStats = $this->getStatusStats();
        $totalTransactions = array_sum(array_column($statusStats, 'count'));
        
        // Calculate percentages
        foreach ($statusStats as $status => &$data) {
            $data['percentage'] = $totalTransactions > 0 ? round(($data['count'] / $totalTransactions) * 100, 2) : 0;
        }

        return view('livewire.payment.payment-logs', [
            'payments' => $this->getPayments(),
            'users' => User::select('id', 'name')->get(),
            'companies' => Company::select('id', 'company_name as name')->get(), // Fixed to match view expectation
            'statusStats' => $statusStats,
            'networkStats' => $this->getNetworkStats(),
            'hourlyTrend' => $this->getHourlyTrend(),
            'successRate' => $this->getSuccessRate(),
            'totalAmount' => $this->getTotalAmount(),
            'totalPayments' => $this->getTotalPayments(), // Added this for the summary stats
            'totalTransactions' => $totalTransactions,
        ]);
    }
}