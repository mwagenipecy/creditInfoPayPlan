<?php

// App/Livewire/UserManagement/BulkActions/BulkActions.php

namespace App\Livewire\UserManagement\BulkActions;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class BulkActions extends Component
{
    public $showModal = false;
    public $selectedUsers = [];
    public $action = '';
    public $newRoleId = '';
    public $newCompanyId = '';
    public $confirmationText = '';
    
    // Listeners
    protected $listeners = ['openModal'];
    
    public function openModal($selectedUsers)
    {
        if (empty($selectedUsers)) {
            // No users selected
            return;
        }
        
        $this->selectedUsers = $selectedUsers;
        $this->resetForm();
        $this->showModal = true;
    }
    
    public function resetForm()
    {
        $this->action = '';
        $this->newRoleId = '';
        $this->newCompanyId = '';
        $this->confirmationText = '';
    }
    
    public function executeBulkAction()
    {
        // Validate based on selected action
        if ($this->action === 'delete' && $this->confirmationText !== 'DELETE') {
            // Require confirmation for destructive actions
            return;
        }
        
        try {
            DB::beginTransaction();
            
            // Process based on action type
            switch ($this->action) {
                case 'block':
                    $this->bulkBlockUsers();
                    break;
                case 'unblock':
                    $this->bulkUnblockUsers();
                    break;
                case 'change_role':
                    $this->bulkChangeRole();
                    break;
                case 'change_company':
                    $this->bulkChangeCompany();
                    break;
                case 'delete':
                    $this->bulkDeleteUsers();
                    break;
                case 'verify':
                    $this->bulkVerifyUsers();
                    break;
            }
            
            DB::commit();
            
            $this->showModal = false;
            $this->emit('bulkActionCompleted');
            
        } catch (\Exception $e) {
            DB::rollBack();
            // Error handling
        }
    }
    
    // Methods for each action type
    public function bulkBlockUsers()
    {
        User::whereIn('id', $this->selectedUsers)->update(['is_blocked' => true]);
    }

    public function bulkUnblockUsers()
    {
        User::whereIn('id', $this->selectedUsers)->update(['is_blocked' => false]);
    }

    public function bulkChangeRole()
    {
        if (!empty($this->newRoleId)) {
            User::whereIn('id', $this->selectedUsers)->update(['role_id' => $this->newRoleId]);
        }
    }

    public function bulkChangeCompany()
    {
        if (!empty($this->newCompanyId)) {
            User::whereIn('id', $this->selectedUsers)->update(['company_id' => $this->newCompanyId]);
        }
    }

    public function bulkDeleteUsers()
    {
        User::whereIn('id', $this->selectedUsers)->delete();
    }

    public function bulkVerifyUsers()
    {
        User::whereIn('id', $this->selectedUsers)->update(['is_verified' => true]);
    }
}