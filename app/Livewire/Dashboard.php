<?php

namespace App\Livewire;

use App\Models\Card;
use App\Models\Driver;
use App\Models\License;
use App\Models\Penalty;
use App\Models\PenaltiesDrivers;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard', [
            'stats' => [
                'drivers' => Driver::count(),
                'licenses' => License::count(),
                'cards' => Card::count(),
                'penalties' => Penalty::count(),
                'penaltiesDrivers' => PenaltiesDrivers::count(),
                'users' => User::count(),
            ],
        ])->layout('layouts.app');
    }
}


