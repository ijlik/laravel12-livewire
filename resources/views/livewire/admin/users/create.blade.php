<div>
    <div class="main-content app-content">
        <div class="container-fluid page-container main-body-container">

            <!-- Page Header -->
            <div class="page-header-breadcrumb mb-3">
                <div class="d-flex align-center justify-content-between flex-wrap gap-1">
                    <h1 class="page-title fw-medium fs-18 mb-0">Create User</h1>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-8">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Create New User</div>
                        </div>
                        <div class="card-body">
                            <form wire:submit="save">
                                <div class="row gy-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" wire:model="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Enter phone number">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                        <select wire:model="role" class="form-select @error('role') is-invalid @enderror" id="role">
                                            @foreach($roles as $r)
                                                <option value="{{ $r->name }}">{{ ucfirst($r->name) }}</option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Enter password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                        <input type="password" wire:model="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm password">
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input type="checkbox" wire:model="email_verified" class="form-check-input" id="email_verified">
                                            <label class="form-check-label" for="email_verified">Mark email as verified</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="save">Create User</span>
                                        <span wire:loading wire:target="save">Creating...</span>
                                    </button>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-light">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
