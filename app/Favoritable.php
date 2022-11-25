<?php

namespace App;

use App\Models\Favorite;

trait Favoritable
{
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => \Auth::user()->id];
        if (!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', \Auth::user()?->id)->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
