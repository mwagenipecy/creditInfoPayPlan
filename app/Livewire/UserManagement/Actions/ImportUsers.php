<?php

// App/Livewire/UserManagement/Actions/ImportUsers.php

namespace App\Livewire\UserManagement\Actions;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Company;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ImportUsers extends Component
{
    use WithFileUploads;
    
    public $showModal = false;
    public $csvFile;
    public $company_id;
    public $role_id;
    public $notifyUsers = true;
    public $importResults = [];
    public $companies=[];
    public $roles=[];
    public $isProcessing = false;
    public $processComplete = false;
    
    // Listeners
    protected $listeners = ['openModal'];
    
    public function openModal()
    {
        // Security check - only super admin can import users
        if (!auth()->user()->hasRole('super_admin')) {
            return;
        }
        
        $this->resetImport();
        $this->showModal = true;
    }
    
    public function resetImport()
    {
        $this->csvFile = null;
        $this->company_id = '';
        $this->role_id = '';
        $this->notifyUsers = true;
        $this->importResults = [];
        $this->isProcessing = false;
        $this->processComplete = false;
    }
    
    public function processImport()
    {
        // Validate file
        $this->validate([
            'csvFile' => 'required|file|mimes:csv,txt|max:10240',
            'company_id' => 'required|exists:companies,id',
            'role_id' => 'required|exists:roles,id',
        ]);
        
        $this->isProcessing = true;
        
        // Process CSV file
        // Logic for parsing CSV and creating users
        // Track success/failure for each row
        
        $this->processComplete = true;
        $this->isProcessing = false;
        
        // Emit event to refresh user list
        $this->emit('userCreated');
    }
}