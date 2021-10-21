<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Landing extends Model
{
    protected $table = 'landings';

    protected $fillable = [
        'sorting',
        'is_active'
    ];

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'landing_restaurant');
    }

    public function langs()
    {
        return $this->morphMany(Language::class, 'owner');
    }
}
