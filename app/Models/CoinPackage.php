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

    public static function boot()
    {
        parent::boot();

        // Menambahkan global scope untuk mengurutkan data berdasarkan `display_order`
        static::addGlobalScope('order', function ($query) {
            $query->orderBy('display_order');
        });

        // Menetapkan `display_order` saat membuat entri baru jika nilainya null
        static::creating(function ($model) {
            if (is_null($model->display_order)) {
                $maxOrder = self::max('display_order');
                $model->display_order = $maxOrder ? $maxOrder + 1 : 1;
            }
        });

        // Mengurangi `display_order` dari semua entri setelah entri yang dihapus
        static::deleting(function ($model) {
            if ($model->topUps()->exists()) {
                throw new \Exception("Tidak dapat menghapus paket koin yang memiliki riwayat pembelian.");
            }
            
            // Fungsionalitas dari gambar: mengurangi `display_order` dari entri lain
            self::where('display_order', '>', $model->display_order)
                ->decrement('display_order');
        });
    }
}
