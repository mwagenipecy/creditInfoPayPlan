<?php

// App/Livewire/UserManagement/Actions/EditUser.php

namespace App\Livewire\UserManagement\Actions;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Mail\UserUpdatedNotification;
use App\Mail\PasswordResetNotification;

class EditUser extends Component
{
    public $showModal = false;
    
    // User properties
    public $userId;
    public $first_name;
    public $last_name;
    public $email;
    public $company_id;
    public $role_id;
    public $password;
    public $password_confirmation;
    public $status;
    public $generateNewPassword = false;

    public $roles = [];
    public $companies = [];
    
    // Track original values for change detection
    public $originalUser;
    
    // Listeners
    protected $listeners = ['editUser'];
    
    /**
     * Validation rules
     */
    protected function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->userId)
            ],
            'company_id' => auth()->user()->hasRole('super_admin') ? 'required|exists:companies,id' : 'nullable',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive,pending',
            'password' => $this->generateNewPassword ? '' : 'nullable|min:8|confirmed',
            'password_confirmation' => 'nullable'
        ];
    }

    /**
     * Custom validation messages
     */
    protected $messages = [
        'first_name.required' => 'First name is required.',
        'last_name.required' => 'Last name is required.',
        'email.required' => 'Email address is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email address is already in use.',
        'company_id.required' => 'Please select a company.',
        'role_id.required' => 'Please select a role.',
        'status.required' => 'Please select a status.',
        'password.min' => 'Password must be at least 8 characters.',
        'password.confirmed' => 'Password confirmation does not match.',
    ];

    /**
     * Mount component
     */
    public function mount()
    {
        $this->loadRolesAndCompanies();
    }

    /**
     * Load roles and companies based on user permissions
     */
    private function loadRolesAndCompanies()
    {
        // Load roles based on user permissions
        if (auth()->user()->hasRole('super_admin')) {
            $this->roles = Role::all();
            $this->companies = Company::get();
        } elseif (auth()->user()->hasRole('company_admin')) {
            // Company admins can only assign certain roles
            $this->roles = Role::whereIn('name', ['user', 'company_admin'])->get();
            $this->companies = Company::where('id', auth()->user()->company_id)->get();
        }
    }

    /**
     * Edit user method called from parent component
     */
    public function editUser($userId)
    {
        // Security check
        $user = User::with(['company', 'role'])->findOrFail($userId);

        if (!$this->canEditUser($user)) {
            $this->dispatch('notify', type: 'error', message: 'You do not have permission to edit this user.');
            return;
        }
        
        $this->userId = $userId;
        $this->originalUser = $user->toArray();
        
        // Load user data
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->company_id = $user->company_id;
        $this->role_id = $user->role_id;
        $this->status = $user->status;
        
        // Reset password fields
        $this->password = '';
        $this->password_confirmation = '';
        $this->generateNewPassword = false;

        $this->loadRolesAndCompanies();
        $this->showModal = true;
    }

    /**
     * Check if current user can edit the target user
     */
    private function canEditUser($user)
    {
        if (auth()->user()->hasRole('super_admin')) {
            return true;
        }

        if (auth()->user()->hasRole('company_admin') && $user->company_id === auth()->user()->company_id) {
            // Company admins can't edit super admins
            return !$user->hasRole('super_admin');
        }

        return false;
    }

    /**
     * Toggle automatic password generation
     */
    public function togglePasswordGeneration()
    {
        $this->generateNewPassword = !$this->generateNewPassword;
        
        if ($this->generateNewPassword) {
            $this->password = '';
            $this->password_confirmation = '';
        }
    }

    /**
     * Generate a secure random password
     */
    private function generateSecurePassword($length = 12)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        $password = '';
        
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return $password;
    }

    /**
     * Update user
     */
    public function updateUser()
    {
        try {
            $this->validate();

            DB::beginTransaction();

            $user = User::findOrFail($this->userId);
            $originalData = $user->toArray();
            $changes = [];
            $newPassword = null;

            // Check for changes and update user
            if ($user->first_name !== $this->first_name) {
                $changes['first_name'] = ['from' => $user->first_name, 'to' => $this->first_name];
                $user->first_name = $this->first_name;
            }

            if ($user->last_name !== $this->last_name) {
                $changes['last_name'] = ['from' => $user->last_name, 'to' => $this->last_name];
                $user->last_name = $this->last_name;
            }

            if ($user->email !== $this->email) {
                $changes['email'] = ['from' => $user->email, 'to' => $this->email];
                $user->email = $this->email;
                $user->email_verified_at = null; // Reset email verification when email changes
            }

            // Handle company change (only for super admins)
            if (auth()->user()->hasRole('super_admin') && $user->company_id != $this->company_id) {
                $oldCompany = $user->company ? $user->company->company_name : 'None';
                $newCompany = Company::find($this->company_id)?->company_name ?? 'None';
                $changes['company'] = ['from' => $oldCompany, 'to' => $newCompany];
                $user->company_id = $this->company_id;
            }

            // Handle role change
            if ($user->role_id != $this->role_id) {
                $oldRole = $user->role ? $user->role->name : 'None';
                $newRole = Role::find($this->role_id)?->name ?? 'None';
                $changes['role'] = ['from' => $oldRole, 'to' => $newRole];
                $user->role_id = $this->role_id;
            }

            // Handle status change
            if ($user->status !== $this->status) {
                $changes['status'] = ['from' => $user->status, 'to' => $this->status];
                $user->status = $this->status;
            }

            // Handle password change
            if ($this->generateNewPassword) {
                $newPassword = $this->generateSecurePassword();
                $user->password = Hash::make($newPassword);
                $changes['password'] = ['from' => 'Hidden', 'to' => 'New password generated'];
            } elseif (!empty($this->password)) {
                $user->password = Hash::make($this->password);
                $changes['password'] = ['from' => 'Hidden', 'to' => 'Password updated manually'];
                $newPassword = $this->password;
            }

            // Update user
           // $user->updated_by = auth()->id();
            $user->save();

            // Log activity
            $this->logActivity($user, $changes, $originalData);

            // Send email notifications
            $this->sendNotifications($user, $changes, $newPassword);

            DB::commit();

            // Close modal and refresh parent component
            $this->closeModal();
            $this->dispatch('notify', type: 'success', message: 'User updated successfully.');
            $this->dispatch('userUpdated');

        } catch (\Illuminate\Validation\ValidationException $e) {
           
           // dd($e->getMessage());
             DB::rollBack();
            throw $e;
        } catch (\Exception $e) {

           // dd($e->getMessage());

            DB::rollBack();
            $this->dispatch('notify', type: 'error', message: 'An error occurred while updating the user: ' . $e->getMessage());
        }
    }

    /**
     * Log user update activity
     */
    private function logActivity($user, $changes, $originalData)
    {
        if (empty($changes)) {
            return;
        }

        $description = "User {$user->name} was updated by " . auth()->user()->name;
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'activity' => 'user_updated',
            'description' => $description,
            'old_values' => json_encode($originalData),
            'new_values' => json_encode($user->toArray()),   // FIXED
            'changes' => json_encode($changes),              // FIXED
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'company_id' => auth()->user()->company_id,
        ]);
        
    }

    /**
     * Send email notifications
     */
    private function sendNotifications($user, $changes, $newPassword = null)
    {
        try {
            // Send user update notification to the user
            if (!empty($changes)) {
                Mail::to($user->email)->send(new UserUpdatedNotification($user, $changes, auth()->user()));
            }

            // Send password notification if password was changed
            if ($newPassword) {
                Mail::to($user->email)->send(new PasswordResetNotification($user, $newPassword, auth()->user()));
            }

            // Send notification to admin if significant changes occurred
            $significantChanges = ['email', 'role', 'status', 'company'];
            $hasSignificantChanges = collect($changes)->keys()->intersect($significantChanges)->isNotEmpty();
            
            if ($hasSignificantChanges && !auth()->user()->hasRole('super_admin')) {
                $admins = User::whereHas('role', function($query) {
                    $query->where('name', 'super_admin');
                })->where('status', 'active')->get();

                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(new UserUpdatedNotification($user, $changes, auth()->user(), true));
                }
            }

        } catch (\Exception $e) {
            // Log email error but don't fail the update
            \Log::error('Failed to send user update notification: ' . $e->getMessage());
        }
    }

    /**
     * Close modal and reset form
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->reset([
            'userId', 'first_name', 'last_name', 'email', 'company_id', 
            'role_id', 'password', 'password_confirmation', 'status', 
            'generateNewPassword', 'originalUser'
        ]);
        $this->resetErrorBag();
    }

    /**
     * Render component
     */
    public function render()
    {
        return view('livewire.user-management.actions.edit-user');
    }
}