<div>
    <div class="main-content app-content">
        <div class="container-fluid page-container main-body-container">

            <!-- Start::page-header -->
            <div class="page-header-breadcrumb mb-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h1 class="page-title fw-medium fs-18 mb-0">Role-Permission Matrix</h1>
                        <ol class="breadcrumb mb-0 mt-1">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">RBAC</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Matrix</li>
                        </ol>
                    </div>
                    <div class="btn-list">
                        <a href="{{ route('admin.rbac.roles') }}" class="btn btn-outline-primary btn-wave">
                            <i class="ri-user-settings-line me-1"></i> Roles
                        </a>
                        <a href="{{ route('admin.rbac.permissions') }}" class="btn btn-outline-secondary btn-wave">
                            <i class="ri-shield-keyhole-line me-1"></i> Permissions
                        </a>
                    </div>
                </div>
            </div>
            <!-- End::page-header -->

    <div class="row">
        <div class="col-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="card-title">Permission Assignment Matrix</div>
                    <div class="d-flex gap-2 flex-wrap">
                        <input type="text" 
                               wire:model.live.debounce.300ms="searchPermission" 
                               class="form-control form-control-sm" 
                               placeholder="Filter permissions..."
                               style="width: 180px;">
                        <input type="text" 
                               wire:model.live.debounce.300ms="searchRole" 
                               class="form-control form-control-sm" 
                               placeholder="Filter roles..."
                               style="width: 180px;">
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

                    @if($roles->isEmpty() || $permissions->isEmpty())
                        <div class="text-center py-5">
                            <div class="text-muted">
                                <i class="ri-information-line fs-2 d-block mb-2"></i>
                                @if($roles->isEmpty() && $permissions->isEmpty())
                                    No roles or permissions found. Please create some first.
                                @elseif($roles->isEmpty())
                                    No roles found. <a href="{{ route('admin.rbac.roles') }}">Create a role</a> first.
                                @else
                                    No permissions found. <a href="{{ route('admin.rbac.permissions') }}">Create a permission</a> first.
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="bg-light sticky-col" style="min-width: 200px;">
                                            <span class="fw-semibold">Permission</span>
                                        </th>
                                        @foreach($roles as $role)
                                            <th scope="col" class="text-center" style="min-width: 120px;">
                                                <span class="badge bg-primary-transparent">{{ $role->name }}</span>
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($permissions as $permission)
                                        <tr wire:key="permission-row-{{ $permission->id }}">
                                            <td class="bg-light sticky-col">
                                                <span class="badge bg-secondary-transparent">{{ $permission->name }}</span>
                                            </td>
                                            @foreach($roles as $role)
                                                <td class="text-center" wire:key="cell-{{ $role->id }}-{{ $permission->id }}">
                                                    <div class="form-check form-switch d-inline-block">
                                                        <input type="checkbox" 
                                                               class="form-check-input" 
                                                               role="switch"
                                                               wire:click="togglePermission({{ $role->id }}, {{ $permission->id }})"
                                                               wire:loading.attr="disabled"
                                                               wire:target="togglePermission({{ $role->id }}, {{ $permission->id }})"
                                                               @checked($this->hasPermission($role->id, $permission->id))
                                                               id="check-{{ $role->id }}-{{ $permission->id }}">
                                                        <span wire:loading wire:target="togglePermission({{ $role->id }}, {{ $permission->id }})" 
                                                              class="spinner-border spinner-border-sm text-primary" 
                                                              style="width: 12px; height: 12px;"></span>
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Legend -->
                        <div class="card-footer bg-light">
                            <div class="d-flex align-items-center gap-4 flex-wrap">
                                <span class="text-muted fs-12">
                                    <i class="ri-information-line me-1"></i>
                                    Click the toggle to grant or revoke a permission for a role.
                                </span>
                                <span class="text-muted fs-12">
                                    <strong>{{ $permissions->count() }}</strong> permissions × <strong>{{ $roles->count() }}</strong> roles
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .sticky-col {
            position: sticky;
            left: 0;
            z-index: 1;
        }
        .form-switch .form-check-input {
            cursor: pointer;
            width: 2.5em;
            height: 1.25em;
        }
        .form-switch .form-check-input:checked {
            background-color: #5c67f7;
            border-color: #5c67f7;
        }
    </style>

    @script
    <script>
        $wire.on('permission-toggled', (data) => {
            const event = data[0];
            const action = event.action === 'granted' ? 'granted to' : 'revoked from';
            const message = `Permission "${event.permission}" ${action} role "${event.role}"`;
            
            // You can use a toast notification here if available
            console.log(message);
        });
    </script>
    @endscript

        </div>
    </div>
</div>
