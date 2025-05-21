<?php

namespace App\Livewire\Document;

use Livewire\Component;
use App\Models\Company;
use Livewire\WithPagination;
use Carbon\Carbon;

class DocumentList extends Component
{
    use WithPagination;
    
    // Filter properties
    public $status = '';
    public $dateRange = '';
    public $search = '';

    public $hasRegisterTheCompany=false;
    
    // Reset pagination when filters change
    public function updatingStatus()
    {
        $this->resetPage();
    }
    
    public function updatingDateRange()
    {
        $this->resetPage();
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function applyFilters()
    {
        $this->resetPage();
    }
    
    public function resetFilters()
    {
        $this->status = '';
        $this->dateRange = '';
        $this->search = '';
        $this->resetPage();
    }
    
    /**
     * Calculate analytics statistics for the dashboard
     */
    private function getAnalyticsStats()
    {
        // Get total companies count
        $totalCompanies = Company::count();
        
        // Get companies created this month
        $companiesThisMonth = Company::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        // Get counts by status
        $statusCounts = [
            'draft' => Company::where('verification_status', 'draft')->count(),
            'pending_review' => Company::where('verification_status', 'pending_review')->count(),
            'approved' => Company::where('verification_status', 'approved')->count(),
            'rejected' => Company::where('verification_status', 'rejected')->count(),
            'changes_requested' => Company::where('verification_status', 'changes_requested')->count(),
        ];
        
        // Calculate status percentages
        $statusPercentages = [];
        foreach ($statusCounts as $status => $count) {
            $statusPercentages[$status] = $totalCompanies > 0 ? round(($count / $totalCompanies) * 100) : 0;
        }
        
        // Calculate approval rate
        $approvalRate = 0;
        $processedCompanies = $statusCounts['approved'] + $statusCounts['rejected'];
        if ($processedCompanies > 0) {
            $approvalRate = round(($statusCounts['approved'] / $processedCompanies) * 100);
        }
        
        // Calculate pending review change percentage (compared to last week)
        $pendingLastWeek = Company::where('verification_status', 'pending_review')
            ->where('updated_at', '<', Carbon::now()->subWeek())
            ->count();
        
        $pendingReviewChange = 0;
        if ($pendingLastWeek > 0) {
            $pendingReviewChange = round((($statusCounts['pending_review'] - $pendingLastWeek) / $pendingLastWeek) * 100);
        }
        
        // Calculate missing documents
        $totalMissingDocuments = Company::with('documents')
            ->get()
            ->sum(function ($company) {
                return $company->required_documents_count - $company->completed_documents_count;
            });

       $companObj=new Company();
        
        // Calculate document completion rate
        $totalRequiredDocuments = 6;
        $totalCompletedDocuments =$companObj->getCompletedDocumentsCountAttribute() ; //TODO
        $documentCompletionRate = 0;
        
        if ($totalRequiredDocuments > 0) {
            $documentCompletionRate = round(($totalCompletedDocuments / $totalRequiredDocuments) * 100);
        }
        
        return [
            'total_companies' => $totalCompanies,
            'companies_this_month' => $companiesThisMonth,
            'status_counts' => $statusCounts,
            'status_percentages' => $statusPercentages,
            'pending_review' => $statusCounts['pending_review'],
            'pending_review_change' => $pendingReviewChange,
            'approved' => $statusCounts['approved'],
            'approval_rate' => $approvalRate,
            'missing_documents' => $totalMissingDocuments,
            'document_completion_rate' => $documentCompletionRate,
        ];
    }
    
    public function render()
    {

        if(Company::where('id',auth()->user()->company_id)->exists()){
            $this->hasRegisterTheCompany=true;
        }


        $query = Company::query();
        
        // Apply status filter
        if ($this->status) {
            $query->where('verification_status', $this->status);
        }
        
        // Apply date range filter
        switch ($this->dateRange) {
            case 'today':
                $query->whereDate('updated_at', Carbon::today());
                break;
            case 'week':
                $query->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                break;
            case 'quarter':
                $query->whereBetween('updated_at', [Carbon::now()->subMonths(3), Carbon::now()]);
                break;
        }
        
        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('company_name', 'like', '%' . $this->search . '%')
                  ->orWhere('trading_name', 'like', '%' . $this->search . '%')
                  ->orWhere('registration_number', 'like', '%' . $this->search . '%')
                  ->orWhere('primary_email', 'like', '%' . $this->search . '%');
            });
        }
        
        if(auth()->user()->role_id==1){

        }else{

            $query->where('id',auth()->user()->company_id);
        }
        // Get companies with eager loading of documents for efficiency
        $companies = $query->with('documents')->latest('updated_at')->paginate(10);
        
        // Add document counts to each company
        foreach ($companies as $company) {
            $company->completedDocumentsCount = $company->completed_documents_count;
            $company->requiredDocumentsCount = $company->required_documents_count;
        }
        
        return view('livewire.document.document-list', [
            'companies' => $companies,
            'stats' => $this->getAnalyticsStats(),
        ]);
    }

    public function getStatusColor($status)
    {
        switch ($status) {
            case 'draft':
                return 'bg-gray-100 text-gray-700';
            case 'pending_review':
                return 'bg-yellow-100 text-yellow-700';
            case 'approved':
                return 'bg-green-100 text-green-700';
            case 'rejected':
                return 'bg-red-100 text-red-700';
            case 'changes_requested':
                return 'bg-blue-100 text-blue-700';
            default:
                return 'bg-gray-100 text-gray-700';
        }
    }
    
    /**
     * Get a color for status bar charts
     */
    public function getStatusBarColor($status)
    {
        switch ($status) {
            case 'draft':
                return 'bg-gray-500';
            case 'pending_review':
                return 'bg-yellow-500';
            case 'approved':
                return 'bg-green-500';
            case 'rejected':
                return 'bg-red-500';
            case 'changes_requested':
                return 'bg-blue-500';
            default:
                return 'bg-gray-500';
        }
    }

    /**
     * Get a readable status label
     */
    public function getStatusLabel($status)
    {
        switch ($status) {
            case 'draft':
                return 'Draft';
            case 'pending_review':
                return 'Submitted';
            case 'approved':
                return 'Approved';
            case 'rejected':
                return 'Rejected';
            case 'changes_requested':
                return 'Changes Requested';
            default:
                return ucfirst($status);
        }
    }

    /**
     * Get a background color for company avatar based on company name
     */
    public function getCompanyColor($company)
    {
        $colors = [
            'bg-[#C40F12]',  // Brand red
            'bg-blue-500',
            'bg-green-500',
            'bg-purple-500',
            'bg-yellow-500',
            'bg-indigo-500',
            'bg-pink-500',
            'bg-teal-500'
        ];
        
        // Use the first character of company name to determine color
        $firstChar = strtolower(substr($company->company_name, 0, 1));
        $index = (ord($firstChar) - ord('a')) % count($colors);
        
        if ($index < 0) {
            $index = 0; // Default to first color for non-alphabetic characters
        }
        
        return $colors[$index];
    }
}