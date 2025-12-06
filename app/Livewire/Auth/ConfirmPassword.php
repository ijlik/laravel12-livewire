<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Confirm Password')]
class ConfirmPassword extends Component
{
    public string $password = '';

    protected function rules(): array
    {
        return [
            'password' => ['required', 'string'],
        ];
    }

    public function confirm()
    {
        $this->validate();

        if (!Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session()->put('auth.password_confirmed_at', time());

        return redirect()->intended('/home');
    }

    public function render()
    {
        return view('livewire.auth.confirm-password');
    }
}
