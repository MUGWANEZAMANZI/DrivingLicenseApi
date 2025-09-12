<?php

namespace App\Filament\Resources\Penalties;

use App\Filament\Resources\Penalties\Pages\CreatePenalty;
use App\Filament\Resources\Penalties\Pages\EditPenalty;
use App\Filament\Resources\Penalties\Pages\ListPenalties;
use App\Filament\Resources\Penalties\Schemas\PenaltyForm;
use App\Filament\Resources\Penalties\Tables\PenaltiesTable;
use App\Models\Penalty;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PenaltyResource extends Resource
{
    protected static ?string $model = Penalty::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PenaltyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PenaltiesTable::configure($table);
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
            'index' => ListPenalties::route('/'),
            'create' => CreatePenalty::route('/create'),
            'edit' => EditPenalty::route('/{record}/edit'),
        ];
    }
}
