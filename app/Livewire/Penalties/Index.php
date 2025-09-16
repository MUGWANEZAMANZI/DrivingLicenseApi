<?php

namespace App\Livewire\Penalties;

use App\Models\Penalty;
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
        $penalties = Penalty::query()
            ->when($this->search, function ($q) {
                $q->where('penaltyType', 'like', "%{$this->search}%");
            })
            ->latest('id')
            ->paginate(10);

        return view('livewire.penalties.index', compact('penalties'));
    }
}


