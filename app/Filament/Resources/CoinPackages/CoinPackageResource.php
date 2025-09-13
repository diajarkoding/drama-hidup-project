<?php

namespace App\Filament\Resources\CoinPackages;

use App\Filament\Resources\CoinPackages\Pages\CreateCoinPackage;
use App\Filament\Resources\CoinPackages\Pages\EditCoinPackage;
use App\Filament\Resources\CoinPackages\Pages\ListCoinPackages;
use App\Filament\Resources\CoinPackages\Schemas\CoinPackageForm;
use App\Filament\Resources\CoinPackages\Tables\CoinPackagesTable;
use App\Models\CoinPackage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CoinPackageResource extends Resource
{
    protected static ?string $model = CoinPackage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCircleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Koin';

    protected static ?string $navigationLabel = 'Harga Koin';

    protected static ?string $pluralModelLabel = 'Harga Koin';

    public static function form(Schema $schema): Schema
    {
        return CoinPackageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CoinPackagesTable::configure($table);
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
            'index' => ListCoinPackages::route('/'),
            'create' => CreateCoinPackage::route('/create'),
            'edit' => EditCoinPackage::route('/{record}/edit'),
        ];
    }
}
