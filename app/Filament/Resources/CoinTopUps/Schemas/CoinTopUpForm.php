<?php

namespace App\Filament\Resources\CoinTopUps\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use App\Models\User;

class CoinTopUpForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                ->default('TOPUP-' . Str::random(10))
                ->readOnly(),

                // lebih baik pakai relationship => otomatis lazy & searchable
                Select::make('user_id')
                    ->label('User')
                    ->searchable()
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('coin_package_id')
                    ->label('Paket Koin')
                    ->searchable()
                    ->relationship('package', 'title')
                    ->required(),

                Select::make('status')
                ->label('Status')
                ->options([
                    'pending' => 'Pending',
                    'success' => 'Success',
                    'failed' => 'Failed',
                ])
                ->required(),
            ]);
    }
}

