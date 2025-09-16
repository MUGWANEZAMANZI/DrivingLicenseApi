<?php

namespace App\Livewire\Cards;

use App\Models\Card;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    #[Layout('layouts.app')]
    public function render()
    {
        $cards = Card::query()
            ->when($this->search, function ($q) {
                $q->where('cardNumber', 'like', "%{$this->search}%");
            })
            ->latest('id')
            ->with('license.driver')
            ->paginate(10);

        return view('livewire.cards.index', compact('cards'));
    }
}


