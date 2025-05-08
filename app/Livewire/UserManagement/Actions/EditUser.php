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

    public $roles =[];
    public $companies=[];
    
    // Listeners
    protected $listeners = ['editUser'];
    
    public function editUser($userId)
    {
        // Security check
        $user = User::findOrFail($userId);
        if (!auth()->user()->hasRole('super_admin') && 
            !(auth()->user()->hasRole('company_admin') && $user->company_id === auth()->user()->company_id)) {
            return;
        }
        
        $this->userId = $userId;
        
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
        
        $this->showModal = true;
    }
    
    // Similar validation and update methods as CreateUser component
    // But with special handling for existing user
}