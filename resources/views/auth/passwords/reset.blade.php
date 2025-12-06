@extends('layouts.auth')

@section('title') 
Reset Password 
@endsection

@section('content')
<div class="row authentication authentication-cover-main mx-0">
    <div class="col-xxl-9 col-xl-9">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-6 col-sm-8 col-12">
                <div class="card custom-card border-0 shadow-none my-4">
                    <div class="card-body p-5">
                        <div>
                            <h4 class="mb-1 fw-semibold">Reset Password</h4>
                            <p class="mb-4 text-muted fw-normal">Untuk email : {{ $email ?? old('email') }}</p>
                        </div>
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="row gy-3">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
                            
                                <div class="col-xl-12">
                                    <label for="signin-password" class="form-label text-default d-block">Password</label>
                                    <div class="position-relative">
                                        <input type="password" name="password" class="form-control" id="signin-password" placeholder="Enter Password" value="">
                                        <a href="javascript:void(0);" class="show-password-button text-muted" onclick="createpassword('signin-password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-12 mb-2">
                                
                                    <label for="signin-password" class="form-label text-default d-block">Confirm Password</label>
                                    <div class="position-relative">
                                        <input type="password" name="password_confirmation" class="form-control" id="signin-password" placeholder="Enter Password" value="">
                                        <a href="javascript:void(0);" class="show-password-button text-muted" onclick="createpassword('signin-password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid mt-3">
                                <button type="submit" class="btn btn-primary">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-xl-3 col-lg-12 d-xl-block d-none px-0">
        <div class="authentication-cover overflow-hidden">
            <div class="authentication-cover-logo">
                <a href="index.html">
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
@endsection




