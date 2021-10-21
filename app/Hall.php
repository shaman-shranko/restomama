<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Hall extends Model
{
    protected $table = 'halls';

    protected $fillable = [
        'sorting',
        'capacity',
        'active',
        'type'
    ];

    public function languages()
    {
        return $this->morphMany(Language::class, 'owner');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function gallery()
    {
        return $this->belongsTo(Galleries::class, 'gallery_id')->with(['langs', 'items']);
    }

    public function schedule()
    {
        return $this->hasMany( HallsSchedules::class, 'halls_id');
    }

}
