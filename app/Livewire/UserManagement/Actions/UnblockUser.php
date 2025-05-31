<?php

// App/Livewire/UserManagement/Actions/UnblockUser.php

namespace App\Livewire\UserManagement\Actions;

use Livewire\Component;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserUnblockedNotification;
use App\Mail\UserStatusChangedNotification;

class UnblockUser extends Component
{
    public $showModal = false;
    public $userId;
    public $user;
    public $unblockReason = '';
    public $sendNotification = true;
    public $notifyAdmins = false;
    
    // Listeners
    protected $listeners = ['unblockUser'];
    
    /**
     * Validation rules
     */
    protected function rules()
    {
        return [
            'unblockReason' => 'required|string|max:500',
            'sendNotification' => 'boolean',
            'notifyAdmins' => 'boolean'
        ];
    }

    /**
     * Custom validation messages
     */
    protected $messages = [
        'unblockReason.required' => 'Please provide a reason for unblocking this user.',
        'unblockReason.max' => 'The reason must not exceed 500 characters.',
    ];
    
    /**
     * Unblock user method called from parent component
     */
    public function unblockUser($userId)
    {
        // Security checks
        if (!$this->canUnblockUser()) {
            $this->dispatch('notify', type: 'error', message: 'You do not have permission to unblock users.');
            return;
        }
        
        $this->userId = $userId;
        $this->user = User::with(['company', 'role'])->findOrFail($userId);
        
        // Check if user is already active
        if ($this->user->status === 'active') {
            $this->dispatch('notify', type: 'info', message: 'This user is already active.');
            return;
        }
        
        // Reset form
        $this->unblockReason = '';
        $this->sendNotification = true;
        $this->notifyAdmins = !auth()->user()->hasRole('super_admin');
        
        $this->showModal = true;
    }
    
    /**
     * Check if current user can unblock other users
     */
    private function canUnblockUser()
    {
        if (auth()->user()->hasRole('super_admin')) {
            return true;
        }

        if (auth()->user()->hasRole('company_admin') && $this->user && $this->user->company_id === auth()->user()->company_id) {
            // Company admins can't unblock super admins
            return !$this->user->hasRole('super_admin');
        }

        return false;
    }
    
    /**
     * Confirm user unblock
     */
    public function confirmUnblock()
    {
        $this->validate();
        
        try {
            DB::beginTransaction();
            
            $originalData = $this->user->toArray();
            $oldStatus = $this->user->status;
            
            // Unblock the user
            $this->user->update([
                'status' => 'active',
                'blocked_at' => null,
                'blocked_by' => null,
                'block_reason' => null,
                'updated_by' => auth()->id()
            ]);
            
            // Log activity
            $this->logUnblockActivity($originalData, $oldStatus);
            
            // Send notifications if requested
            if ($this->sendNotification || $this->notifyAdmins) {
                $this->sendUnblockNotifications();
            }
            
            DB::commit();
            
            // Close modal and notify parent component
            $this->closeModal();
            $this->dispatch('notify', type: 'success', message: 'User has been unblocked successfully.');
            $this->dispatch('userUnblocked');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', type: 'error', message: 'An error occurred while unblocking the user: ' . $e->getMessage());
        }
    }
    
    /**
     * Log unblock activity
     */
    private function logUnblockActivity($originalData, $oldStatus)
    {
        $description = "User {$this->user->name} was unblocked by " . auth()->user()->name;
        if ($this->unblockReason) {
            $description .= ". Reason: {$this->unblockReason}";
        }
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'subject_type' => User::class,
            'subject_id' => $this->user->id,
            'activity' => 'user_unblocked',
            'description' => $description,
            'old_values' => json_encode($originalData),
            'new_values' => json_encode($this->user->fresh()->toArray()),
            'changes' =>json_encode( [
                'status' => [
                    'from' => $oldStatus,
                    'to' => 'active'
                ],
                'unblock_reason' => [
                    'from' => null,
                    'to' => $this->unblockReason
                ]
            ]),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'company_id' => auth()->user()->company_id,
        ]);
    }
    
    /**
     * Send unblock notifications
     */
    private function sendUnblockNotifications()
    {
        try {
            // Send notification to the user
            if ($this->sendNotification) {
                Mail::to($this->user->email)->send(
                    new UserUnblockedNotification($this->user, auth()->user(), $this->unblockReason)
                );
            }
            
            // Send notification to admins
            if ($this->notifyAdmins) {
                $admins = User::whereHas('role', function($query) {
                    $query->where('name', 'super_admin');
                })->where('status', 'active')->get();
                
                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(
                        new UserStatusChangedNotification($this->user, auth()->user(), 'unblocked', $this->unblockReason)
                    );
                }
            }
            
        } catch (\Exception $e) {
            // Log email error but don't fail the unblock
            \Log::error('Failed to send unblock notifications: ' . $e->getMessage());
        }
    }
    
    /**
     * Check if user's company is blocked
     */
    public function getIsCompanyBlockedProperty()
    {
        return $this->user && $this->user->company && $this->user->company->status === 'blocked';
    }
    
    /**
     * Get block information
     */
    public function getBlockInfoProperty()
    {
        if (!$this->user) return null;
        
        return [
            'blocked_at' => $this->user->blocked_at,
            'blocked_by' => $this->user->blockedBy ? $this->user->blockedBy->name : 'System',
            'block_reason' => $this->user->block_reason,
            'days_blocked' => $this->user->blocked_at ? $this->user->blocked_at->diffInDays(now()) : 0
        ];
    }
    
    /**
     * Close modal and reset form
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['userId', 'user', 'unblockReason', 'sendNotification', 'notifyAdmins']);
        $this->resetErrorBag();
    }
    
    /**
     * Render component
     */
    public function render()
    {
        return view('livewire.user-management.actions.unblock-user');
    }
}