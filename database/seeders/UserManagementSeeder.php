<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Company;

class UserManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create default permissions
        $this->createPermissions();
        
        // Create default roles
        $this->createRoles();
        
        // Create super admin user
        $this->createSuperAdmin();
        
        // Create demo company with users (optional)
      //  $this->createDemoCompany();
    }
    
    /**
     * Create the default permissions.
     *
     * @return void
     */
    private function createPermissions()
    {
        $permissions = [
            // User management permissions
            [
                'name' => 'view_users',
                'display_name' => 'View Users',
                'description' => 'Can view user list and details',
                'category' => 'users',
            ],
            [
                'name' => 'create_users',
                'display_name' => 'Create Users',
                'description' => 'Can create new users',
                'category' => 'users',
            ],
            [
                'name' => 'edit_users',
                'display_name' => 'Edit Users',
                'description' => 'Can edit existing users',
                'category' => 'users',
            ],
            [
                'name' => 'delete_users',
                'display_name' => 'Delete Users',
                'description' => 'Can delete users',
                'category' => 'users',
            ],
            [
                'name' => 'impersonate_users',
                'display_name' => 'Impersonate Users',
                'description' => 'Can login as another user',
                'category' => 'users',
            ],
            [
                'name' => 'reset_user_passwords',
                'display_name' => 'Reset User Passwords',
                'description' => 'Can reset user passwords',
                'category' => 'users',
            ],
            [
                'name' => 'block_users',
                'display_name' => 'Block Users',
                'description' => 'Can block user access',
                'category' => 'users',
            ],
            [
                'name' => 'unblock_users',
                'display_name' => 'Unblock Users',
                'description' => 'Can unblock user access',
                'category' => 'users',
            ],
            
            // Company management permissions
            [
                'name' => 'view_companies',
                'display_name' => 'View Companies',
                'description' => 'Can view company list and details',
                'category' => 'companies',
            ],
            [
                'name' => 'create_companies',
                'display_name' => 'Create Companies',
                'description' => 'Can create new companies',
                'category' => 'companies',
            ],
            [
                'name' => 'edit_companies',
                'display_name' => 'Edit Companies',
                'description' => 'Can edit existing companies',
                'category' => 'companies',
            ],
            [
                'name' => 'delete_companies',
                'display_name' => 'Delete Companies',
                'description' => 'Can delete companies',
                'category' => 'companies',
            ],
            [
                'name' => 'block_companies',
                'display_name' => 'Block Companies',
                'description' => 'Can block company access',
                'category' => 'companies',
            ],
            [
                'name' => 'unblock_companies',
                'display_name' => 'Unblock Companies',
                'description' => 'Can unblock company access',
                'category' => 'companies',
            ],
            
            // Role management permissions
            [
                'name' => 'view_roles',
                'display_name' => 'View Roles',
                'description' => 'Can view role list and details',
                'category' => 'roles',
            ],
            [
                'name' => 'create_roles',
                'display_name' => 'Create Roles',
                'description' => 'Can create new roles',
                'category' => 'roles',
            ],
            [
                'name' => 'edit_roles',
                'display_name' => 'Edit Roles',
                'description' => 'Can edit existing roles',
                'category' => 'roles',
            ],
            [
                'name' => 'delete_roles',
                'display_name' => 'Delete Roles',
                'description' => 'Can delete roles',
                'category' => 'roles',
            ],
            
            // Permission management permissions
            [
                'name' => 'view_permissions',
                'display_name' => 'View Permissions',
                'description' => 'Can view permissions',
                'category' => 'permissions',
            ],
            [
                'name' => 'manage_permissions',
                'display_name' => 'Manage Permissions',
                'description' => 'Can manage role permissions',
                'category' => 'permissions',
            ],
            [
                'name' => 'manage_custom_permissions',
                'display_name' => 'Manage Custom Permissions',
                'description' => 'Can manage user custom permissions',
                'category' => 'permissions',
            ],
            
            // Activity log permissions
            [
                'name' => 'view_activity_log',
                'display_name' => 'View Activity Log',
                'description' => 'Can view activity logs',
                'category' => 'logs',
            ],
            [
                'name' => 'view_permission_history',
                'display_name' => 'View Permission History',
                'description' => 'Can view permission change history',
                'category' => 'logs',
            ],
            
            // Access request management
            [
                'name' => 'request_access',
                'display_name' => 'Request Access',
                'description' => 'Can request external user access',
                'category' => 'access',
            ],
            [
                'name' => 'approve_access_requests',
                'display_name' => 'Approve Access Requests',
                'description' => 'Can approve access requests',
                'category' => 'access',
            ],
            [
                'name' => 'reject_access_requests',
                'display_name' => 'Reject Access Requests',
                'description' => 'Can reject access requests',
                'category' => 'access',
            ],
            [
                'name' => 'revoke_access',
                'display_name' => 'Revoke Access',
                'description' => 'Can revoke user access',
                'category' => 'access',
            ],
        ];
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                [
                    'display_name' => $permission['display_name'],
                    'description' => $permission['description'],
                    'category' => $permission['category'],
                ]
            );
        }
    }
    
    /**
     * Create the default roles.
     *
     * @return void
     */
    private function createRoles()
    {
        // Super Admin role
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'super_admin'],
            [
                'display_name' => 'Super Admin',
                'description' => 'Has full system access and permissions',
            ]
        );
        
        // Company Admin role
        $companyAdminRole = Role::firstOrCreate(
            ['name' => 'company_admin'],
            [
                'display_name' => 'Company Admin',
                'description' => 'Can manage users within their company',
            ]
        );
        
        // Regular User role
        $userRole = Role::firstOrCreate(
            ['name' => 'user'],
            [
                'display_name' => 'User',
                'description' => 'Standard user with basic access',
            ]
        );
        
        // Assign all permissions to Super Admin
        $superAdminRole->permissions()->sync(Permission::all());
        
        // Assign specific permissions to Company Admin
        $companyAdminPermissions = Permission::whereIn('name', [
            'view_users', 'create_users', 'edit_users', 'block_users', 'unblock_users',
            'reset_user_passwords', 'request_access', 'revoke_access',
            'view_activity_log', 'view_permissions'
        ])->get();
        
        $companyAdminRole->permissions()->sync($companyAdminPermissions);
        
        // Assign limited permissions to regular User
        $userPermissions = Permission::whereIn('name', [
            'view_users'
        ])->get();
        
        $userRole->permissions()->sync($userPermissions);
    }
    
    /**
     * Create the super admin user.
     *
     * @return void
     */
    private function createSuperAdmin()
    {
        $superAdminRole = Role::where('name', 'super_admin')->first();
        
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'System Administrator',
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'password' => Hash::make('password'), // Change in production!
                'role_id' => $superAdminRole->id,
                'email_verified_at' => now(),
                'status' => 'active',
            ]
        );
    }
    
    /**
     * Create a demo company with users.
     *
     * @return void
     */
    private function createDemoCompany()
    {
        // Only create demo data if in local or development environment
        if (app()->environment('local', 'development')) {
            // Create demo company
            $company = Company::firstOrCreate(
                ['name' => 'Demo Company'],
                [
                    'website' => 'https://demo-company.example.com',
                    'address' => '123 Demo Street, Demo City',
                    'created_by' => 1, // Super Admin
                ]
            );
            
            // Get role IDs
            $companyAdminRole = Role::where('name', 'company_admin')->first();
            $userRole = Role::where('name', 'user')->first();
            
            // Create company admin
            $companyAdmin = User::firstOrCreate(
                ['email' => 'company-admin@example.com'],
                [
                    'name' => 'Company Admin',
                    'first_name' => 'Company',
                    'last_name' => 'Admin',
                    'password' => Hash::make('password'), // Change in production!
                    'company_id' => $company->id,
                    'role_id' => $companyAdminRole->id,
                    'email_verified_at' => now(),
                    'status' => 'active',
                ]
            );
            
            // Create a few regular users
            $demoUsers = [
                [
                    'email' => 'user1@example.com',
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                ],
                [
                    'email' => 'user2@example.com',
                    'first_name' => 'Jane',
                    'last_name' => 'Smith',
                ],
                [
                    'email' => 'user3@example.com',
                    'first_name' => 'Robert',
                    'last_name' => 'Johnson',
                ],
            ];
            
            foreach ($demoUsers as $userData) {
                User::firstOrCreate(
                    ['email' => $userData['email']],
                    [
                        'name' => $userData['first_name'] . ' ' . $userData['last_name'],
                        'first_name' => $userData['first_name'],
                        'last_name' => $userData['last_name'],
                        'password' => Hash::make('password'), // Change in production!
                        'company_id' => $company->id,
                        'role_id' => $userRole->id,
                        'email_verified_at' => now(),
                        'status' => 'active',
                    ]
                );
            }
        }
    }
}