<?php

namespace App\Livewire\Drivers;

use App\Models\Driver;
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
        $drivers = Driver::query()
            ->when($this->search, function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('surName', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->latest('id')
            ->paginate(10);

        return view('livewire.drivers.index', compact('drivers'));
    }
}


