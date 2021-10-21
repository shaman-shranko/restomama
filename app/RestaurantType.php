<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantType extends Model
{
    protected $fillable = [
        'uri', 'sorting', 'active'
    ];

    public function languages()
    {
        return $this->morphMany(Language::class, 'owner');
    }

    public function restaurants(){
        return $this->belongsToMany(Restaurant::class, 'restaurants_restaurants_types', 'restaurants_types_id');
    }

}
