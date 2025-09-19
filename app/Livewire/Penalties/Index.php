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
        // Show penalties via PenaltiesDrivers, eager load driver and license
        $penaltiesDrivers = \App\Models\PenaltiesDrivers::with(['driver.license', 'penalty'])
            ->latest('id')
            ->paginate(10);

        return view('livewire.penalties.index', [
            'penaltiesDrivers' => $penaltiesDrivers,
            'search' => $this->search,
        ]);
    }
}


