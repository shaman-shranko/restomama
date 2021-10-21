<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantsSchedules extends Model
{
    protected $fillable = [
        'date',
        'status',
        'restaurants_id'
    ];

    public function restaurant(){
        return $this->belongsTo(Restaurant::class, 'restaurants_id');
    }
}
