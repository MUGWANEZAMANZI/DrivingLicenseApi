<?php

namespace App\Filament\Resources\Licenses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LicensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('driverId')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('licenseNumber')
                    ->searchable(),
                TextColumn::make('issueDate')
                    ->date()
                    ->sortable(),
                TextColumn::make('expiryDate')
                    ->date()
                    ->sortable(),
                TextColumn::make('plateNumber')
                    ->searchable(),
                TextColumn::make('dateLieuDelivrance')
                    ->searchable(),
                TextColumn::make('allowedCategories')
                    ->searchable(),
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
