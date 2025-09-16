<?php

namespace App\Livewire\Licenses;

use App\Models\License;
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
        $licenses = License::query()
            ->when($this->search, function ($q) {
                $q->where('licenseNumber', 'like', "%{$this->search}%")
                  ->orWhere('plateNumber', 'like', "%{$this->search}%");
            })
            ->latest('id')
            ->with('driver')
            ->paginate(10);

        return view('livewire.licenses.index', compact('licenses'));
    }
}


