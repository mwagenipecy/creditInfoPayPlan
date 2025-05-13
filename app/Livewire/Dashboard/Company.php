<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Company as CompanyModal;
use App\Models\Document;
use App\Models\Account;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Company extends Component
{
    public $registrationProgress;
    public $accountStatus;
    public $statementStats;
    public $paymentStats;
    public $requiredDocuments;
    public $features;

    public function mount()
    {
        $this->calculateRegistrationProgress();
        $this->getAccountStatus();
        $this->getStatementStats();
        $this->getPaymentStats();
        $this->getRequiredDocuments();
        $this->getFeatureAccess();
    }

    private function calculateRegistrationProgress()
    {
        $user = Auth::user();
        $company = $user->company;
        
        $steps = [
            'self_registration' => [
                'title' => 'Self Registration',
                'description' => 'Personal account created',
                'completed' => true, // Always true for authenticated users
                'icon' => 'fas fa-check'
            ],
            'company_registration' => [
                'title' => 'Company Registration',
                'description' => $company ? 'Company details submitted' : 'Enter company details',
                'completed' => $company !== null,
                'icon' => $company ? 'fas fa-check' : 'fas fa-clock'
            ],
            'document_verification' => [
                'title' => 'Document Verification',
                'description' => $this->getDocumentVerificationStatus($company),
                'completed' => $company && $company->verification_status === 'verified',
                'icon' => $this->getDocumentVerificationIcon($company)
            ],
            'payment' => [
                'title' => 'Payment',
                'description' => $this->getPaymentStatus($company),
                'completed' => $this->hasValidSubscription($company),
                'icon' => $this->getPaymentIcon($company)
            ]
        ];

        $completedSteps = collect($steps)->filter(fn($step) => $step['completed'])->count();
        $totalSteps = count($steps);
        $progressPercentage = ($completedSteps / $totalSteps) * 100;

        $this->registrationProgress = [
            'steps' => $steps,
            'completedSteps' => $completedSteps,
            'totalSteps' => $totalSteps,
            'percentage' => $progressPercentage
        ];
    }

    private function getDocumentVerificationStatus($company)
    {
        if (!$company) return 'Upload required documents';
        
        switch ($company->verification_status) {
            case 'draft':
                return 'Upload required documents';
            case 'pending':
                return 'Documents under review';
            case 'verified':
                return 'Documents verified';
            case 'rejected':
                return 'Documents rejected - resubmit required';
            default:
                return 'Upload required documents';
        }
    }

    private function getDocumentVerificationIcon($company)
    {
        if (!$company) return 'fas fa-clock';
        
        switch ($company->verification_status) {
            case 'verified':
                return 'fas fa-check';
            case 'pending':
                return 'fas fa-clock';
            case 'rejected':
                return 'fas fa-times';
            default:
                return 'fas fa-clock';
        }
    }

    private function getPaymentStatus($company)
    {
        if (!$company || $company->verification_status !== 'verified') {
            return 'Complete subscription payment';
        }
        
        if ($this->hasValidSubscription($company)) {
            return 'Active subscription';
        }
        
        return 'Payment required';
    }

    private function getPaymentIcon($company)
    {
        if ($this->hasValidSubscription($company)) {
            return 'fas fa-check';
        }
        return 'fas fa-clock';
    }

    private function hasValidSubscription($company)
    {
        if (!$company) return false;
        
        return Account::where('company_id', $company->id)
            ->where('status', 'active')
            ->where('valid_until', '>', now())
            ->exists();
    }

    private function getAccountStatus()
    {
        $user = Auth::user();
        $company = $user->company;
        
        if (!$company) {
            $this->accountStatus = [
                'status' => 'pending_company_registration',
                'text' => 'Company Registration Required',
                'color' => 'yellow'
            ];
            return;
        }
        
        switch ($company->verification_status) {
            case 'draft':
                $this->accountStatus = [
                    'status' => 'pending_verification',
                    'text' => 'Pending Verification',
                    'color' => 'yellow'
                ];
                break;
            case 'pending':
                $this->accountStatus = [
                    'status' => 'under_review',
                    'text' => 'Under Review',
                    'color' => 'blue'
                ];
                break;
            case 'verified':
                if ($this->hasValidSubscription($company)) {
                    $this->accountStatus = [
                        'status' => 'active',
                        'text' => 'Account Active',
                        'color' => 'green'
                    ];
                } else {
                    $this->accountStatus = [
                        'status' => 'pending_payment',
                        'text' => 'Payment Required',
                        'color' => 'red'
                    ];
                }
                break;
            case 'rejected':
                $this->accountStatus = [
                    'status' => 'rejected',
                    'text' => 'Documents Rejected',
                    'color' => 'red'
                ];
                break;
            default:
                $this->accountStatus = [
                    'status' => 'pending_verification',
                    'text' => 'Pending Verification',
                    'color' => 'yellow'
                ];
        }
    }

    private function getStatementStats()
    {
        $user = Auth::user();
        $company = $user->company;
        
        if (!$company || !$this->hasValidSubscription($company)) {
            $this->statementStats = [
                'total_requests' => 0,
                'plan_limit' => 0,
                'remaining' => 0,
                'usage_percentage' => 0,
                'status' => 'inactive'
            ];
            return;
        }
        
        $account = Account::where('company_id', $company->id)
            ->where('status', 'active')
            ->where('valid_until', '>', now())
            ->first();
            
        if ($account) {
            $usedReports = $account->total_reports - $account->remaining_reports;
            $usagePercentage = $account->total_reports > 0 
                ? ($usedReports / $account->total_reports) * 100 
                : 0;
                
            $this->statementStats = [
                'total_requests' => $usedReports,
                'plan_limit' => $account->total_reports,
                'remaining' => $account->remaining_reports,
                'usage_percentage' => $usagePercentage,
                'status' => 'active'
            ];
        }
    }

    private function getPaymentStats()
    {
        $user = Auth::user();
        $company = $user->company;
        
        if (!$company) {
            $this->paymentStats = [
                'total_paid' => 0,
                'subscription_status' => 'not_active',
                'next_payment' => null,
                'payment_method' => 'none'
            ];
            return;
        }
        
        $totalPaid = Payment::where('company_id', $company->id)
            ->where('status', 'completed')
            ->sum('amount');
            
        $account = Account::where('company_id', $company->id)
            ->where('status', 'active')
            ->where('valid_until', '>', now())
            ->first();
            
        $subscriptionStatus = $account ? 'active' : 'not_active';
        $nextPayment = $account ? $account->valid_until->format('M d, Y') : null;
        
        $this->paymentStats = [
            'total_paid' => $totalPaid,
            'subscription_status' => $subscriptionStatus,
            'next_payment' => $nextPayment,
            'payment_method' => $account ? 'Mobile Money' : 'None'
        ];
    }

    private function getRequiredDocuments()
    {
        $user = Auth::user();
        $company = $user->company;
        
        $documents = [
            [
                'name' => 'Company Registration Certificate',
                'type' => 'certificate_of_incorporation',
                'icon' => 'fas fa-file-pdf',
                'required' => true,
                'status' => $this->getDocumentStatus($company, 'certificate_of_incorporation')
            ],
            [
                'name' => 'Tax Identification Document',
                'type' => 'tin_certificate',
                'icon' => 'fas fa-file-invoice',
                'required' => true,
                'status' => $this->getDocumentStatus($company, 'tin_certificate')
            ],
            [
                'name' => "Director's ID Proof",
                'type' => 'directors_id',
                'icon' => 'fas fa-id-card',
                'required' => true,
                'status' => $this->getDocumentStatus($company, 'directors_id')
            ]
        ];
        
        $this->requiredDocuments = $documents;
    }

    private function getDocumentStatus($company, $documentType)
    {
        if (!$company) return 'required';
        
        $document = Document::where('company_id', $company->id)
            ->where('document_type', $documentType)
            ->first();
            
        if (!$document) {
            return 'required';
        }
        
        return $document->status;
    }

    private function getFeatureAccess()
    {
        $user = Auth::user();
        $company = $user->company;
        $isActive = $this->hasValidSubscription($company);
        
        $this->features = [
            'user_management' => [
                'title' => 'User Management',
                'description' => 'Add and manage users in your organization',
                'available' => $isActive,
                'icon' => 'fas fa-users'
            ],
            'usage_reports' => [
                'title' => 'Usage Reports',
                'description' => 'Track credit information usage and generate detailed reports',
                'available' => $isActive,
                'icon' => 'fas fa-chart-line'
            ]
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.company', [
            'registrationProgress' => $this->registrationProgress,
            'accountStatus' => $this->accountStatus,
            'statementStats' => $this->statementStats,
            'paymentStats' => $this->paymentStats,
            'requiredDocuments' => $this->requiredDocuments,
            'features' => $this->features
        ]);
    }
}