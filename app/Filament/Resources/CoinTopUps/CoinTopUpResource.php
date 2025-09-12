<?php

namespace App\Filament\Resources\CoinTopUps;

use App\Filament\Resources\CoinTopUps\Pages\CreateCoinTopUp;
use App\Filament\Resources\CoinTopUps\Pages\EditCoinTopUp;
use App\Filament\Resources\CoinTopUps\Pages\ListCoinTopUps;
use App\Filament\Resources\CoinTopUps\Schemas\CoinTopUpForm;
use App\Filament\Resources\CoinTopUps\Tables\CoinTopUpsTable;
use App\Models\CoinTopUp;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class CoinTopUpResource extends Resource
{
    protected static ?string $model = CoinTopUp::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Koin';
    protected static ?string $navigationLabel = 'Top Up Koin';
    protected static ?string $pluralModelLabel = 'Top Up Koin';

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return CoinTopUpForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CoinTopUpsTable::configure($table);
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
            'index' => ListCoinTopUps::route('/'),
            'create' => CreateCoinTopUp::route('/create'),
            'edit' => EditCoinTopUp::route('/{record}/edit'),
        ];
    }
}
