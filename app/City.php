<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    protected $fillable = [
        'uri',
        'sorting',
        'active'
    ];

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    public function languages()
    {
        return $this->morphMany(Language::class, 'owner');
    }
}
