<?php

namespace App\Filament\Resources\Penalties\Pages;

use App\Filament\Resources\Penalties\PenaltyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPenalties extends ListRecords
{
    protected static string $resource = PenaltyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
