<div>
    <div class="row authentication authentication-cover-main mx-0">
        <div class="col-xxl-9 col-xl-9">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-6 col-sm-8 col-12">
                    <div class="card custom-card border-0 shadow-none my-4">
                        <div class="card-body p-5">
                            <div>
                                <h4 class="mb-1 fw-semibold">Create Account</h4>
                                <p class="mb-4 text-muted fw-normal">Please fill in your details to register</p>
                            </div>
                            <form wire:submit="register">
                                <div class="row gy-3">
                                    <div class="col-xl-12">
                                        <label for="name" class="form-label text-default">Name</label>
                                        <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter Name" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-xl-12">
                                        <label for="email" class="form-label text-default">Email</label>
                                        <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter Email">
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-xl-12">
                                        <label for="password" class="form-label text-default">Password</label>
                                        <div class="position-relative">
                                            <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Enter Password">
                                            <a href="javascript:void(0);" class="show-password-button text-muted" onclick="createpassword('password',this)"><i class="ri-eye-off-line align-middle"></i></a>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-xl-12">
                                        <label for="password_confirmation" class="form-label text-default">Confirm Password</label>
                                        <div class="position-relative">
                                            <input type="password" wire:model="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm Password">
                                            <a href="javascript:void(0);" class="show-password-button text-muted" onclick="createpassword('password_confirmation',this)"><i class="ri-eye-off-line align-middle"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="register">Register</span>
                                        <span wire:loading wire:target="register">Creating account...</span>
                                    </button>
                                </div>
                            </form>
                            <div class="text-center mt-3 fw-medium">
                                Already have an account? <a href="{{ route('login') }}" class="text-primary">Login Here</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-12 d-xl-block d-none px-0">
            <div class="authentication-cover overflow-hidden">
                <div class="authentication-cover-logo">
                    <a href="/">
                        <img src="/assets/images/brand-logos/toggle-logo.png" alt="logo" class="desktop-dark">
                    </a>
                </div>
                <div class="authentication-cover-background">
                    <img src="/assets/images/media/backgrounds/9.png" alt="">
                </div>
                <div class="authentication-cover-content">
                    <div class="p-5">
                        <h3 class="fw-semibold lh-base">Welcome to Dashboard</h3>
                        <p class="mb-0 text-muted fw-medium">Join us and manage your content with ease.</p>
                    </div>
                    <div>
                        <img src="/assets/images/media/media-72.png" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
