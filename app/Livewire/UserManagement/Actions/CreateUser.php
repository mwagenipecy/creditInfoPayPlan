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
use App\Mail\UserCreated;

class CreateUser extends Component
{
    public $showModal = false;
    
    // User properties
    public $first_name;
    public $last_name;
    public $email;
    public $company_id;
    public $role_id;
    public $password;
    public $password_confirmation;
    public $send_welcome_email = true;
    public $status = 'active';
    
    // Listeners
    protected $listeners = ['openModal'];
    
    // Validation rules
    protected function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'company_id' => 'required|exists:companies,id',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|min:8|same:password_confirmation',
            'status' => 'required|in:active,inactive,pending',
        ];
    }
    
    public function openModal()
    {
        // Reset form
        $this->resetForm();
        
        // If user is company admin, set company automatically
        if (auth()->user()->hasRole('company_admin')) {
            $this->company_id = auth()->user()->company_id;
        }
        
        $this->showModal = true;
    }
    
    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }
    
    public function resetForm()
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->company_id = auth()->user()->hasRole('company_admin') ? auth()->user()->company_id : '';
        $this->role_id = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->send_welcome_email = true;
        $this->status = 'active';
        
        $this->resetErrorBag();
        $this->resetValidation();
    }
    
    public function createUser()
    {
        $this->validate();
        
        // Security checks
        if (auth()->user()->hasRole('company_admin')) {
            // Ensure company admin can only create users in their company
            if ($this->company_id != auth()->user()->company_id) {
                $this->addError('company_id', 'You can only create users in your own company.');
                return;
            }
            
            // Ensure company admin can't create super admins or other company admins
            $role = Role::find($this->role_id);
            if ($role && ($role->name === 'super_admin' || $role->name === 'company_admin')) {
                $this->addError('role_id', 'You do not have permission to assign this role.');
                return;
            }
        }
        
        try {
            DB::beginTransaction();
            
            $user = User::create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'name' => $this->first_name . ' ' . $this->last_name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'company_id' => $this->company_id,
                'role_id' => $this->role_id,
                'status' => $this->status,
            ]);
            
            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'created',
                'model_type' => User::class,
                'model_id' => $user->id,
                'description' => "Created user: {$user->name}"
            ]);
            
            // Send welcome email if checked
            if ($this->send_welcome_email) {
                // Generate password reset token
                $token = app('auth.password.broker')->createToken($user);
                
                Mail::to($user->email)->send(new UserCreated($user, $token));
            }
            
            DB::commit();
            
            // Close modal and show success message
            $this->closeModal();
            
            // Emit event to refresh user list
            $this->emit('userCreated');
            
            // Show notification
            $this->dispatchBrowserEvent('notify', [
                'type' => 'success',
                'message' => 'User created successfully!'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function render()
    {
        $companies = [];
        $roles = [];
        
        // Get companies based on user role
        if (auth()->user()->hasRole('super_admin')) {
            $companies = Company::where('is_blocked', false)
                ->orderBy('company_name')
                ->get();
        } elseif (auth()->user()->hasRole('company_admin')) {
            $companies = Company::where('id', auth()->user()->company_id)
                ->where('is_blocked', false)
                ->get();
        }
        
        // Get roles based on user role
        if (auth()->user()->hasRole('super_admin')) {
            $roles = Role::orderBy('display_name')->get();
        } elseif (auth()->user()->hasRole('company_admin')) {
            // Company admins can only assign non-admin roles
            $roles = Role::where('name', '!=', 'super_admin')
                ->where('name', '!=', 'company_admin')
                ->orderBy('display_name')
                ->get();
        }
        
        return view('livewire.user-management.actions.create-user', [
            'companies' => $companies,
            'roles' => $roles,
        ]);
    }
}