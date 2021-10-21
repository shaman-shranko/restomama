<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HallsSchedules extends Model
{
    protected $fillable = [
        'date',
        'status',
        'edited_by',
        'halls_id'
    ];

    public function halls()
    {
        return $this->belongsTo(Hall::class, 'halls_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
}
