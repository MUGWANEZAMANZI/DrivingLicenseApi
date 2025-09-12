<?php

namespace App\Filament\Resources\PenaltiesDrivers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PenaltiesDriversForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('driver_id')
                    ->required()
                    ->numeric(),
                TextInput::make('penalty_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('dateIssued')
                    ->required(),
                Toggle::make('isPaid')
                    ->required(),
            ]);
    }
}
