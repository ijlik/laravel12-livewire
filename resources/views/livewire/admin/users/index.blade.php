<div>
    <div class="main-content app-content">
        <div class="container-fluid page-container main-body-container">

            <!-- Page Header -->
            <div class="page-header-breadcrumb mb-3">
                <div class="d-flex align-center justify-content-between flex-wrap gap-1">
                    <h1 class="page-title fw-medium fs-18 mb-0">Users Management</h1>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                    </ol>
                </div>
            </div>

            <!-- Flash Messages -->
            @if(session('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">All Users</div>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                        <i class="ri-add-line me-1"></i> Add User
                    </a>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search by name or email...">
                        </div>
                        <div class="col-md-3">
                            <select wire:model.live="roleFilter" class="form-select">
                                <option value="">All Roles</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select wire:model.live="perPage" class="form-select">
                                <option value="10">10 per page</option>
                                <option value="25">25 per page</option>
                                <option value="50">50 per page</option>
                                <option value="100">100 per page</option>
                            </select>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table text-nowrap table-hover">
                            <thead>
                                <tr>
                                    <th class="cursor-pointer" wire:click="sortBy('id')">
                                        # 
                                        @if($sortField === 'id')
                                            <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                                        @endif
                                    </th>
                                    <th class="cursor-pointer" wire:click="sortBy('name')">
                                        Name
                                        @if($sortField === 'name')
                                            <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                                        @endif
                                    </th>
                                    <th class="cursor-pointer" wire:click="sortBy('email')">
                                        Email
                                        @if($sortField === 'email')
                                            <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                                        @endif
                                    </th>
                                    <th>Role</th>
                                    <th>Email Verified</th>
                                    <th class="cursor-pointer" wire:click="sortBy('created_at')">
                                        Created At
                                        @if($sortField === 'created_at')
                                            <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-s-line"></i>
                                        @endif
                                    </th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="avatar avatar-sm avatar-rounded bg-primary-transparent">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </span>
                                                <span>{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach($user->roles as $role)
                                                <span class="badge bg-{{ $role->name === 'admin' ? 'primary' : 'secondary' }}-transparent">
                                                    {{ ucfirst($role->name) }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($user->email_verified_at)
                                                <span class="badge bg-success-transparent">Verified</span>
                                            @else
                                                <span class="badge bg-warning-transparent">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary-light">
                                                    <i class="ri-pencil-line"></i>
                                                </a>
                                                @if($user->id !== auth()->id())
                                                    <button type="button" 
                                                            wire:click="deleteUser({{ $user->id }})" 
                                                            wire:confirm="Are you sure you want to delete this user?"
                                                            class="btn btn-sm btn-danger-light">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">No users found</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
