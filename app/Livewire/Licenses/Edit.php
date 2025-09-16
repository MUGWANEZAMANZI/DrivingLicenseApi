<?php

namespace App\Livewire\Licenses;

use App\Models\Driver;
use App\Models\License;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public License $license;

    protected function rules(): array
    {
        return [
            'license.driverId' => ['required','exists:drivers,id'],
            'license.licenseNumber' => ['required','string','max:100', Rule::unique('licenses','licenseNumber')->ignore($this->license->id)],
            'license.issueDate' => ['nullable','date'],
            'license.expiryDate' => ['nullable','date','after_or_equal:license.issueDate'],
            'license.plateNumber' => ['nullable','string','max:100'],
            'license.dateLieuDelivrance' => ['nullable','string','max:255'],
            'license.licensesAllowed' => ['nullable','string','max:255'],
            'license.allowedCategories' => ['nullable','string','max:255'],
        ];
    }

    public function save(): void
    {
        $this->validate();
        $this->license->save();
        session()->flash('status', __('Saved.'));
        $this->redirectRoute('licenses.index');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $drivers = Driver::orderBy('name')->get(['id','name','surName']);
        return view('livewire.licenses.edit', compact('drivers'));
    }
}


