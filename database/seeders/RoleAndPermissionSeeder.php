<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * The email of the user who should be assigned superadmin role.
     */
    protected string $superadminEmail = 'superadmin@gmail.com';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Define roles and their permissions
        $rolesWithPermissions = [
            'user' => [
                'view-profile',
                'edit-profile',
            ],
            'admin' => [
                'view-profile',
                'edit-profile',
                'view-users',
                'create-users',
                'edit-users',
                'delete-users',
            ],
            'superadmin' => [
                // Superadmin gets all permissions
                'view-profile',
                'edit-profile',
                'view-users',
                'create-users',
                'edit-users',
                'delete-users',
                'manage-roles',
                'manage-permissions',
            ],
        ];

        // Collect all unique permissions
        $allPermissions = collect($rolesWithPermissions)
            ->flatten()
            ->unique()
            ->values();

        // Create all permissions first
        foreach ($allPermissions as $permissionName) {
            Permission::firstOrCreate(
                ['name' => $permissionName, 'guard_name' => 'web']
            );
        }

        // Create roles and assign permissions
        foreach ($rolesWithPermissions as $roleName => $permissions) {
            $role = Role::firstOrCreate(
                ['name' => $roleName, 'guard_name' => 'web']
            );
            
            $role->syncPermissions($permissions);
        }

        // Assign superadmin role to specified user
        $this->assignSuperadminRole();
    }

    /**
     * Assign superadmin role to a user by email.
     */
    protected function assignSuperadminRole(): void
    {
        // Create or find the superadmin user
        $user = User::firstOrCreate(
            ['email' => $this->superadminEmail],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('bismillah'),
                'phone' => '6281111111111',
                'email_verified_at' => now(),
            ]
        );

        $user->assignRole('superadmin');
        $this->command->info("Superadmin role assigned to: {$this->superadminEmail}");
    }
}
