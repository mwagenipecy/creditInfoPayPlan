<?php

// App/Livewire/UserManagement/Actions/VerifyUser.php

namespace App\Livewire\UserManagement\Actions;

use Livewire\Component;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class VerifyUser extends Component
{
    public $showModal = false;
    public $userId;
    public $user;
    public $sendNotification = true;
    
    // Listeners
    protected $listeners = ['verifyUser'];
    
    public function verifyUser($userId)
    {
        // Security checks
        
        $this->userId = $userId;
        $this->user = User::find($userId);
        
        if ($this->user->email_verified_at) {
            // User already verified - show message
            return;
        }
        
        $this->showModal = true;
    }
    
    public function confirmVerification()
    {
        try {
            DB::beginTransaction();
            
            // Mark email as verified
            $this->user->update([
                'email_verified_at' => now()
            ]);
            
            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'verified_email',
                'model_type' => User::class,
                'model_id' => $this->user->id,
                'description' => "Manually verified email for user: {$this->user->name}"
            ]);
            
            // Send notification if requested
            if ($this->sendNotification) {
                // Email logic
            }
            
            DB::commit();
            
            $this->showModal = false;
            $this->emit('userVerified');
            
        } catch (\Exception $e) {
            DB::rollBack();
            // Error handling
        }
    }
}
