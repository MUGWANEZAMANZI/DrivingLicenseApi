<?php

namespace App\Filament\Resources\PenaltiesDrivers\Pages;

use App\Filament\Resources\PenaltiesDrivers\PenaltiesDriversResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPenaltiesDrivers extends ListRecords
{
    protected static string $resource = PenaltiesDriversResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
