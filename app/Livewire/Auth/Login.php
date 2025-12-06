<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Traits\OtpService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.auth')]
#[Title('Login')]
class Login extends Component
{
    use OtpService;

    public string $email = '';
    public string $password = '';

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function sendOtp()
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        // Check if credentials are valid
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        // Logout and send OTP
        Auth::logout();
        $this->resend('email', $this->email);
        
        session()->put('otp_email', $this->email);
        
        return redirect()->route('login.otp');
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return strtolower($this->email) . '|' . request()->ip();
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
