<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.auth')]
#[Title('Verify Email')]
class VerifyEmail extends Component
{
    public function resendVerification()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->intended('/home');
        }

        Auth::user()->sendEmailVerificationNotification();

        session()->flash('resent', true);
    }

    public function render()
    {
        return view('livewire.auth.verify-email');
    }
}
