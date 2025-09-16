<?php

namespace App\Livewire\Drivers;

use App\Models\Driver;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public Driver $driver;

    protected function rules(): array
    {
        return [
            'driver.name' => ['required','string','max:255'],
            'driver.surName' => ['required','string','max:255'],
            'driver.phone' => ['nullable','string','max:50'],
            'driver.email' => ['nullable','email','max:255', Rule::unique('drivers','email')->ignore($this->driver->id)],
            'driver.address' => ['nullable','string','max:255'],
            'driver.bloodGroup' => ['nullable','string','max:10'],
            'driver.nationalId' => ['nullable','string','max:100'],
            'driver.profileImage' => ['nullable','string','max:255'],
        ];
    }

    public function save(): void
    {
        $this->validate();
        $this->driver->save();
        session()->flash('status', __('Saved.'));
        $this->redirectRoute('drivers.index');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.drivers.edit');
    }
}


