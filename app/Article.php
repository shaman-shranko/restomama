<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = [
        'uri',
        'isTopMenu',
        'isFooter_1',
        'isFooter_2',
        'isBlog',
        'status',
        'sorting'
    ];

    public function languages()
    {
        return $this->morphMany(Language::class, 'owner');
    }
}
