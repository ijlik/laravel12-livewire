<div>
    <div class="main-content app-content">
        <div class="container-fluid page-container main-body-container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">{{ __('Verify Your Email Address') }}</div>
                        </div>
                        <div class="card-body">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            {{ __('Before proceeding, please check your email for a verification link.') }}
                            {{ __('If you did not receive the email') }},
                            <button type="button" wire:click="resendVerification" class="btn btn-link p-0 m-0 align-baseline" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="resendVerification">{{ __('click here to request another') }}</span>
                                <span wire:loading wire:target="resendVerification">Sending...</span>
                            </button>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
