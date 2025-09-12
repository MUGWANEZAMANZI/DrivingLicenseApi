<?php

namespace App\Filament\Resources\PenaltiesDrivers;

use App\Filament\Resources\PenaltiesDrivers\Pages\CreatePenaltiesDrivers;
use App\Filament\Resources\PenaltiesDrivers\Pages\EditPenaltiesDrivers;
use App\Filament\Resources\PenaltiesDrivers\Pages\ListPenaltiesDrivers;
use App\Filament\Resources\PenaltiesDrivers\Schemas\PenaltiesDriversForm;
use App\Filament\Resources\PenaltiesDrivers\Tables\PenaltiesDriversTable;
use App\Models\PenaltiesDrivers;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PenaltiesDriversResource extends Resource
{
    protected static ?string $model = PenaltiesDrivers::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'PenaltyDriver';

    public static function form(Schema $schema): Schema
    {
        return PenaltiesDriversForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PenaltiesDriversTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPenaltiesDrivers::route('/'),
            'create' => CreatePenaltiesDrivers::route('/create'),
            'edit' => EditPenaltiesDrivers::route('/{record}/edit'),
        ];
    }
}
