<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table="languages";

    protected $fillable=[
        'id',
        'owner_id',
        'owner_type',
        'language',
        'name',
        'title',
        'description',
        'seo_title',
        'seo_description',
        'seo_text',
        'address',
        'gift_text',
        'schedule',
        'discount'
    ];

    public function owner()
    {
        return $this->morphTo();
    }
}
