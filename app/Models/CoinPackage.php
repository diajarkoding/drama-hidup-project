<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinPackage extends Model
{
    protected $fillable = [
        'title',
        'coin_amount',
        'bonus_amount',
        'price',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function topUps () {
        return $this->hasMany(CoinTopUp:: class) ;
    }
}
