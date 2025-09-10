<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnlockedEpisode extends Model
{
    protected $fillable = [
        'user_id',
        'series_episode_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function episode()
    {
        return $this->belongsTo(SeriesEpisode::class, 'series_episode_id');
    }
}
