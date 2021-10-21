<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KitchensLangs extends Model
{
    protected $fillable = [
        'name'
    ];

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }
}
