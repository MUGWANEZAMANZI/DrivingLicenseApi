<?php

namespace App\Filament\Resources\Penalties\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PenaltyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('penaltyType')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
            ]);
    }
}
