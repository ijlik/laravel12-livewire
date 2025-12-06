<?php

namespace App\Livewire\Admin\Rbac;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

#[Layout('layouts.app')]
#[Title('Permission Management')]
class ManagePermissions extends Component
{
    use WithPagination;

    public string $name = '';
    public string $search = '';
    public int $perPage = 10;
    
    public bool $showDeleteModal = false;
    public ?int $deletePermissionId = null;
    public string $deletePermissionName = '';

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
                'max:100',
                Rule::unique('permissions', 'name'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Permission name is required.',
            'name.min' => 'Permission name must be at least 3 characters.',
            'name.max' => 'Permission name must not exceed 100 characters.',
            'name.unique' => 'This permission name already exists.',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function createPermission(): void
    {
        $this->validate();

        try {
            Permission::create(['name' => $this->name, 'guard_name' => 'web']);
            
            $this->reset('name');
            $this->dispatch('permission-created');
            session()->flash('success', 'Permission created successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create permission: ' . $e->getMessage());
        }
    }

    public function confirmDelete(int $permissionId): void
    {
        $permission = Permission::find($permissionId);
        
        if ($permission) {
            $this->deletePermissionId = $permissionId;
            $this->deletePermissionName = $permission->name;
            $this->showDeleteModal = true;
        }
    }

    public function cancelDelete(): void
    {
        $this->showDeleteModal = false;
        $this->deletePermissionId = null;
        $this->deletePermissionName = '';
    }

    public function deletePermission(): void
    {
        if (!$this->deletePermissionId) {
            return;
        }

        $permission = Permission::find($this->deletePermissionId);

        if (!$permission) {
            session()->flash('error', 'Permission not found.');
            $this->cancelDelete();
            return;
        }

        try {
            DB::transaction(function () use ($permission) {
                // Detach permission from all roles
                $permission->roles()->detach();
                
                // Detach permission from all users (direct permissions)
                $permission->users()->detach();
                
                // Delete the permission
                $permission->delete();
            });

            session()->flash('success', "Permission '{$this->deletePermissionName}' deleted successfully.");
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete permission: ' . $e->getMessage());
        }

        $this->cancelDelete();
    }

    public function render()
    {
        $permissions = Permission::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->withCount('roles')
            ->orderBy('name')
            ->paginate($this->perPage);

        return view('livewire.admin.rbac.manage-permissions', [
            'permissions' => $permissions,
        ]);
    }
}
