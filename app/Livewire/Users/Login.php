<?php

namespace App\Livewire\Users;

use Livewire\Component;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;


    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    protected function messages(): array
    {
        return [
            'email.required' => __('login.email_required'),
            'email.email' => __('login.email_invalid'),
            'password.required' => __('login.password_required'),
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function login(): void
    {

        Log::info('Attempting login for email: ' . $this->email);
        $validated = $this->validate();
        Log::info('Validation passed for email: ' . $this->email);

        if (Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->remember)) {
            session()->regenerate();

            Log::info('User session regenerated for email: ' . $this->email);
            $this->redirect(route('dashboard'));

            Log::info('User logged in successfully: ' . $this->email);
        } else {
            $this->addError('email', __('login.invalid_credentials'));
            Log::info('User login failed for email: ' . $this->email);
        }

        Log::info('Login attempt finished for email: ' . $this->email);
    }

    public function render()
    {
        return view('auth.login');
    }
}
