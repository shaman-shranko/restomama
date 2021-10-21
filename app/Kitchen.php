<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen extends Model
{
    public function restaurant()
    {
        return $this->belongsToMany(Restaurant::class);
    }

    public function languages()
    {
        return $this->morphMany(Language::class, 'owner');
    }
}
