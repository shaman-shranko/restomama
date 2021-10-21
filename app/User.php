<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles() {
        return $this->belongsToMany(Role::class)->with(['languages']);
    }

    public function hasVerifiedPhone() {
        return isset($this->phone_verified_at);
    }

    public function orders() {
        return $this->hasMany(Orders::class, 'user_id');
    }

    public function workedAt() {
        return $this->belongsToMany(Restaurant::class, 'staff', 'user_id', 'restaurant_id');
    }

    public function positions() {
        return $this->hasMany(Staff::class, 'user_id')->with('role');
    }

    public function is_restaurant_administrator($restaurant) {
        foreach ($this->positions()->get() as $position) {
            if ($position->restaurant_id == $restaurant->id && $position->role->alias == 'restaurant_administrator') {
                return true;
            }
        }
        return false;
    }

    public function is_restaurant_manager($restaurant) {
        foreach ($this->positions()->get() as $position) {
            if ($position->restaurant_id == $restaurant->id && $position->role->alias == 'restaurant_manager') {
                return true;
            }
        }
        return false;
    }

    public function is_restaurant_owner($restaurant) {
        foreach ($this->positions()->get() as $position) {
            if ($position->restaurant_id == $restaurant->id && $position->role->alias == 'restaurant') {
                return true;
            }
        }
        return false;
    }

    public function notifications() {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function message_rooms() {
        return $this->belongsToMany(MessageRoom::class, 'user_message_room');
    }

    public function messages() {
        return $this->hasMany(Message::class, 'user_id');
    }

    public function transactions() {
        return $this->hasMany(Transaction::class, 'initiator_id');
    }
    public function avatar() {
        return $this->belongsTo(Images::class, 'image_id');
    }
}
