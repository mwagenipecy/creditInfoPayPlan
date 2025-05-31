<?php

// App/Livewire/UserManagement/Actions/VerifyUser.php

namespace App\Livewire\UserManagement\Actions;

use Livewire\Component;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerifiedNotification;
use App\Mail\EmailVerificationConfirmation;

class VerifyUser extends Component
{
    public $showModal = false;
    public $userId;
    public $user;
    public $sendNotification = true;
    public $verificationReason = '';
    
    // Listeners
    protected $listeners = ['verifyUser'];
    
    /**
     * Validation rules
     */
    protected function rules()
    {
        return [
            'verificationReason' => 'nullable|string|max:500',
            'sendNotification' => 'boolean'
        ];
    }
    
    /**
     * Verify user method called from parent component
     */
    public function verifyUser($userId)
    {
        // Security checks
        if (!$this->canVerifyUser()) {
            $this->dispatch('notify', type: 'error', message: 'You do not have permission to verify users.');
            return;
        }
        
        $this->userId = $userId;
        $this->user = User::with(['company', 'role'])->findOrFail($userId);
        
        // Check if user is already verified
        if ($this->user->email_verified_at) {
            $this->dispatch('notify', type: 'info', message: 'This user is already verified.');
            return;
        }
        
        // Reset form
        $this->sendNotification = true;
        $this->verificationReason = '';
        $this->showModal = true;
    }
    
    /**
     * Check if current user can verify other users
     */
    private function canVerifyUser()
    {
        return auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('company_admin');
    }
    
    /**
     * Confirm email verification
     */
    public function confirmVerification()
    {
        $this->validate();
        
        try {
            DB::beginTransaction();
            
            $originalData = $this->user->toArray();
            
            // Mark email as verified
            $this->user->update([
                'email_verified_at' => now(),
               // 'updated_by' => auth()->id()
            ]);
            
            // Log activity
            $this->logVerificationActivity($originalData);
            
            // Send notifications if requested
            if ($this->sendNotification) {
                $this->sendVerificationNotifications();
            }
            
            DB::commit();
            
            // Close modal and notify parent component
            $this->closeModal();
            $this->dispatch('notify', type: 'success', message: 'User email has been verified successfully.');
            $this->dispatch('userVerified');
            
        } catch (\Exception $e) {

            dd($e->getMessage());
            DB::rollBack();
            $this->dispatch('notify', type: 'error', message: 'An error occurred while verifying the user: ' . $e->getMessage());
        }
    }
    
    /**
     * Log verification activity
     */
    private function logVerificationActivity($originalData)
    {
        $description = "Email manually verified for user: {$this->user->name} by " . auth()->user()->name;
        if ($this->verificationReason) {
            $description .= ". Reason: {$this->verificationReason}";
        }
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'subject_type' => User::class,
            'subject_id' => $this->user->id,
            'activity' => 'email_verified',
            'description' => $description,
            'old_values' => json_encode( $originalData),
            'new_values' => json_encode($this->user->fresh()->toArray()),
            'changes' => json_encode([
                'email_verified_at' => [
                    'from' => null,
                    'to' => 'Verified manually'
                ]
            ]),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'company_id' => auth()->user()->company_id,
        ]);
    }
    
    /**
     * Send verification notifications
     */
    private function sendVerificationNotifications()
    {
        try {
            // Send confirmation to the user
            Mail::to($this->user->email)->send(
                new EmailVerificationConfirmation($this->user, auth()->user(), $this->verificationReason)
            );
            
            // Send notification to admins if the verifier is not a super admin
            if (!auth()->user()->hasRole('super_admin')) {
                $superAdmins = User::whereHas('role', function($query) {
                    $query->where('name', 'super_admin');
                })->where('status', 'active')->get();
                
                foreach ($superAdmins as $admin) {
                    Mail::to($admin->email)->send(
                        new EmailVerifiedNotification($this->user, auth()->user(), $this->verificationReason)
                    );
                }
            }
            
        } catch (\Exception $e) {
            // Log email error but don't fail the verification
            \Log::error('Failed to send verification notifications: ' . $e->getMessage());
        }
    }
    
    /**
     * Send verification link to user
     */
    public function sendVerificationLink()
    {
        try {
            $this->user->sendEmailVerificationNotification();
            
            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'subject_type' => User::class,
                'subject_id' => $this->user->id,
                'activity' => 'verification_link_sent',
                'description' => "Verification link sent to user: {$this->user->name} by " . auth()->user()->name,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'company_id' => auth()->user()->company_id,
            ]);
            
            $this->dispatch('notify', type: 'success', message: 'Verification link has been sent to the user.');
            
        } catch (\Exception $e) {
            $this->dispatch('notify', type: 'error', message: 'Failed to send verification link: ' . $e->getMessage());
        }
    }
    
    /**
     * Reset email verification
     */
    public function resetVerification()
    {
        if (!auth()->user()->hasRole('super_admin')) {
            $this->dispatch('notify', type: 'error', message: 'Only super administrators can reset email verification.');
            return;
        }
        
        try {
            DB::beginTransaction();
            
            $originalData = $this->user->toArray();
            
            // Reset email verification
            $this->user->update([
                'email_verified_at' => null,
                'updated_by' => auth()->id()
            ]);
            
            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'subject_type' => User::class,
                'subject_id' => $this->user->id,
                'activity' => 'email_verification_reset',
                'description' => "Email verification reset for user: {$this->user->name} by " . auth()->user()->name,
                'old_values' => $originalData,
                'new_values' => $this->user->fresh()->toArray(),
                'changes' => [
                    'email_verified_at' => [
                        'from' => 'Verified',
                        'to' => 'Unverified'
                    ]
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'company_id' => auth()->user()->company_id,
            ]);
            
            DB::commit();
            
            $this->closeModal();
            $this->dispatch('notify', type: 'success', message: 'Email verification has been reset.');
            $this->dispatch('userVerified');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', type: 'error', message: 'Failed to reset verification: ' . $e->getMessage());
        }
    }
    
    /**
     * Close modal and reset form
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['userId', 'user', 'sendNotification', 'verificationReason']);
        $this->resetErrorBag();
    }
    
    /**
     * Render component
     */
    public function render()
    {
        return view('livewire.user-management.actions.verify-user');
    }
}