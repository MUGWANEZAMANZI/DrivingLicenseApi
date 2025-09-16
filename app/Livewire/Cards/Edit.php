<?php

namespace App\Livewire\Cards;

use App\Models\Card;
use App\Models\License;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public Card $card;

    protected function rules(): array
    {
        return [
            'card.license_id' => ['required','exists:licenses,id'],
            'card.cardNumber' => ['required','string','max:32', Rule::unique('cards','cardNumber')->ignore($this->card->id)],
            'card.secret' => ['nullable','string','max:255'],
            'card.programmedDate' => ['nullable','date'],
        ];
    }

    public function save(): void
    {
        $this->validate();
        $this->card->save();
        session()->flash('status', __('Saved.'));
        $this->redirectRoute('cards.index');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $licenses = License::with('driver')->orderBy('id','desc')->get();
        return view('livewire.cards.edit', compact('licenses'));
    }
}


