<?php

namespace App\Filament\Resources\CoinPackages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;

class CoinPackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                TextInput::make('coin_amount')
                    ->label('Jumlah Koin')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('bonus_amount')
                    ->label('Bonus Koin')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('price')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->required()
                    ->label('Harga (Rp)'),
                Toggle::make('is_active')
                    ->required()
                    ->label('Aktif')
                    ->default(true),
            ]);
    }
}
