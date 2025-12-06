<div>
    <div class="main-content app-content">
        <div class="container-fluid page-container main-body-container">

            <!-- Start::page-header -->
            <div class="page-header-breadcrumb mb-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h1 class="page-title fw-medium fs-18 mb-0">Permission Management</h1>
                        <ol class="breadcrumb mb-0 mt-1">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">RBAC</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                        </ol>
                    </div>
                    <div class="btn-list">
                        <a href="{{ route('admin.rbac.roles') }}" class="btn btn-outline-primary btn-wave">
                            <i class="ri-user-settings-line me-1"></i> Roles
                        </a>
                        <a href="{{ route('admin.rbac.matrix') }}" class="btn btn-outline-secondary btn-wave">
                            <i class="ri-table-line me-1"></i> Matrix
                        </a>
                    </div>
                </div>
            </div>
            <!-- End::page-header -->

    <div class="row">
        <!-- Create Permission Form -->
        <div class="col-xl-4">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Create New Permission</div>
                </div>
                <div class="card-body">
                    <form wire:submit="createPermission">
                        <div class="mb-3">
                            <label for="name" class="form-label">Permission Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   wire:model="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   placeholder="e.g. create-posts, edit-users">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Use lowercase with hyphens, e.g. "create-posts".</small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-wave" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="createPermission">
                                <i class="ri-add-line me-1"></i> Create Permission
                            </span>
                            <span wire:loading wire:target="createPermission">
                                <i class="ri-loader-4-line me-1 animate-spin"></i> Creating...
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Info Card -->
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Permission Naming Convention</div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <span class="badge bg-primary-transparent me-2">view-users</span>
                            <small class="text-muted">View user list</small>
                        </li>
                        <li class="mb-2">
                            <span class="badge bg-success-transparent me-2">create-users</span>
                            <small class="text-muted">Create new users</small>
                        </li>
                        <li class="mb-2">
                            <span class="badge bg-warning-transparent me-2">edit-users</span>
                            <small class="text-muted">Edit existing users</small>
                        </li>
                        <li>
                            <span class="badge bg-danger-transparent me-2">delete-users</span>
                            <small class="text-muted">Delete users</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Permissions List -->
        <div class="col-xl-8">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title">All Permissions</div>
                    <div class="d-flex gap-2">
                        <input type="text" 
                               wire:model.live.debounce.300ms="search" 
                               class="form-control form-control-sm" 
                               placeholder="Search permissions..."
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
                                    <th scope="col">Permission Name</th>
                                    <th scope="col">Assigned to Roles</th>
                                    <th scope="col">Guard</th>
                                    <th scope="col">Created</th>
                                    <th scope="col" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($permissions as $permission)
                                    <tr wire:key="permission-{{ $permission->id }}">
                                        <td>
                                            <span class="badge bg-secondary-transparent">{{ $permission->name }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $permission->roles_count }} roles</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $permission->guard_name }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">{{ $permission->created_at->format('M d, Y') }}</span>
                                        </td>
                                        <td class="text-end">
                                            <button type="button" 
                                                    wire:click="confirmDelete({{ $permission->id }})"
                                                    class="btn btn-sm btn-danger-light btn-wave">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="ri-folder-open-line fs-2 d-block mb-2"></i>
                                                No permissions found.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($permissions->hasPages())
                    <div class="card-footer">
                        {{ $permissions->links() }}
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
                            Are you sure you want to delete the permission <strong class="text-danger">"{{ $deletePermissionName }}"</strong>?
                        </p>
                        <p class="text-muted mb-0 mt-2 fs-12">
                            <i class="ri-error-warning-line me-1"></i>
                            This will remove the permission from all roles.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="cancelDelete">Cancel</button>
                        <button type="button" class="btn btn-danger" wire:click="deletePermission" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="deletePermission">Delete Permission</span>
                            <span wire:loading wire:target="deletePermission">Deleting...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

        </div>
    </div>
</div>
