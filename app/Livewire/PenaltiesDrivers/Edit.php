<?php

namespace App\Livewire\PenaltiesDrivers;

use App\Models\Driver;
use App\Models\PenaltiesDrivers;
use App\Models\Penalty;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public PenaltiesDrivers $item;

    protected function rules(): array
    {
        return [
            'item.driver_id' => ['required','exists:drivers,id'],
            'item.penalty_id' => ['required','exists:penalties,id'],
            'item.amount' => ['required','numeric','min:0'],
            'item.dateIssued' => ['nullable','date'],
            'item.isPaid' => ['boolean'],
        ];
    }

    public function save(): void
    {
        $this->validate();
        $this->item->save();
        session()->flash('status', __('Saved.'));
        $this->redirectRoute('penaltiesDrivers.index');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $drivers = Driver::orderBy('name')->get(['id','name','surName']);
        $penalties = Penalty::orderBy('penaltyType')->get(['id','penaltyType']);
        return view('livewire.penalties-drivers.edit', compact('drivers','penalties'));
    }
}


