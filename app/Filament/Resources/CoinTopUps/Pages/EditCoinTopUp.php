<?php

namespace App\Filament\Resources\CoinTopUps\Pages;

use App\Filament\Resources\CoinTopUps\CoinTopUpResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCoinTopUp extends EditRecord
{
    protected static string $resource = CoinTopUpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
