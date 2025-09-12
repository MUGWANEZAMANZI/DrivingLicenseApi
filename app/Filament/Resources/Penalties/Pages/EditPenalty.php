<?php

namespace App\Filament\Resources\Penalties\Pages;

use App\Filament\Resources\Penalties\PenaltyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPenalty extends EditRecord
{
    protected static string $resource = PenaltyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
