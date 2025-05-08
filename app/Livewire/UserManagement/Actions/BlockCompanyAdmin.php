<?php

namespace App\Livewire\UserManagement\Actions;

use Livewire\Component;
use App\Models\User;
use App\Models\Company;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Rule;

class BlockCompanyAdmin extends Component
{
    public $showModal = false;
    public $adminId;
    public $admin;
    public $company;
    public $userCount = 0;
    
    #[Rule('required|string|min:10', message: 'Please provide a detailed reason (at least 10 characters)')]
    public $blockReason = '';
    
    #[Rule('required|in:BLOCK COMPANY', message: 'You must type BLOCK COMPANY exactly to confirm')]
    public $confirmationPhrase = '';
    
    // Livewire 3 listeners
    protected function getListeners()
    {
        return [
            'blockCompanyAdmin' => 'blockCompanyAdmin',
        ];
    }

    public function blockCompanyAdmin($adminId)
    {
        // Security check - only super admin can perform this action
        if (!auth()->user()->hasRole('super_admin')) {
            $this->dispatch('notify', type: 'error', message: 'You do not have permission to perform this action.');
            return;
        }
        
        $this->adminId = $adminId;
        
        // Load the admin and their company
        $this->admin = User::with('company')->find($adminId);
        
        if (!$this->admin || !$this->admin->company || !$this->admin->role || $this->admin->role->name !== 'company_admin') {
            $this->dispatch('notify', type: 'error', message: 'Invalid user or user is not a company admin.');
            return;
        }
        
        $this->company = $this->admin->company;
        
        // Get count of users in the company
        $this->userCount = User::where('company_id', $this->company->id)->count();
        
        // Reset form fields
        $this->blockReason = '';
        $this->confirmationPhrase = '';
        $this->resetValidation();
        
        // Show the modal
        $this->showModal = true;
    }
    
    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['adminId', 'admin', 'company', 'blockReason', 'confirmationPhrase', 'userCount']);
    }
    
    public function confirmBlock()
    {
        // Validate form
        $this->validate();
        
        // Security check again
        if (!auth()->user()->hasRole('super_admin')) {
            $this->dispatch('notify', type: 'error', message: 'You do not have permission to perform this action.');
            return;
        }
        
        try {
            DB::beginTransaction();
            
            // 1. Block the company
            $this->company->update([
                'is_blocked' => true
            ]);
            
            // Log company block activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'blocked',
                'model_type' => Company::class,
                'model_id' => $this->company->id,
                'description' => "Blocked company: {$this->company->name}. Reason: {$this->blockReason}"
            ]);
            
            // 2. Block all users in the company
            $usersToBlock = User::where('company_id', $this->company->id)->get();
            
            foreach ($usersToBlock as $user) {
                $user->update([
                    'status' => 'inactive'
                ]);
                
                // Log user block activity
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'blocked',
                    'model_type' => User::class,
                    'model_id' => $user->id,
                    'description' => "Blocked user (company block): {$user->name}"
                ]);
            }
            
            DB::commit();
            
            // Close modal and show success message
            $this->closeModal();
            
            // Emit event to refresh user list (Livewire 3 dispatch style)
            $this->dispatch('userBlocked');
            
            // Show notification (Livewire 3 dispatch style)
            $this->dispatch('notify', type: 'success', message: "Company '{$this->company->name}' and all its users have been blocked successfully.");
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->dispatch('notify', type: 'error', message: 'Error: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.user-management.actions.block-company-admin');
    }
}