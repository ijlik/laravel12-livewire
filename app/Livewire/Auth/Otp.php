<?php

namespace App\Livewire\Auth;

use App\Models\Otp as OtpModel;
use App\Models\User;
use App\Traits\OtpService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.auth')]
#[Title('Kode OTP')]
class Otp extends Component
{
    use OtpService;

    public string $email = '';
    public string $otp = '';

    public function mount()
    {
        $this->email = session('otp_email', '');
        
        if (empty($this->email)) {
            return redirect()->route('login');
        }
    }

    protected function rules(): array
    {
        return [
            'otp' => ['required', 'string', 'min:4'],
        ];
    }

    public function verifyOtp()
    {
        $this->validate();

        $result = $this->verify('email', $this->email, $this->otp);

        if (!$result['status']) {
            $this->addError('otp', $result['message'] ?? 'Invalid OTP');
            return;
        }

        $otpRecord = OtpModel::find($result['data']);
        
        if (!$otpRecord) {
            $this->addError('otp', 'OTP not found');
            return;
        }

        $user = User::where('email', $otpRecord->data)->first();

        if ($user) {
            Auth::login($user);
            $otpRecord->delete();
            session()->forget('otp_email');
            return redirect()->intended('/home');
        }

        $this->addError('otp', 'Account not found');
    }

    public function resendOtp()
    {
        $this->resend('email', $this->email);
        session()->flash('message', 'OTP has been resent to your email');
    }

    public function render()
    {
        return view('livewire.auth.otp');
    }
}
