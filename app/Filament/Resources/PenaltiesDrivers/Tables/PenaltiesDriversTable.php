<?php

namespace App\Filament\Resources\PenaltiesDrivers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PenaltiesDriversTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('driver_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('penalty_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('dateIssued')
                    ->date()
                    ->sortable(),
                IconColumn::make('isPaid')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
