<?php

namespace App\Filament\Resources\Cards\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('license_id')
                    ->relationship('license', 'id')
                    ->required(),
                TextInput::make('cardNumber')
                    ->required(),
                TextInput::make('secret')
                    ->required(),
                DatePicker::make('programmedDate')
                    ->required(),
            ]);
    }
}
