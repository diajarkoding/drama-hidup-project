<?php

namespace App\Filament\Resources\CoinPackages\Pages;

use App\Filament\Resources\CoinPackages\CoinPackageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCoinPackage extends CreateRecord
{
    protected static string $resource = CoinPackageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Harga koin berhasil ditambahkan';
    }
}
