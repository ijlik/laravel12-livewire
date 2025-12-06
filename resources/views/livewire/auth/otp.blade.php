<div>
    <div class="row authentication authentication-cover-main mx-0">
        <div class="col-xxl-9 col-xl-9">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-6 col-sm-8 col-12">
                    <div class="card custom-card border-0 shadow-none my-4">
                        <div class="card-body p-5">
                            <div class="d-flex align-items-center mb-3">
                                <a href="{{ route('login') }}" class="btn btn-sm btn-icon btn-light me-2">
                                    <i class="ri-arrow-left-line"></i>
                                </a>
                                <div>
                                    <h4 class="mb-0 fw-semibold">Enter OTP Code</h4>
                                    <p class="mb-0 text-muted fw-normal fs-12">
                                        OTP has been sent to your email
                                    </p>
                                </div>
                            </div>
                            
                            @if(session('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif

                            <form wire:submit="verifyOtp">
                                <div class="row gy-3">
                                    <div class="col-xl-12">
                                        <label for="otp" class="form-label text-default">OTP Code</label>
                                        <input type="text" wire:model="otp" class="form-control @error('otp') is-invalid @enderror" id="otp" placeholder="Enter 6-digit OTP" autofocus maxlength="6">
                                        @error('otp')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-grid mt-3">
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="verifyOtp">Verify OTP</span>
                                        <span wire:loading wire:target="verifyOtp">Verifying...</span>
                                    </button>
                                </div>
                            </form>
                            <div class="text-center mt-3">
                                <button type="button" wire:click="resendOtp" class="btn btn-link" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="resendOtp">Resend OTP</span>
                                    <span wire:loading wire:target="resendOtp">Sending...</span>
                                </button>
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
