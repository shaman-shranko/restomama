<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'user_id',
        'message'
    ];

    public function message_room()
    {
        return $this->belongsTo(MessageRoom::class, 'message_room_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
