<?php

namespace App\Filament\Resources\CoinPackages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class CoinPackagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Nama'),
                TextColumn::make('coin_amount')->label('Jumlah Koin'),
                TextColumn::make('bonus_amount')->label('Bonus Koin'),
                TextColumn::make('price')
                ->formatStateUsing(fn (string $state): string => 'Rp ' . number_format($state, 0, ',', '.'))
                ->label('Harga'),
                ToggleColumn::make('is_active')->label('Aktif'),
                TextColumn::make('display_order')->label('Urutan'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                ->successNotificationTitle('Paket koin berhasil dihapus'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])->reorderable('display_order');
    }
}
