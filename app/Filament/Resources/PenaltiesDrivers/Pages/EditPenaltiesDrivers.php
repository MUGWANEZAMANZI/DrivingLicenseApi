<?php

namespace App\Filament\Resources\PenaltiesDrivers\Pages;

use App\Filament\Resources\PenaltiesDrivers\PenaltiesDriversResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPenaltiesDrivers extends EditRecord
{
    protected static string $resource = PenaltiesDriversResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
