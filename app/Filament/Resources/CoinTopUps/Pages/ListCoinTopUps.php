<?php

namespace App\Filament\Resources\CoinTopUps\Pages;

use App\Filament\Resources\CoinTopUps\CoinTopUpResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCoinTopUps extends ListRecords
{
    protected static string $resource = CoinTopUpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Top Up Koin'),
        ];
    }
}
