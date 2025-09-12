<?php

namespace App\Filament\Resources\Licenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LicenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('driverId')
                    ->required()
                    ->numeric(),
                TextInput::make('licenseNumber')
                    ->required(),
                DatePicker::make('issueDate')
                    ->required(),
                DatePicker::make('expiryDate')
                    ->required(),
                TextInput::make('plateNumber')
                    ->required(),
                TextInput::make('dateLieuDelivrance'),
                TextInput::make('allowedCategories'),
            ]);
    }
}
