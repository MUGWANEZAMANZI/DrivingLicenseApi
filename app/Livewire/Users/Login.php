<?php

namespace App\Livewire\Users;

use Livewire\Component;


use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;
    public string $error = '';

    public function login(): void
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->remember)) {
            session()->regenerate();
            $this->redirect(route('dashboard'));
        } else {
            $this->error = 'Invalid credentials.';
        }
    }

    public function render()
    {
        return view('auth.login');
    }
}
