<?php

namespace App\Livewire\UserManagement\Actions;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\UserCreatedNotification;
use App\Mail\WelcomeUserNotification;

class CreateUser extends Component
{
    public $showModal = false;
    
    // User properties
    public $first_name;
    public $last_name;
    public $email;
    public $company_id;
    public $role_id;
    public $send_welcome_email = true;
    public $send_credentials_email = true;
    public $status = 'active';
    public $notify_admins = false;
    
    // Generated password (not visible to user)
    private $generatedPassword;
    
    // Listeners
    protected $listeners = ['openModalCreateUser'];
    
    /**
     * Validation rules
     */
    protected function rules()
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive,pending',
            'send_welcome_email' => 'boolean',
            'send_credentials_email' => 'boolean',
            'notify_admins' => 'boolean',
        ];

        // Company is required for super admin, auto-set for company admin
        if (auth()->user()->role->name== 'company_admin') {
            $rules['company_id'] = 'required|exists:companies,id';
        }
        return $rules;
    }

    /**
     * Custom validation messages
     */

    protected $messages = [
        'first_name.required' => 'First name is required.',
        'last_name.required' => 'Last name is required.',
        'email.required' => 'Email address is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email address is already registered.',
        'company_id.required' => 'Please select a company.',
        'role_id.required' => 'Please select a role.',
    ];
    
    /**
     * Open create user modal
     */
    public function openModalCreateUser()
    {
        // Check permissions
        if (!$this->canCreateUser()) {
            $this->dispatch('notify', type: 'error', message: 'You do not have permission to create users.');
            return;
        }

        // Reset form
        $this->resetForm();
        
        // If user is company admin, set company automatically
        if (auth()->user()->role->name=='company_admin') {
            $this->company_id = auth()->user()->company_id;
        }

        // Set default notification preferences
        $this->notify_admins = !auth()->user()->role->name=='super_admin';
        
        $this->showModal = true;
    }

    /**
     * Check if current user can create users
     */
    private function canCreateUser()
    {
        return auth()->user()->role->name=='super_admin' || auth()->user()->role->name=='company_admin';
    }
    
    /**
     * Close modal and reset form
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }
    
    /**
     * Reset form data
     */
    public function resetForm()
    {
        $this->reset([
            'first_name', 'last_name', 'email', 'role_id', 
            'send_welcome_email', 'send_credentials_email', 'notify_admins'
        ]);
        
        $this->company_id = auth()->user()->role->name=='company_admin' ? auth()->user()->company_id : '';
        $this->status = 'active';
        $this->send_welcome_email = true;
        $this->send_credentials_email = true;
        $this->notify_admins = !auth()->user()->role->name=='super_admin';
        $this->generatedPassword = null;
        
        $this->resetErrorBag();
        $this->resetValidation();
    }

    /**
     * Generate a secure password
     */
    private function generateSecurePassword($length = 12)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        $password = '';
        
        // Ensure at least one character from each type
        $password .= chr(rand(97, 122)); // lowercase
        $password .= chr(rand(65, 90));  // uppercase
        $password .= chr(rand(48, 57));  // number
        $password .= '!@#$%^&*'[rand(0, 7)]; // special character
        
        // Fill the rest randomly
        for ($i = 4; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        // Shuffle the password to randomize character positions
        return str_shuffle($password);
    }
    
    /**
     * Create new user
     */
    public function createUser()
    {
        $this->validate();
        
        // Additional security checks
        if (!$this->performSecurityChecks()) {
            return;
        }
        
        try {
            DB::beginTransaction();
            
            // Generate secure password
            $this->generatedPassword = $this->generateSecurePassword();
            
            $companyId = $this->company_id === '' ? null : $this->company_id;

            // Create user
            $user = User::create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'name' => $this->first_name . ' ' . $this->last_name,
                'email' => $this->email,
                'password' => Hash::make($this->generatedPassword),
                'company_id' =>    $companyId,
                'role_id' => $this->role_id,
                'status' => $this->status,
                'email_verified_at' => null, // Users need to verify their email
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);
            
            // Log activity
            $this->logUserCreation($user);
            
            // Send notifications
            $this->sendNotifications($user);
            
            DB::commit();
            
            // Close modal and show success message
            $this->closeModal();
            
            // Emit events
            $this->dispatch('userCreated');
            $this->dispatch('notify', type: 'success', message: 'User created successfully! Login credentials have been sent via email.');
            
        } catch (\Exception $e) {

            dd($e->getMessage());
            DB::rollBack();
            
            $this->dispatch('notify', type: 'error', message: 'Error creating user: ' . $e->getMessage());
        }
    }

    /**
     * Perform security checks
     */
    private function performSecurityChecks()
    {
        if (auth()->user()->role->name == 'company_admin')  {
            // Ensure company admin can only create users in their company
            if ($this->company_id != auth()->user()->company_id) {
                $this->addError('company_id', 'You can only create users in your own company.');
                return false;
            }
            
            // Ensure company admin can't create super admins or other company admins
            $role = Role::find($this->role_id);
            if ($role && in_array($role->name, ['super_admin', 'company_admin'])) {
                $this->addError('role_id', 'You do not have permission to assign this role.');
                return false;
            }
        }

        // Check if company is active
        $company = Company::find($this->company_id);
        if ($company && $company->verification_status !== 'approved') {
            $this->addError('company_id', 'Cannot create users for inactive companies.');
            return false;
        }

        return true;
    }

    /**
     * Log user creation activity
     */
    private function logUserCreation($user)
    {
        $company = $this->company_id ? Company::find($this->company_id) : null;
        $role = Role::find($this->role_id);
    
        $description = "Created new user: {$user->name} ({$user->email}) ";
        $description .= $company
            ? "for company: {$company->company_name} "
            : "with no assigned company ";
        $description .= "with role: {$role->display_name} ";
        $description .= "by " . auth()->user()->name;
    
        ActivityLog::create([
            'user_id' => auth()->id(),
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'activity' => 'user_created',
            'description' => $description,
            'old_values' => null,
            'new_values' => json_encode($user->toArray()),
            'changes' => json_encode([
                'user_created' => [
                    'from' => null,
                    'to' => 'New user account created'
                ],
                'initial_status' => [
                    'from' => null,
                    'to' => $this->status
                ]
            ]),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'company_id' => auth()->user()->company_id?? null,
        ]);
    }

    

    /**
     * Send notifications
     */
    private function sendNotifications($user)
    {
        try {
            // Send welcome email if requested
            if ($this->send_welcome_email) {
                Mail::to($user->email)->send(
                    new WelcomeUserNotification($user, auth()->user())
                );
            }

            // Send credentials email if requested
            if ($this->send_credentials_email) {
                Mail::to($user->email)->send(
                    new UserCreatedNotification($user, $this->generatedPassword, auth()->user())
                );
            }

            // Notify admins if requested
            if ($this->notify_admins) {
                $admins = User::whereHas('role', function($query) {
                    $query->where('name', 'super_admin');
                })->where('status', 'active')->get();

                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(
                        new UserCreatedNotification($user, null, auth()->user(), true)
                    );
                }
            }

        } catch (\Exception $e) {
            // Log email error but don't fail user creation
            \Log::error('Failed to send user creation notifications: ' . $e->getMessage());
        }
    }
    
    /**
     * Get companies based on user role
     */
    public function getCompaniesProperty()
    {
        if (auth()->user()->hasRole('super_admin')) {
            return Company::
                orderBy('company_name')
                ->get();
        } elseif (auth()->user()->hasRole('company_admin')) {
            return Company::where('id', auth()->user()->company_id)
                ->where('status', 'active')
                ->get();
        }

        return collect();
    }

    /**
     * Get roles based on user role
     */
    public function getRolesProperty()
    {
        if (auth()->user()->hasRole('super_admin')) {
            return Role::orderBy('display_name')->get();
        } elseif (auth()->user()->hasRole('company_admin')) {
            // Company admins can only assign non-admin roles
            return Role::whereNotIn('name', ['super_admin', 'company_admin'])
                ->orderBy('display_name')
                ->get();
        }

        return collect();
    }
    
    /**
     * Render component
     */
    public function render()
    {
        return view('livewire.user-management.actions.create-user', [
            'companies' => $this->companies,
            'roles' => $this->roles,
        ]);
    }
}