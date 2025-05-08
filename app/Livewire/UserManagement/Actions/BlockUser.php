<?php

namespace App\Livewire\UserManagement\Actions;

use Livewire\Component;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Rule;

class BlockUser extends Component
{
    public $showModal = false;
    public $userId;
    public $user;
    
    #[Rule('required|string|min:5', message: 'Please provide a reason with at least 5 characters')]
    public $blockReason = '';
    
    // Livewire 3 listeners
    protected function getListeners()
    {
        return [
            'blockUser' => 'blockUser',
        ];
    }

    public function blockUser($userId)
    {
        $this->userId = $userId;
        
        // Load the user
        $this->user = User::with(['company', 'role'])->find($userId);
        
        if (!$this->user) {
            $this->dispatch('notify', type: 'error', message: 'User not found.');
            return;
        }
        
        // Security check - verify permissions
        if (!auth()->user()->hasRole('super_admin') && 
            !(auth()->user()->hasRole('company_admin') && 
              auth()->user()->company_id == $this->user->company_id)) {
            $this->dispatch('notify', type: 'error', message: 'You do not have permission to perform this action.');
            return;
        }
        
        // Company admin cannot block other company admins
        if (auth()->user()->hasRole('company_admin') && 
            $this->user->role && 
            $this->user->role->name === 'company_admin') {
            $this->dispatch('notify', type: 'error', message: 'You cannot block another company admin.');
            return;
        }
        
        // Reset form fields
        $this->blockReason = '';
        $this->resetValidation();
        
        // Show the modal
        $this->showModal = true;
    }
    
    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['userId', 'user', 'blockReason']);
    }
    
    public function confirmBlock()
    {
        // Validate form
        $this->validate();
        
        try {
            DB::beginTransaction();
            
            // Block the user
            $this->user->update([
                'status' => 'inactive'
            ]);
            
            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'blocked',
                'model_type' => User::class,
                'model_id' => $this->user->id,
                'description' => "Blocked user: {$this->user->name}. Reason: {$this->blockReason}"
            ]);
            
            DB::commit();
            
            // Close modal and show success message
            $this->closeModal();
            
            // Emit event to refresh user list (Livewire 3 dispatch style)
            $this->dispatch('userBlocked');
            
            // Show notification (Livewire 3 dispatch style)
            $this->dispatch('notify', type: 'success', message: "User '{$this->user->name}' has been blocked successfully.");
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->dispatch('notify', type: 'error', message: 'Error: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.user-management.actions.block-user');
    }
}