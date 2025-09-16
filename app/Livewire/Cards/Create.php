<?php

namespace App\Livewire\Cards;

use App\Models\Card;
use App\Models\License;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public Card $card;

    public function mount(): void
    {
        $this->card = new Card();
    }

    protected function rules(): array
    {
        return [
            'card.license_id' => ['required','exists:licenses,id'],
            'card.cardNumber' => ['required','string','max:32','unique:cards,cardNumber'],
            'card.secret' => ['nullable','string','max:255'],
            'card.programmedDate' => ['nullable','date'],
        ];
    }

    public function save(): void
    {
        $this->validate();
        $this->card->save();
        session()->flash('status', __('Created.'));
        $this->redirectRoute('cards.index');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $licenses = License::with('driver')->orderBy('id','desc')->get();
        return view('livewire.cards.create', compact('licenses'));
    }
}


