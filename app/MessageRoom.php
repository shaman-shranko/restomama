<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageRoom extends Model
{
    protected $table = 'message_rooms';

    protected $fillable = [
        'user_id',
        'message_room_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_message_room');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'message_room_id');
    }
}
