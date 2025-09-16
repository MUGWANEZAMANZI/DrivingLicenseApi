<?php

namespace App\Livewire\Licenses;

use App\Models\Driver;
use App\Models\License;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public License $license;

    public function mount(): void
    {
        $this->license = new License();
    }

    protected function rules(): array
    {
        return [
            'license.driverId' => ['required','exists:drivers,id'],
            'license.licenseNumber' => ['required','string','max:100','unique:licenses,licenseNumber'],
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
        session()->flash('status', __('Created.'));
        $this->redirectRoute('licenses.index');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $drivers = Driver::orderBy('name')->get(['id','name','surName']);
        return view('livewire.licenses.create', compact('drivers'));
    }
}


