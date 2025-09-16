<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public User $user;
    public string $password = '';

    public function mount(): void
    {
        $this->user = new User();
    }

    protected function rules(): array
    {
        return [
            'user.name' => ['required','string','max:255'],
            'user.email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:6'],
        ];
    }

    public function save(): void
    {
        $this->validate();
        $this->user->password = Hash::make($this->password);
        $this->user->save();
        session()->flash('status', __('Created.'));
        $this->redirectRoute('users.index');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.users.create');
    }
}


