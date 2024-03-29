<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'text',
        'is_send'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
