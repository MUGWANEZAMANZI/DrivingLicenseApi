<?php

namespace App\Livewire\PenaltiesDrivers;

use App\Models\PenaltiesDrivers;
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
        $items = PenaltiesDrivers::query()
            ->with(['penalty'])
            ->when($this->search, function ($q) {
                $q->where('amount', 'like', "%{$this->search}%");
            })
            ->latest('id')
            ->paginate(10);

        return view('livewire.penalties-drivers.index', [
            'items' => $items,
        ]);
    }
}


