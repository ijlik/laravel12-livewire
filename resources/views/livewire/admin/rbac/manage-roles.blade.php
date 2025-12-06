<div>
    <div class="main-content app-content">
        <div class="container-fluid page-container main-body-container">

            <!-- Start::page-header -->
            <div class="page-header-breadcrumb mb-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h1 class="page-title fw-medium fs-18 mb-0">Role Management</h1>
                        <ol class="breadcrumb mb-0 mt-1">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">RBAC</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Roles</li>
                        </ol>
                    </div>
                    <div class="btn-list">
                        <a href="{{ route('admin.rbac.permissions') }}" class="btn btn-outline-primary btn-wave">
                            <i class="ri-shield-keyhole-line me-1"></i> Permissions
                        </a>
                        <a href="{{ route('admin.rbac.matrix') }}" class="btn btn-outline-secondary btn-wave">
                            <i class="ri-table-line me-1"></i> Matrix
                        </a>
                    </div>
                </div>
            </div>
            <!-- End::page-header -->

    <div class="row">
        <!-- Create Role Form -->
        <div class="col-xl-4">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Create New Role</div>
                </div>
                <div class="card-body">
                    <form wire:submit="createRole">
                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   wire:model="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   placeholder="e.g. editor, moderator">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Use lowercase letters, 3-50 characters.</small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-wave" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="createRole">
                                <i class="ri-add-line me-1"></i> Create Role
                            </span>
                            <span wire:loading wire:target="createRole">
                                <i class="ri-loader-4-line me-1 animate-spin"></i> Creating...
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Roles List -->
        <div class="col-xl-8">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title">All Roles</div>
                    <div class="d-flex gap-2">
                        <input type="text" 
                               wire:model.live.debounce.300ms="search" 
                               class="form-control form-control-sm" 
                               placeholder="Search roles..."
                               style="width: 200px;">
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3 mb-0" role="alert">
                            <i class="ri-check-line me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show m-3 mb-0" role="alert">
                            <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col">Role Name</th>
                                    <th scope="col">Users</th>
                                    <th scope="col">Permissions</th>
                                    <th scope="col">Guard</th>
                                    <th scope="col">Created</th>
                                    <th scope="col" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                    <tr wire:key="role-{{ $role->id }}">
                                        <td>
                                            <span class="badge bg-primary-transparent">{{ $role->name }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $role->users_count }} users</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary-transparent">{{ $role->permissions_count }} permissions</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $role->guard_name }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">{{ $role->created_at->format('M d, Y') }}</span>
                                        </td>
                                        <td class="text-end">
                                            @if($role->name !== 'superadmin')
                                                <button type="button" 
                                                        wire:click="confirmDelete({{ $role->id }})"
                                                        class="btn btn-sm btn-danger-light btn-wave">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            @else
                                                <span class="badge bg-warning-transparent">Protected</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="ri-folder-open-line fs-2 d-block mb-2"></i>
                                                No roles found.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($roles->hasPages())
                    <div class="card-footer">
                        {{ $roles->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Confirm Delete</h6>
                        <button type="button" class="btn-close" wire:click="cancelDelete"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">
                            Are you sure you want to delete the role <strong class="text-danger">"{{ $deleteRoleName }}"</strong>?
                        </p>
                        <p class="text-muted mb-0 mt-2 fs-12">
                            <i class="ri-error-warning-line me-1"></i>
                            This will remove the role from all users and detach all permissions.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="cancelDelete">Cancel</button>
                        <button type="button" class="btn btn-danger" wire:click="deleteRole" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="deleteRole">Delete Role</span>
                            <span wire:loading wire:target="deleteRole">Deleting...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

        </div>
    </div>
</div>
