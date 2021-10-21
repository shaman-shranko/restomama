<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantsLangs extends Model
{
    protected $fillable = [
        'lang',
        'heading',
        'seo_title',
        'seo_description',
        'seo_text',
        'address',
        'gift_text',
        'schedule'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
