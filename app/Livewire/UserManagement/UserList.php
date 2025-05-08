<?php

namespace App\Livewire\UserManagement;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Company;
use App\Models\ActivityLog;
use App\Models\PermissionLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Mail\UserCreated;
use App\Mail\PasswordReset;
use App\Mail\CompanyAdminInvitation;

class UserList extends Component
{
    use WithPagination, WithFileUploads;
    
    // Tab and state management
    public $activeTab = 'users';
    public $perPage = 10;
    public $searchTerm = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $filters = [
        'company' => '',
        'role' => '',
        'status' => '',
        'verified' => '',
        'date_range' => '',
    ];
    
    // Bulk actions
    public $selectedItems = [];
    public $selectAll = false;
    public $bulkAction = '';
    public $bulkRoleId = '';
    public $bulkCompanyId = '';
    public $deleteConfirmation = '';
    
    // Modal states
    public $showCreateUserModal = false;
    public $showCreateCompanyModal = false;
    public $showCreateRoleModal = false;
    public $showBlockModal = false;
    public $showBulkActionModal = false;
    public $showImportModal = false;
    public $showUserProfileModal = false;
    public $showPasswordResetModal = false;
    public $showImpersonateModal = false;
    public $showCustomPermissionsModal = false;
    public $showPermissionHistoryModal = false;
    public $showRolePermissionsModal = false;
    
    // User properties
    public $editingUserId;
    public $first_name;
    public $last_name;
    public $email;
    public $company_id;
    public $role_id;
    public $password;
    public $password_confirmation;
    public $new_password;
    public $send_welcome_email = true;
    public $status = 'active';
    
    // Company properties
    public $editingCompanyId;
    public $company_name;
    public $company_website;
    public $company_address;
    public $company_logo;
    public $company_logo_preview;
    public $company_logo_path;
    
    // Admin for new company
    public $admin_first_name;
    public $admin_last_name;
    public $admin_email;
    public $admin_password;
    public $send_admin_welcome_email = true;
    
    // Role properties
    public $editingRoleId;
    public $role_name;
    public $role_display_name;
    public $role_description;
    public $selectedPermissions = [];
    public $selectedRole;
    
    // View user
    public $viewingUser;
    public $userActivities = [];
    public $userPermissions = [];
    public $customPermissions = [];
    
    // Password reset
    public $resetPasswordUser;
    public $resetPasswordReason = 'user_request';
    public $resetPasswordNote;
    public $sendResetEmail = true;
    
    // Impersonation
    public $impersonateUser;
    public $impersonateReason = 'troubleshooting';
    public $impersonateNote;
    
    // Company blocking
    public $blockingCompany = false;
    public $blockingUser = false;
    public $blockEntityId;
    
    // Custom permissions
    public $permissionSearch = '';
    public $permissionCategoryFilter = '';
    public $customFilter = '';
    public $editingUser;
    public $customGrantedCount = 0;
    public $customDeniedCount = 0;
    public $totalPermissions = 0;
    public $logCustomPermissionChanges = true;
    
    // Permission history
    public $permissionHistory = [];

    protected $listeners = [
        'refreshUsers' => '$refresh',
        'fileUploaded' => 'handleFileUploaded',
    ];
    
    protected function rules()
    {
        $passwordRules = $this->editingUserId 
            ? 'nullable|min:8|same:password_confirmation' 
            : 'required|min:8|same:password_confirmation';
            
        $emailRule = $this->editingUserId 
            ? 'required|email|unique:users,email,'.$this->editingUserId 
            : 'required|email|unique:users';
            
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => $emailRule,
            'company_id' => 'nullable|exists:companies,id',
            'role_id' => 'nullable|exists:roles,id',
            'password' => $passwordRules,
            'status' => 'required|in:active,inactive,pending',
        ];
    }
    
    public function mount()
    {
        // Check if user has access to this page
        if (auth()->user()->can('view users')) {
            return redirect()->route('dashboard');
        }
        
        // If user is company admin, set company filter
        if (!auth()->user()->hasRole('company_admin')) {
            $this->filters['company'] = auth()->user()->company_id;
            
            // If no access to companies tab, show users tab
            if (!auth()->user()->can('view companies')) {
                $this->activeTab = 'users';
            }
        }
    }
    
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->loadAllIds();
        } else {
            $this->selectedItems = [];
        }
    }
    
    protected function loadAllIds()
    {
        if ($this->activeTab === 'companies') {
            $query = Company::query();
            $this->applyFilters($query);
            $this->selectedItems = $query->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } elseif ($this->activeTab === 'users') {
            $query = User::query();
            $this->applyFilters($query);
            $this->selectedItems = $query->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } elseif ($this->activeTab === 'roles') {
            $query = Role::query();
            $this->applyFilters($query);
            $this->selectedItems = $query->pluck('id')->map(fn($id) => (string) $id)->toArray();
        }
    }
    
    public function updatedActiveTab()
    {
        $this->resetPage();
        $this->selectedItems = [];
        $this->selectAll = false;
    }
    
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    public function resetFilters()
    {
        $this->filters = [
            'company' => auth()->user()->hasRole('company_admin') ? auth()->user()->company_id : '',
            'role' => '',
            'status' => '',
            'verified' => '',
            'date_range' => '',
        ];
        $this->searchTerm = '';
    }
    
    // User Management Methods
    public function showUserForm($userId = null)
    {
        $this->resetValidation();
        $this->resetErrorBag();
        
        if ($userId) {
            $user = User::findOrFail($userId);
            $this->editingUserId = $user->id;
            $this->first_name = $user->first_name;
            $this->last_name = $user->last_name;
            $this->email = $user->email;
            $this->company_id = $user->company_id;
            $this->role_id = $user->role_id;
            $this->status = $user->status;
            $this->password = '';
            $this->password_confirmation = '';
        } else {
            $this->resetUserForm();
            $this->editingUserId = null;
            $this->status = 'active';
            $this->send_welcome_email = true;
            
            // Set company ID for company admins automatically
            if (auth()->user()->hasRole('company_admin')) {
                $this->company_id = auth()->user()->company_id;
            }
        }
        
        $this->showCreateUserModal = true;
    }
    
    public function resetUserForm()
    {
        $this->editingUserId = null;
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->company_id = '';
        $this->role_id = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->new_password = '';
        $this->status = 'active';
        $this->send_welcome_email = true;
    }
    
    public function createUser()
    {
        $this->validate();
        
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
            
            $this->showCreateUserModal = false;
            $this->resetUserForm();
            
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
    
    public function updateUser()
    {
        // Validate without password if not provided
        if (empty($this->password)) {
            $this->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,'.$this->editingUserId,
                'company_id' => 'nullable|exists:companies,id',
                'role_id' => 'nullable|exists:roles,id',
                'status' => 'required|in:active,inactive,pending',
            ]);
        } else {
            $this->validate();
        }
        
        try {
            DB::beginTransaction();
            
            $user = User::findOrFail($this->editingUserId);
            
            // Save old company and role for logging
            $oldCompany = $user->company_id;
            $oldRole = $user->role_id;
            
            $userData = [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'name' => $this->first_name . ' ' . $this->last_name,
                'email' => $this->email,
                'company_id' => $this->company_id,
                'role_id' => $this->role_id,
                'status' => $this->status,
            ];
            
            // Only update password if provided
            if (!empty($this->password)) {
                $userData['password'] = Hash::make($this->password);
            }
            
            $user->update($userData);
            
            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'updated',
                'model_type' => User::class,
                'model_id' => $user->id,
                'description' => "Updated user: {$user->name}"
            ]);
            
            // Log company change
            if ($oldCompany != $user->company_id) {
                $oldCompanyName = Company::find($oldCompany)->name ?? 'None';
                $newCompanyName = Company::find($user->company_id)->name ?? 'None';
                
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'changed_company',
                    'model_type' => User::class,
                    'model_id' => $user->id,
                    'description' => "Changed company from {$oldCompanyName} to {$newCompanyName}"
                ]);
            }
            
            // Log role change
            if ($oldRole != $user->role_id) {
                $oldRoleName = Role::find($oldRole)->display_name ?? 'None';
                $newRoleName = Role::find($user->role_id)->display_name ?? 'None';
                
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'changed_role',
                    'model_type' => User::class,
                    'model_id' => $user->id,
                    'description' => "Changed role from {$oldRoleName} to {$newRoleName}"
                ]);
            }
            
            DB::commit();
            
            $this->showCreateUserModal = false;
            $this->resetUserForm();
            
            $this->dispatchBrowserEvent('notify', [
                'type' => 'success',
                'message' => 'User updated successfully!'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function confirmUserDeletion($id)
    {
        $this->editingUserId = $id;
        
        $this->dispatchBrowserEvent('confirm-delete', [
            'title' => 'Delete User',
            'text' => 'Are you sure you want to delete this user? This action cannot be undone.',
            'confirmButtonText' => 'Yes, delete it!',
        ]);
    }
    
    public function deleteUser()
    {
        try {
            DB::beginTransaction();
            
            $user = User::findOrFail($this->editingUserId);
            $userName = $user->name;
            
            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'deleted',
                'model_type' => User::class,
                'model_id' => $user->id,
                'description' => "Deleted user: {$userName}"
            ]);
            
            // Delete user
            $user->delete();
            
            DB::commit();
            
            $this->dispatchBrowserEvent('notify', [
                'type' => 'success',
                'message' => "User deleted successfully!"
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function viewUserProfile($id)
    {
        try {
            $this->viewingUser = User::with(['role', 'company'])->findOrFail($id);
            
            // Load user's recent activity
            $this->userActivities = ActivityLog::where('user_id', $id)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
                
            // Load user's permissions
            if ($this->viewingUser->role) {
                $this->userPermissions = $this->viewingUser->role->permissions;
            } else {
                $this->userPermissions = collect([]);
            }
            
            // Load custom permissions
            $this->customPermissions = DB::table('user_permissions')
                ->where('user_id', $id)
                ->get();
                
            // Show modal
            $this->showUserProfileModal = true;
            
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function blockUser($id)
    {
        $this->blockingCompany = false;
        $this->blockingUser = true;
        $this->blockEntityId = $id;
        $this->showBlockModal = true;
    }
    
    public function unblockUser($id)
    {
        try {
            DB::beginTransaction();
            
            $user = User::findOrFail($id);
            
            // Update user status
            $user->update([
                'status' => 'active',
            ]);
            
            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'unblocked',
                'model_type' => User::class,
                'model_id' => $user->id,
                'description' => "Unblocked user: {$user->name}"
            ]);
            
            DB::commit();
            
            $this->dispatchBrowserEvent('notify', [
                'type' => 'success',
                'message' => "User unblocked successfully!"
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function confirmBlock()
    {
        try {
            DB::beginTransaction();
            
            if ($this->blockingCompany) {
                $company = Company::findOrFail($this->blockEntityId);
                
                // Block the company
                $company->update(['is_blocked' => true]);
                
                // Log activity
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'blocked',
                    'model_type' => Company::class,
                    'model_id' => $company->id,
                    'description' => "Blocked company: {$company->name}"
                ]);
                
                // Also block all users from this company
                $users = User::where('company_id', $company->id)->get();
                
                foreach ($users as $user) {
                    $user->update(['status' => 'inactive']);
                    
                    // Log activity for each user
                    ActivityLog::create([
                        'user_id' => auth()->id(),
                        'action' => 'blocked',
                        'model_type' => User::class,
                        'model_id' => $user->id,
                        'description' => "Blocked user (company block): {$user->name}"
                    ]);
                }
                
                $message = "Company and all its users blocked successfully!";
            } else {
                $user = User::findOrFail($this->blockEntityId);
                
                // Block the user
                $user->update(['status' => 'inactive']);
                
                // Log activity
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'blocked',
                    'model_type' => User::class,
                    'model_id' => $user->id,
                    'description' => "Blocked user: {$user->name}"
                ]);
                
                $message = "User blocked successfully!";
            }
            
            DB::commit();
            
            $this->showBlockModal = false;
            
            $this->dispatchBrowserEvent('notify', [
                'type' => 'success',
                'message' => $message
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function resetUserPassword($id)
    {
        $this->resetPasswordUser = User::findOrFail($id);
        $this->resetPasswordReason = 'user_request';
        $this->resetPasswordNote = '';
        $this->sendResetEmail = true;
        
        $this->showPasswordResetModal = true;
    }
    
    public function executePasswordReset()
    {
        try {
            DB::beginTransaction();
            
            // Generate password reset token
            $token = app('auth.password.broker')->createToken($this->resetPasswordUser);
            
            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'reset_password',
                'model_type' => User::class,
                'model_id' => $this->resetPasswordUser->id,
                'description' => "Reset password for user: {$this->resetPasswordUser->name}"
            ]);
            
            // Send email if checked
            if ($this->sendResetEmail) {
                Mail::to($this->resetPasswordUser->email)->send(new PasswordReset(
                    $this->resetPasswordUser, 
                    $token, 
                    $this->resetPasswordReason, 
                    $this->resetPasswordNote
                ));
            }
            
            DB::commit();
            
            $this->showPasswordResetModal = false;
            
            $this->dispatchBrowserEvent('notify', [
                'type' => 'success',
                'message' => "Password reset successful!"
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function impersonateUser($id)
    {
        $this->impersonateUser = User::findOrFail($id);
        $this->impersonateReason = 'troubleshooting';
        $this->impersonateNote = '';
        
        $this->showImpersonateModal = true;
    }
    
    public function executeImpersonate()
    {
        try {
            DB::beginTransaction();
            
            // Log impersonation
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'impersonated',
                'model_type' => User::class,
                'model_id' => $this->impersonateUser->id,
                'description' => "Impersonated user: {$this->impersonateUser->name}, Reason: {$this->impersonateReason}" . 
                    ($this->impersonateNote ? ", Note: {$this->impersonateNote}" : "")
            ]);
            
            DB::commit();
            
            // Store original user ID in session
            session()->put('impersonator_id', auth()->id());
            
            // Login as target user
            auth()->login($this->impersonateUser);
            
            // Redirect to dashboard
            return redirect()->route('dashboard');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    // Company Management Methods
    public function showCompanyForm($id = null)
    {
        $this->resetValidation();
        $this->resetErrorBag();
        
        if ($id) {
            $company = Company::findOrFail($id);
            $this->editingCompanyId = $company->id;
            $this->company_name = $company->name;
            $this->company_website = $company->website;
            $this->company_address = $company->address;
            $this->company_logo_path = $company->logo_path;
        } else {
            $this->resetCompanyForm();
            $this->editingCompanyId = null;
            $this->send_admin_welcome_email = true;
        }
        
        $this->showCreateCompanyModal = true;
    }
    
    public function resetCompanyForm()
    {
        $this->editingCompanyId = null;
        $this->company_name = '';
        $this->company_website = '';
        $this->company_address = '';
        $this->company_logo = null;
        $this->company_logo_preview = null;
        $this->company_logo_path = null;
        $this->admin_first_name = '';
        $this->admin_last_name = '';
        $this->admin_email = '';
        $this->admin_password = '';
        $this->send_admin_welcome_email = true;
    }
    
    public function createCompany()
    {
        // Validate company data
        $this->validate([
            'company_name' => 'required|string|max:255',
            'company_website' => 'nullable|url',
            'company_address' => 'nullable|string',
            'company_logo' => 'nullable|image|max:1024',
            'admin_first_name' => 'required|string|max:255',
            'admin_last_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|min:8',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Upload logo if provided
            $logoPath = null;
            if ($this->company_logo) {
                $logoPath = $this->company_logo->store('company-logos', 'public');
            }
            
            // Create company
            $company = Company::create([
                'name' => $this->company_name,
                'website' => $this->company_website,
                'address' => $this->company_address,
                'logo_path' => $logoPath,
                'created_by' => auth()->id(),
            ]);
            
            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'created',
                'model_type' => Company::class,
                'model_id' => $company->id,
                'description' => "Created company: {$company->name}"
            ]);
            
            // Get company admin role
            $adminRole = Role::where('name', 'company_admin')->first();
            
            if (!$adminRole) {
                throw new \Exception('Company admin role not found!');
            }
            
            // Create company admin
            $admin = User::create([
                'first_name' => $this->admin_first_name,
                'last_name' => $this->admin_last_name,
                'name' => $this->admin_first_name . ' ' . $this->admin_last_name,
                'email' => $this->admin_email,
                'password' => Hash::make($this->admin_password),
                'company_id' => $company->id,
                'role_id' => $adminRole->id,
                'status' => 'active',
            ]);
            
            // Log admin creation
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'created',
                'model_type' => User::class,
                'model_id' => $admin->id,
                'description' => "Created company admin: {$admin->name} for company: {$company->name}"
            ]);
            
            // Send welcome email if checked
            if ($this->send_admin_welcome_email) {
                // Generate password reset token
                $token = app('auth.password.broker')->createToken($admin);
                
                Mail::to($admin->email)->send(new CompanyAdminInvitation($admin, $company, $token));
            }
            
            DB::commit();
            
            $this->showCreateCompanyModal = false;
            $this->resetCompanyForm();
            
            $this->dispatchBrowserEvent('notify', [
                'type' => 'success',
                'message' => 'Company created successfully!'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function updateCompany()
    {
        // Validate company data
        $this->validate([
            'company_name' => 'required|string|max:255',
            'company_website' => 'nullable|url',
            'company_address' => 'nullable|string',
            'company_logo' => 'nullable|image|max:1024',
        ]);
        
        try {


            DB::beginTransaction();
            
            $company = Company::findOrFail($this->editingCompanyId);
            
            // Upload logo if provided
            if ($this->company_logo) {
                // Delete old logo if exists
                if ($company->logo_path) {
                    Storage::disk('public')->delete($company->logo_path);
                }
                
                $logoPath = $this->company_logo->store('company-logos', 'public');
            } else {
                $logoPath = $company->logo_path;
            }
            
            // Update company
            $company->update([
                'name' => $this->company_name,
                'website' => $this->company_website,
                'address' => $this->company_address,
                'logo_path' => $logoPath,
            ]);
            
            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'updated',
                'model_type' => Company::class,
                'model_id' => $company->id,
                'description' => "Updated company: {$company->name}"
            ]);


            DB::commit();


        }catch(\Exception $e){

            DB::rollBack();

        }



        }






  



    public function blockCompany($id)
{
    $this->blockingCompany = true;
    $this->blockingUser = false;
    $this->blockEntityId = $id;
    $this->showBlockModal = true;
}

public function unblockCompany($id)
{
    try {
        DB::beginTransaction();
        
        $company = Company::findOrFail($id);
        
        // Unblock the company
        $company->update(['is_blocked' => false]);
        
        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'unblocked',
            'model_type' => Company::class,
            'model_id' => $company->id,
            'description' => "Unblocked company: {$company->name}"
        ]);
        
        DB::commit();
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => "Company unblocked successfully!"
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'error',
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
}

// Role Management Methods
public function showRoleForm($id = null)
{
    $this->resetValidation();
    $this->resetErrorBag();
    
    if ($id) {
        $role = Role::with('permissions')->findOrFail($id);
        $this->editingRoleId = $role->id;
        $this->role_name = $role->name;
        $this->role_display_name = $role->display_name;
        $this->role_description = $role->description;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
    } else {
        $this->resetRoleForm();
        $this->editingRoleId = null;
    }
    
    $this->showCreateRoleModal = true;
}

public function resetRoleForm()
{
    $this->editingRoleId = null;
    $this->role_name = '';
    $this->role_display_name = '';
    $this->role_description = '';
    $this->selectedPermissions = [];
}

public function createRole()
{
    // Validate role data
    $this->validate([
        'role_name' => 'required|string|max:255|unique:roles,name',
        'role_display_name' => 'required|string|max:255',
        'role_description' => 'nullable|string',
        'selectedPermissions' => 'array',
    ]);
    
    try {
        DB::beginTransaction();
        
        // Create role
        $role = Role::create([
            'name' => $this->role_name,
            'display_name' => $this->role_display_name,
            'description' => $this->role_description,
            'created_by' => auth()->id(),
        ]);
        
        // Attach permissions
        if (count($this->selectedPermissions) > 0) {
            $role->permissions()->attach($this->selectedPermissions);
        }
        
        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => Role::class,
            'model_id' => $role->id,
            'description' => "Created role: {$role->display_name}"
        ]);
        
        DB::commit();
        
        $this->showCreateRoleModal = false;
        $this->resetRoleForm();
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Role created successfully!'
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'error',
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
}

public function updateRole()
{
    // Special validation for protected roles
    if (in_array($this->role_name, ['super_admin', 'company_admin']) && !auth()->user()->hasRole('super_admin')) {
        $this->dispatchBrowserEvent('notify', [
            'type' => 'error',
            'message' => 'You cannot modify system roles.'
        ]);
        return;
    }
    
    // Validate role data
    $this->validate([
        'role_name' => 'required|string|max:255|unique:roles,name,'.$this->editingRoleId,
        'role_display_name' => 'required|string|max:255',
        'role_description' => 'nullable|string',
        'selectedPermissions' => 'array',
    ]);
    
    try {
        DB::beginTransaction();
        
        $role = Role::findOrFail($this->editingRoleId);
        
        // Prevent modifying system role names
        if (in_array($role->name, ['super_admin', 'company_admin']) && $this->role_name !== $role->name) {
            throw new \Exception('Cannot change the name of system roles.');
        }
        
        // Update role
        $role->update([
            'name' => $this->role_name,
            'display_name' => $this->role_display_name,
            'description' => $this->role_description,
        ]);
        
        // Sync permissions
        $role->permissions()->sync($this->selectedPermissions);
        
        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => Role::class,
            'model_id' => $role->id,
            'description' => "Updated role: {$role->display_name}"
        ]);
        
        DB::commit();
        
        $this->showCreateRoleModal = false;
        $this->resetRoleForm();
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Role updated successfully!'
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'error',
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
}

public function confirmRoleDeletion($id)
{
    $role = Role::findOrFail($id);
    
    // Prevent deleting system roles
    if (in_array($role->name, ['super_admin', 'company_admin'])) {
        $this->dispatchBrowserEvent('notify', [
            'type' => 'error',
            'message' => 'Cannot delete system roles.'
        ]);
        return;
    }
    
    $this->editingRoleId = $id;
    
    $this->dispatchBrowserEvent('confirm-delete', [
        'title' => 'Delete Role',
        'text' => 'Are you sure you want to delete this role? All users with this role will lose their permissions.',
        'confirmButtonText' => 'Yes, delete it!',
    ]);
}

public function deleteRole()
{
    try {
        DB::beginTransaction();
        
        $role = Role::findOrFail($this->editingRoleId);
        $roleName = $role->display_name;
        
        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => Role::class,
            'model_id' => $role->id,
            'description' => "Deleted role: {$roleName}"
        ]);
        
        // Delete role
        $role->delete();
        
        DB::commit();
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => "Role deleted successfully!"
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'error',
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
}

public function manageRolePermissions($id)
{
    $role = Role::with('permissions')->findOrFail($id);
    
    $this->editingRoleId = $role->id;
    $this->selectedRole = $role;
    $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
    
    $this->showRolePermissionsModal = true;
}

public function saveRolePermissions()
{
    try {
        DB::beginTransaction();
        
        $role = Role::findOrFail($this->editingRoleId);
        
        // Sync permissions
        $role->permissions()->sync($this->selectedPermissions);
        
        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated_permissions',
            'model_type' => Role::class,
            'model_id' => $role->id,
            'description' => "Updated permissions for role: {$role->display_name}"
        ]);
        
        DB::commit();
        
        $this->showRolePermissionsModal = false;
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Role permissions updated successfully!'
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'error',
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
}

// Custom User Permissions Methods
public function editCustomPermissions($userId)
{
    $this->editingUser = User::with(['role', 'role.permissions', 'permissions'])->findOrFail($userId);
    $this->customPermissions = [];
    
    // Load all permissions
    $allPermissions = Permission::all();
    $this->totalPermissions = $allPermissions->count();
    
    // Set up tracking for permissions
    foreach ($allPermissions as $permission) {
        // Check if user has a custom setting for this permission
        $customPermission = $this->editingUser->permissions()
            ->where('permission_id', $permission->id)
            ->first();
            
        if ($customPermission) {
            // User has a custom setting
            $this->customPermissions[$permission->id] = $customPermission->pivot->value ? 'grant' : 'deny';
        } else {
            // User inherits from role
            $this->customPermissions[$permission->id] = 'inherit';
        }
    }
    
    // Count custom permissions
    $this->updateCustomPermissionCounts();
    
    $this->showCustomPermissionsModal = true;
}

public function updateCustomPermissionCounts()
{
    $this->customGrantedCount = count(array_filter($this->customPermissions, function($value) {
        return $value === 'grant';
    }));
    
    $this->customDeniedCount = count(array_filter($this->customPermissions, function($value) {
        return $value === 'deny';
    }));
}

public function setCustomPermission($permissionId, $value)
{
    $this->customPermissions[$permissionId] = $value;
    $this->updateCustomPermissionCounts();
}

public function clearAllCustomPermissions()
{
    foreach ($this->customPermissions as $key => $value) {
        $this->customPermissions[$key] = 'inherit';
    }
    
    $this->updateCustomPermissionCounts();
}

public function resetToRolePermissions()
{
    $this->clearAllCustomPermissions();
    
    $this->dispatchBrowserEvent('notify', [
        'type' => 'success',
        'message' => 'Reset to role permissions. Click Save to apply changes.'
    ]);
}

public function toggleCategoryPermissions($category)
{
    // Get permissions in this category
    $permissions = Permission::where('category', $category)->get();
    
    // Check if all are currently granted
    $allGranted = true;
    foreach ($permissions as $permission) {
        if ($this->customPermissions[$permission->id] !== 'grant') {
            $allGranted = false;
            break;
        }
    }
    
    // Toggle all permissions in the category
    foreach ($permissions as $permission) {
        $this->customPermissions[$permission->id] = $allGranted ? 'inherit' : 'grant';
    }
    
    $this->updateCustomPermissionCounts();
}

public function allCategoryPermissionsSelected($category)
{
    // Get permissions in this category
    $permissions = Permission::where('category', $category)->get();
    
    // Check if all are currently granted
    foreach ($permissions as $permission) {
        if ($this->customPermissions[$permission->id] !== 'grant') {
            return false;
        }
    }
    
    return true;
}

public function saveCustomPermissions()
{
    try {
        DB::beginTransaction();
        
        $user = User::findOrFail($this->editingUser->id);
        
        // Get original custom permissions for logging changes
        $originalCustomPermissions = $user->permissions()
            ->get()
            ->pluck('pivot.value', 'id')
            ->toArray();
        
        // Clear existing custom permissions
        $user->permissions()->detach();
        
        // Add new custom permissions
        foreach ($this->customPermissions as $permissionId => $value) {
            if ($value !== 'inherit') {
                $user->permissions()->attach($permissionId, [
                    'value' => $value === 'grant' ? true : false,
                ]);
                
                // Log each permission change if enabled
                if ($this->logCustomPermissionChanges) {
                    $permission = Permission::find($permissionId);
                    $originalValue = isset($originalCustomPermissions[$permissionId]) 
                        ? ($originalCustomPermissions[$permissionId] ? 'grant' : 'deny') 
                        : 'inherit';
                    
                    // Only log if there's a change
                    if ($originalValue !== $value) {
                        PermissionLog::create([
                            'user_id' => $user->id,
                            'admin_id' => auth()->id(),
                            'permission_id' => $permissionId,
                            'action' => 'updated',
                            'type' => $value,
                            'note' => "Changed from {$originalValue} to {$value}",
                        ]);
                    }
                }
            }
        }
        
        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated_permissions',
            'model_type' => User::class,
            'model_id' => $user->id,
            'description' => "Updated custom permissions for user: {$user->name}"
        ]);
        
        DB::commit();
        
        $this->showCustomPermissionsModal = false;
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Custom permissions saved successfully!'
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'error',
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
}

public function viewPermissionHistory($userId)
{
    $this->viewingUser = User::findOrFail($userId);
    
    // Load permission history
    $this->permissionHistory = PermissionLog::with(['admin', 'permission'])
        ->where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get();
        
    $this->showPermissionHistoryModal = true;
}

// Bulk Actions Methods
public function executeBulkAction()
{
    if (empty($this->selectedItems) || empty($this->bulkAction)) {
        $this->dispatchBrowserEvent('notify', [
            'type' => 'error',
            'message' => 'Please select items and an action to perform.'
        ]);
        return;
    }
    
    // For delete action, require confirmation text
    if ($this->bulkAction === 'delete' && $this->deleteConfirmation !== 'DELETE') {
        $this->dispatchBrowserEvent('notify', [
            'type' => 'error',
            'message' => 'Please type DELETE to confirm deletion.'
        ]);
        return;
    }
    
    try {
        DB::beginTransaction();
        
        $successMessage = '';
        
        // Process based on active tab and selected action
        if ($this->activeTab === 'companies') {
            $successMessage = $this->executeBulkCompanyAction();
        } elseif ($this->activeTab === 'users') {
            $successMessage = $this->executeBulkUserAction();
        } elseif ($this->activeTab === 'roles') {
            $successMessage = $this->executeBulkRoleAction();
        }
        
        DB::commit();
        
        $this->showBulkActionModal = false;
        $this->bulkAction = '';
        $this->bulkRoleId = '';
        $this->bulkCompanyId = '';
        $this->deleteConfirmation = '';
        $this->selectedItems = [];
        $this->selectAll = false;
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => $successMessage
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'error',
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
}

protected function executeBulkCompanyAction()
{
    switch ($this->bulkAction) {
        case 'block':
            foreach ($this->selectedItems as $companyId) {
                $company = Company::findOrFail($companyId);
                
                // Skip if already blocked
                if ($company->is_blocked) {
                    continue;
                }
                
                // Block company
                $company->update(['is_blocked' => true]);
                
                // Block all users in company
                User::where('company_id', $companyId)->update(['status' => 'inactive']);
                
                // Log activity
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'blocked',
                    'model_type' => Company::class,
                    'model_id' => $companyId,
                    'description' => "Blocked company: {$company->name} (bulk action)"
                ]);
            }
            return count($this->selectedItems) . ' companies blocked successfully!';
            
        case 'unblock':
            foreach ($this->selectedItems as $companyId) {
                $company = Company::findOrFail($companyId);
                
                // Skip if not blocked
                if (!$company->is_blocked) {
                    continue;
                }
                
                // Unblock company
                $company->update(['is_blocked' => false]);
                
                // Log activity
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'unblocked',
                    'model_type' => Company::class,
                    'model_id' => $companyId,
                    'description' => "Unblocked company: {$company->name} (bulk action)"
                ]);
            }
            return count($this->selectedItems) . ' companies unblocked successfully!';
            
        case 'delete':
            foreach ($this->selectedItems as $companyId) {
                $company = Company::findOrFail($companyId);
                
                // Log activity
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'deleted',
                    'model_type' => Company::class,
                    'model_id' => $companyId,
                    'description' => "Deleted company: {$company->name} (bulk action)"
                ]);
                
                // Delete company
                $company->delete();
            }
            return count($this->selectedItems) . ' companies deleted successfully!';
            
        default:
            throw new \Exception('Invalid bulk action.');
    }
}

protected function executeBulkUserAction()
{
    switch ($this->bulkAction) {
        case 'block':
            foreach ($this->selectedItems as $userId) {
                $user = User::findOrFail($userId);
                
                // Skip if already blocked
                if ($user->status === 'inactive') {
                    continue;
                }
                
                // Block user
                $user->update(['status' => 'inactive']);
                
                // Log activity
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'blocked',
                    'model_type' => User::class,
                    'model_id' => $userId,
                    'description' => "Blocked user: {$user->name} (bulk action)"
                ]);
            }
            return count($this->selectedItems) . ' users blocked successfully!';
            
        case 'unblock':
            foreach ($this->selectedItems as $userId) {
                $user = User::findOrFail($userId);
                
                // Skip if not blocked or company is blocked
                if ($user->status !== 'inactive' || ($user->company && $user->company->is_blocked)) {
                    continue;
                }
                
                // Unblock user
                $user->update(['status' => 'active']);
                
                // Log activity
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'unblocked',
                    'model_type' => User::class,
                    'model_id' => $userId,
                    'description' => "Unblocked user: {$user->name} (bulk action)"
                ]);
            }
            return count($this->selectedItems) . ' users unblocked successfully!';
            
        case 'delete':
            foreach ($this->selectedItems as $userId) {
                $user = User::findOrFail($userId);
                
                // Log activity
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'deleted',
                    'model_type' => User::class,
                    'model_id' => $userId,
                    'description' => "Deleted user: {$user->name} (bulk action)"
                ]);
                
                // Delete user
                $user->delete();
            }
            return count($this->selectedItems) . ' users deleted successfully!';
            
        case 'change_role':
            if (empty($this->bulkRoleId)) {
                throw new \Exception('Please select a role.');
            }
            
            $role = Role::findOrFail($this->bulkRoleId);
            
            foreach ($this->selectedItems as $userId) {
                $user = User::findOrFail($userId);
                
                // Skip if already has this role
                if ($user->role_id == $this->bulkRoleId) {
                    continue;
                }
                
                $oldRoleName = $user->role ? $user->role->display_name : 'None';
                
                // Update user role
                $user->update(['role_id' => $this->bulkRoleId]);
                
                // Log activity
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'changed_role',
                    'model_type' => User::class,
                    'model_id' => $userId,
                    'description' => "Changed role for user: {$user->name} from {$oldRoleName} to {$role->display_name} (bulk action)"
                ]);
            }
            return count($this->selectedItems) . ' users updated with new role!';
            
        case 'change_company':
            if (empty($this->bulkCompanyId)) {
                throw new \Exception('Please select a company.');
            }
            
            $company = Company::findOrFail($this->bulkCompanyId);
            
            foreach ($this->selectedItems as $userId) {
                $user = User::findOrFail($userId);
                
                // Skip if already in this company
                if ($user->company_id == $this->bulkCompanyId) {
                    continue;
                }
                
                $oldCompanyName = $user->company ? $user->company->name : 'None';
                
                // Update user company
                $user->update(['company_id' => $this->bulkCompanyId]);
                
                // Log activity
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'changed_company',
                    'model_type' => User::class,
                    'model_id' => $userId,
                    'description' => "Changed company for user: {$user->name} from {$oldCompanyName} to {$company->name} (bulk action)"
                ]);
            }
            return count($this->selectedItems) . ' users moved to new company!';
            
        case 'resend_verification':
            $count = 0;
            foreach ($this->selectedItems as $userId) {
                $user = User::findOrFail($userId);
                
                // Skip if already verified
                if ($user->email_verified_at) {
                    continue;
                }
                
                // Create verification URL (implementation depends on your setup)
                $verificationUrl = route('verification.verify', [
                    'id' => $user->id,
                    'hash' => sha1($user->email),
                ]);
                
                // Send verification email
                Mail::to($user->email)->send(new \App\Mail\VerifyEmail($user, $verificationUrl));
                
                // Log activity
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'resent_verification',
                    'model_type' => User::class,
                    'model_id' => $userId,
                    'description' => "Resent verification email to user: {$user->name} (bulk action)"
                ]);
                
                $count++;
            }
            return $count . ' verification emails sent!';
            
        default:
            throw new \Exception('Invalid bulk action.');
    }
}

protected function executeBulkRoleAction()
{
    if ($this->bulkAction === 'delete') {
        $count = 0;
        foreach ($this->selectedItems as $roleId) {
            $role = Role::findOrFail($roleId);
            
            // Skip system roles
            if (in_array($role->name, ['super_admin', 'company_admin'])) {
                continue;
            }
            
            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'deleted',
                'model_type' => Role::class,
                'model_id' => $roleId,
                'description' => "Deleted role: {$role->display_name} (bulk action)"
            ]);
            
            // Delete role
            $role->delete();
            $count++;
        }
        return $count . ' roles deleted successfully!';
    } else {
        throw new \Exception('Invalid bulk action for roles.');
    }
}

// File Upload Handling
public function handleFileUploaded($event)
{
    // Handle file upload completion
    $file = $event['file'];
    $type = $event['type'];
    
    if ($type === 'company_logo') {
        $this->company_logo_preview = $file['temporaryUrl'];
    }
}

protected function applyFilters($query)
{
    // Apply search term
    if (!empty($this->searchTerm)) {
        $query->where(function ($q) {
            // The exact fields depend on the active tab and model
            if ($this->activeTab === 'companies') {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('website', 'like', '%' . $this->searchTerm . '%');
            } elseif ($this->activeTab === 'users') {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('first_name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            } elseif ($this->activeTab === 'roles') {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('display_name', 'like', '%' . $this->searchTerm . '%');
            }
        });
    }
    
    // Apply specific filters based on the active tab
    if ($this->activeTab === 'companies' && !empty($this->filters['status'])) {
        if ($this->filters['status'] === 'active') {
            $query->where('is_blocked', false);
        } elseif ($this->filters['status'] === 'blocked') {
            $query->where('is_blocked', true);
        }
    } elseif ($this->activeTab === 'users') {
        // Company filter
        if (!empty($this->filters['company'])) {
            $query->where('company_id', $this->filters['company']);
        }
        
        // Role filter
        if (!empty($this->filters['role'])) {
            $query->where('role_id', $this->filters['role']);
        }
        
        // Status filter
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        
        // Verification filter
        if (!empty($this->filters['verified'])) {
            if ($this->filters['verified'] === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($this->filters['verified'] === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }
    }
    
    // Date range filter
    if (!empty($this->filters['date_range'])) {
        list($startDate, $endDate) = explode(' to ', $this->filters['date_range']);
        $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
    }
    
    return $query;
}

public function render()
{
    // Prepare variables for view
    $companies = collect([]);
    $users = collect([]);
    $roles = collect([]);
    
    // Stats for dashboard
    $activeCompanies = 0;
    $blockedCompanies = 0;
    $totalUsers = 0;
    $activeUsers = 0;
    $pendingVerifications = 0;
    $expiringAccess = 0;
    
    // Query based on active tab
    if ($this->activeTab === 'companies') {
        $query = Company::withCount(['users', 'users as active_users_count' => function ($query) {
            $query->where('status', 'active');
        }])->withCount(['users as admins_count' => function ($query) {
            $query->whereHas('

    role', function ($query) {
                    $query->where('name', 'company_admin');
                });
            }]);

            $this->applyFilters($query);

            $companies = $query->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage);

            $activeCompanies = Company::where('is_blocked', false)->count();
            $blockedCompanies = Company::where('is_blocked', true)->count();
        } elseif ($this->activeTab === 'users') {
            $query = User::with(['role', 'company']);

            $this->applyFilters($query);

            $users = $query->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage);

            $totalUsers = User::count();
            $activeUsers = User::where('status', 'active')->count();
            $pendingVerifications = User::whereNull('email_verified_at')->count();
        } elseif ($this->activeTab === 'roles') {
            $query = Role::withCount('permissions');

            $this->applyFilters($query);

            $roles = $query->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage);
        }

        return view('livewire.user-management.user-list', [
            'companies' => $companies,
            'users' => $users,
            'roles' => $roles,
            'activeCompanies' => $activeCompanies,
            'blockedCompanies' => $blockedCompanies,
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'pendingVerifications' => $pendingVerifications,
            'expiringAccess' => $expiringAccess,
        ]);
    }
}

