<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantTypesLangs extends Model
{
    protected $fillable = [
        'lang',
        'heading',
        'seo_title',
        'seo_description',
        'seo_text'
    ];

    public function types(){
        return $this->belongsTo(RestaurantType::class);
    }
}
