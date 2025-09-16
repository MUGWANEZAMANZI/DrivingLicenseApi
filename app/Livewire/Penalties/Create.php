<?php

namespace App\Livewire\Penalties;

use App\Models\Penalty;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public Penalty $penalty;

    public function mount(): void
    {
        $this->penalty = new Penalty();
    }

    protected function rules(): array
    {
        return [
            'penalty.penaltyType' => ['required','string','max:255'],
            'penalty.amount' => ['required','numeric','min:0'],
        ];
    }

    public function save(): void
    {
        $this->validate();
        $this->penalty->save();
        session()->flash('status', __('Created.'));
        $this->redirectRoute('penalties.index');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.penalties.create');
    }
}


