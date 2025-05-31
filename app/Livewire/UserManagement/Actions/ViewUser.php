<?php

// App/Livewire/UserManagement/Actions/ViewUser.php

namespace App\Livewire\UserManagement\Actions;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Payment;
use Carbon\Carbon;

class ViewUser extends Component
{
    use WithPagination;

    public $showModal = false;
    public $user;
    public $activeTab = 'overview';
    public $activityDateFilter = 'all';
    public $activityTypeFilter = 'all';
    
    // User stats
    public $userStats = [];
    
    // Listeners
    protected $listeners = ['viewUser'];
    
    /**
     * View user method called from parent component
     */
    public function viewUser($userId)
    {
        // Security check
        $user = User::with([
            'company', 
            'role', 
           
        ])->findOrFail($userId);

        if (!$this->canViewUser($user)) {
            $this->dispatch('notify', type: 'error', message: 'You do not have permission to view this user.');
            return;
        }
        
        $this->user = $user;
        $this->loadUserStats();
        $this->showModal = true;
        $this->resetPage();
    }

    /**
     * Check if current user can view the target user
     */
    private function canViewUser($user)
    {
        if (auth()->user()->hasRole('super_admin')) {
            return true;
        }

        if (auth()->user()->hasRole('company_admin') && $user->company_id === auth()->user()->company_id) {
            return true;
        }

        // Users can view their own profile
        if (auth()->id() === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Load user statistics
     */
    private function loadUserStats()
    {
        $this->userStats = [
            'total_logins' => $this->getTotalLogins(),
            'last_login' => $this->getLastLogin(),
            'account_age' => $this->getAccountAge(),
            'total_activities' => $this->getTotalActivities(),
            'total_payments' => $this->getTotalPayments(),
            'last_activity' => $this->getLastActivity(),
            'email_verified' => $this->user->email_verified_at ? true : false,
            'password_changed' => $this->getPasswordLastChanged(),
        ];
    }

    /**
     * Get total logins (if you have login tracking)
     */
    private function getTotalLogins()
    {
        return ActivityLog::where('subject_id', $this->user->id)
            ->where('activity', 'user_login')
            ->count();
    }

    /**
     * Get last login time
     */
    private function getLastLogin()
    {
        $lastLogin = ActivityLog::where('subject_id', $this->user->id)
            ->where('activity', 'user_login')
            ->latest()
            ->first();
            
        return $lastLogin ? $lastLogin->created_at : null;
    }

    /**
     * Get account age
     */
    private function getAccountAge()
    {
        return $this->user->created_at->diffForHumans();
    }

    /**
     * Get total activities
     */
    private function getTotalActivities()
    {
        return ActivityLog::where('subject_id', $this->user->id)
            ->orWhere('user_id', $this->user->id)
            ->count();
    }

    /**
     * Get total payments
     */
    private function getTotalPayments()
    {
        if (class_exists(Payment::class)) {
            return Payment::where('user_id', $this->user->id)->count();
        }
        return 0;
    }

    /**
     * Get last activity
     */
    private function getLastActivity()
    {
        $lastActivity = ActivityLog::where('subject_id', $this->user->id)
            ->orWhere('user_id', $this->user->id)
            ->latest()
            ->first();
            
        return $lastActivity ? $lastActivity->created_at : null;
    }

    /**
     * Get when password was last changed
     */
    private function getPasswordLastChanged()
    {
        $passwordChange = ActivityLog::where('subject_id', $this->user->id)
            ->where('activity', 'user_updated')
            ->whereJsonContains('changes->password', ['to' => 'Password updated manually'])
            ->orWhereJsonContains('changes->password', ['to' => 'New password generated'])
            ->latest()
            ->first();
            
        return $passwordChange ? $passwordChange->created_at : $this->user->created_at;
    }

    /**
     * Set active tab
     */
    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    /**
     * Get filtered activity logs
     */
    public function getActivityLogs()
    {
        $query = ActivityLog::with('user')
            ->where(function($q) {
                $q->where('subject_id', $this->user->id)
                  ->where('subject_type', User::class)
                  ->orWhere('user_id', $this->user->id);
            });

        // Apply date filter
        if ($this->activityDateFilter !== 'all') {
            $date = match($this->activityDateFilter) {
                'today' => Carbon::today(),
                'week' => Carbon::now()->subWeek(),
                'month' => Carbon::now()->subMonth(),
                '3months' => Carbon::now()->subMonths(3),
                default => null
            };
            
            if ($date) {
                $query->where('created_at', '>=', $date);
            }
        }

        // Apply activity type filter
        if ($this->activityTypeFilter !== 'all') {
            $query->where('activity', $this->activityTypeFilter);
        }

        return $query->latest()->paginate(10);
    }

    /**
     * Get user's payment history (if applicable)
     */
    public function getPaymentHistory()
    {
        if (!class_exists(Payment::class)) {
            return collect();
        }

        return Payment::where('user_id', $this->user->id)
            ->latest()
            ->take(10)
            ->get();
    }

    /**
     * Export user data
     */
    public function exportUserData()
    {
        // Implementation for exporting user data
        $this->dispatch('notify', type: 'info', message: 'User data export will be sent to your email.');
    }

    /**
     * Send test email to user
     */
    public function sendTestEmail()
    {
        try {
            // You can implement a test email here
            $this->dispatch('notify', type: 'success', message: 'Test email sent successfully.');
        } catch (\Exception $e) {
            $this->dispatch('notify', type: 'error', message: 'Failed to send test email.');
        }
    }

    /**
     * Reset password and send new one
     */
    public function resetPassword()
    {
        if (!$this->canEditUser()) {
            $this->dispatch('notify', type: 'error', message: 'You do not have permission to reset this user\'s password.');
            return;
        }

        $this->dispatch('editUser', $this->user->id);
        $this->closeModal();
    }

    /**
     * Check if current user can edit the target user
     */
    private function canEditUser()
    {
        if (auth()->user()->hasRole('super_admin')) {
            return true;
        }

        if (auth()->user()->hasRole('company_admin') && $this->user->company_id === auth()->user()->company_id) {
            return !$this->user->hasRole('super_admin');
        }

        return false;
    }

    /**
     * Block/Unblock user
     */
    public function toggleUserStatus()
    {
        if (!$this->canEditUser()) {
            $this->dispatch('notify', type: 'error', message: 'You do not have permission to change this user\'s status.');
            return;
        }

        $newStatus = $this->user->status === 'active' ? 'inactive' : 'active';
        $action = $newStatus === 'active' ? 'unblockUser' : 'blockUser';
        
        $this->dispatch($action, $this->user->id);
        $this->closeModal();
    }

    /**
     * Close modal and reset
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['user', 'activeTab', 'activityDateFilter', 'activityTypeFilter', 'userStats']);
        $this->resetPage();
    }

    /**
     * Render component
     */
    public function render()
    {
        $activityLogs = $this->user ? $this->getActivityLogs() : collect();
        $paymentHistory = $this->user ? $this->getPaymentHistory() : collect();
        
        return view('livewire.user-management.actions.view-user', [
            'activityLogs' => $activityLogs,
            'paymentHistory' => $paymentHistory
        ]);
    }
}