<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public User $user;
    public string $password = '';

    protected function rules(): array
    {
        return [
            'user.name' => ['required','string','max:255'],
            'user.email' => ['required','email','max:255', Rule::unique('users','email')->ignore($this->user->id)],
            'password' => ['nullable','string','min:6'],
        ];
    }

    public function save(): void
    {
        $this->validate();
        if (!empty($this->password)) {
            $this->user->password = Hash::make($this->password);
        }
        $this->user->save();
        session()->flash('status', __('Saved.'));
        $this->redirectRoute('users.index');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.users.edit');
    }
}


