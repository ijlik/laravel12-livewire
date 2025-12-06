<?php

namespace App\Livewire\Admin\Rbac;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Collection;

#[Layout('layouts.app')]
#[Title('Role-Permission Matrix')]
class RolePermissionMatrix extends Component
{
    public string $searchPermission = '';
    public string $searchRole = '';
    
    // Store role-permission mappings as a simple array for efficient lookup
    public array $rolePermissionMap = [];

    public function mount(): void
    {
        $this->loadRolePermissionMap();
    }

    protected function loadRolePermissionMap(): void
    {
        // Build a map of role_id => [permission_id, permission_id, ...]
        $this->rolePermissionMap = [];
        
        $roles = Role::with('permissions')->get();
        
        foreach ($roles as $role) {
            $this->rolePermissionMap[$role->id] = $role->permissions->pluck('id')->toArray();
        }
    }

    public function hasPermission(int $roleId, int $permissionId): bool
    {
        return isset($this->rolePermissionMap[$roleId]) 
            && in_array($permissionId, $this->rolePermissionMap[$roleId]);
    }

    public function togglePermission(int $roleId, int $permissionId): void
    {
        try {
            $role = Role::findById($roleId);
            $permission = Permission::findById($permissionId);

            if (!$role || !$permission) {
                session()->flash('error', 'Role or Permission not found.');
                return;
            }

            if ($role->hasPermissionTo($permission)) {
                $role->revokePermissionTo($permission);
                
                // Update local map - remove permission
                if (isset($this->rolePermissionMap[$roleId])) {
                    $this->rolePermissionMap[$roleId] = array_values(
                        array_diff($this->rolePermissionMap[$roleId], [$permissionId])
                    );
                }
                
                $this->dispatch('permission-toggled', [
                    'action' => 'revoked',
                    'role' => $role->name,
                    'permission' => $permission->name,
                ]);
            } else {
                $role->givePermissionTo($permission);
                
                // Update local map - add permission
                if (!isset($this->rolePermissionMap[$roleId])) {
                    $this->rolePermissionMap[$roleId] = [];
                }
                $this->rolePermissionMap[$roleId][] = $permissionId;
                
                $this->dispatch('permission-toggled', [
                    'action' => 'granted',
                    'role' => $role->name,
                    'permission' => $permission->name,
                ]);
            }

            // Clear Spatie permission cache
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        } catch (\Exception $e) {
            // Reload the map to ensure consistency
            $this->loadRolePermissionMap();
            session()->flash('error', 'Failed to toggle permission: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $roles = Role::query()
            ->when($this->searchRole, function ($query) {
                $query->where('name', 'like', '%' . $this->searchRole . '%');
            })
            ->orderBy('name')
            ->get();

        $permissions = Permission::query()
            ->when($this->searchPermission, function ($query) {
                $query->where('name', 'like', '%' . $this->searchPermission . '%');
            })
            ->orderBy('name')
            ->get();

        return view('livewire.admin.rbac.role-permission-matrix', [
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }
}
