<div>
    <div class="row authentication authentication-cover-main mx-0">
        <div class="col-xxl-9 col-xl-9">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-6 col-sm-8 col-12">
                    <div class="card custom-card border-0 shadow-none my-4">
                        <div class="card-body p-5">
                            <div>
                                <h4 class="mb-1 fw-semibold">Reset Password</h4>
                                <p class="mb-4 text-muted fw-normal">Please enter your email</p>
                            </div>
                            
                            @if(session('status'))
                                <div class="alert alert-success">{{ session('status') }}</div>
                            @endif

                            <form wire:submit="sendResetLink">
                                <div class="row gy-3">
                                    <div class="col-xl-12">
                                        <label for="email" class="form-label text-default">Email</label>
                                        <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter Email">
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-grid mt-3">
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="sendResetLink">Send Password Reset Link</span>
                                        <span wire:loading wire:target="sendResetLink">Sending...</span>
                                    </button>
                                </div>
                            </form>
                            <div class="text-center mt-3 fw-medium">
                                Remember your password? <a href="{{ route('login') }}" class="text-primary">Login Here</a>
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
                        <p class="mb-0 text-muted fw-medium">Manage your website and content with ease using our powerful admin tools.</p>
                    </div>
                    <div>
                        <img src="/assets/images/media/media-72.png" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
