<?php

// App/Livewire/UserManagement/Actions/UnblockUser.php

namespace App\Livewire\UserManagement\Actions;

use Livewire\Component;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class UnblockUser extends Component
{
    public $showModal = false;
    public $userId;
    public $user;
    
    // Listeners
    protected $listeners = ['unblockUser'];
    
    public function unblockUser($userId)
    {
        // Security checks similar to BlockUser component
        
        $this->userId = $userId;
        $this->user = User::with(['company', 'role'])->find($userId);
        
        // Additional check: if company is blocked, show warning
        $companyBlocked = $this->user->company && $this->user->company->is_blocked;
        
        if ($companyBlocked) {
            // Show appropriate message
        }
        
        $this->showModal = true;
    }
    
    public function confirmUnblock()
    {
        try {
            DB::beginTransaction();
            
            // Unblock the user
            $this->user->update([
                'status' => 'active'
            ]);
            
            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'unblocked',
                'model_type' => User::class,
                'model_id' => $this->user->id,
                'description' => "Unblocked user: {$this->user->name}"
            ]);
            
            DB::commit();
            
            // Close modal and emit event
            $this->showModal = false;
            $this->emit('userUnblocked');
            
        } catch (\Exception $e) {
            DB::rollBack();
            // Error handling
        }
    }
}