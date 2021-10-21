<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{

    protected $fillable = [
        'uri', 'sorting', 'active', 'price', 'opt_price', 'gift'
    ];

    // public function langs()
    // {
    //     return $this->hasMany(RestaurantsLangs::class, 'restaurants_id');
    // }

    public function languages()
    {
        return $this->morphMany(Language::class, 'owner');
    }

    public function gallery()
    {
        return $this->belongsTo(Galleries::class, 'gallery_id')->with(['langs', 'items']);
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'cities_id')->with('languages');
    }

    public function image()
    {
        return $this->belongsTo(Images::class,'images_id');
    }

    public function types()
    {
        return $this->belongsToMany(RestaurantType::class, 'restaurants_restaurants_types', 'restaurants_id', 'restaurants_types_id')->with('languages');
    }

    public function menu()
    {
        return $this->belongsTo( Galleries::class, 'menu_id')->with(['langs','items']);
    }

    public function halls()
    {
        return $this->hasMany(Hall::class, 'restaurant_id')->with(['languages', 'gallery']);
    }

    public function kitchens()
    {
        return $this->belongsToMany(Kitchen::class, 'restaurants_kitchens', 'restaurant_id', 'kitchen_id')->with('languages');
    }

    public function schedule()
    {
        return $this->hasMany(RestaurantsSchedules::class, 'restaurants_id');
    }

    public function staff()
    {
        return $this->hasMany(Staff::class, 'restaurant_id');
    }
}
