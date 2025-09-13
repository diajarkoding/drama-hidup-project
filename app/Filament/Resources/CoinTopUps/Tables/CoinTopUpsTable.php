<?php

namespace App\Filament\Resources\CoinTopUps\Tables;

use App\Models\CoinPackage;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CoinTopUpsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User'),
                TextColumn::make('package.title')
                    ->label('Paket Koin'),
                TextColumn::make('coin_amount')
                    ->label('Jumlah Koin'),
                TextColumn::make('amount')
                    ->formatStateUsing(fn (string $state): string => 'Rp '.number_format($state, 0, ',', '.'))
                    ->label('Total Harga'),
                TextColumn::make('status')
                    ->badge()
                    ->label('Status'),
                TextColumn::make('created_at')
                    ->label('Tanggal Top Up')
                    ->dateTime('d-m-Y H:i:s')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label('User')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable(),
                SelectFilter::make('coin_package_id')
                    ->label('Paket Koin')
                    ->options(CoinPackage::all()->pluck('title', 'id'))
                    ->searchable(),
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
