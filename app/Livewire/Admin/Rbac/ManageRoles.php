<?php

namespace App\Livewire\Admin\Rbac;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

#[Layout('layouts.app')]
#[Title('Role Management')]
class ManageRoles extends Component
{
    use WithPagination;

    public string $name = '';
    public string $search = '';
    public int $perPage = 10;
    
    public bool $showDeleteModal = false;
    public ?int $deleteRoleId = null;
    public string $deleteRoleName = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('roles', 'name'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Role name is required.',
            'name.min' => 'Role name must be at least 3 characters.',
            'name.max' => 'Role name must not exceed 50 characters.',
            'name.unique' => 'This role name already exists.',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function createRole(): void
    {
        $this->validate();

        try {
            Role::create(['name' => $this->name, 'guard_name' => 'web']);
            
            $this->reset('name');
            $this->dispatch('role-created');
            session()->flash('success', 'Role created successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create role: ' . $e->getMessage());
        }
    }

    public function confirmDelete(int $roleId): void
    {
        $role = Role::find($roleId);
        
        if ($role) {
            $this->deleteRoleId = $roleId;
            $this->deleteRoleName = $role->name;
            $this->showDeleteModal = true;
        }
    }

    public function cancelDelete(): void
    {
        $this->showDeleteModal = false;
        $this->deleteRoleId = null;
        $this->deleteRoleName = '';
    }

    public function deleteRole(): void
    {
        if (!$this->deleteRoleId) {
            return;
        }

        $role = Role::find($this->deleteRoleId);

        if (!$role) {
            session()->flash('error', 'Role not found.');
            $this->cancelDelete();
            return;
        }

        // Prevent deleting superadmin role
        if ($role->name === 'superadmin') {
            session()->flash('error', 'Cannot delete the superadmin role.');
            $this->cancelDelete();
            return;
        }

        try {
            DB::transaction(function () use ($role) {
                // Detach role from all users
                $role->users()->detach();
                
                // Revoke all permissions from role
                $role->syncPermissions([]);
                
                // Delete the role
                $role->delete();
            });

            session()->flash('success', "Role '{$this->deleteRoleName}' deleted successfully.");
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete role: ' . $e->getMessage());
        }

        $this->cancelDelete();
    }

    public function render()
    {
        $roles = Role::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->withCount(['users', 'permissions'])
            ->orderBy('name')
            ->paginate($this->perPage);

        return view('livewire.admin.rbac.manage-roles', [
            'roles' => $roles,
        ]);
    }
}
