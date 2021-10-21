<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model {
    protected $fillable = [
        'order_all_location',
        'event_type',
        'date',
        'time',
        'guests',
        'deposit',
        'service_deposit',
        'total',
        'phone',
        'email',
        'status',
        'cashback',
        'commission',
        'administrator_bonus',
        'partner_bonus',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function restaurant() {
        return $this->belongsTo(Restaurant::class, 'restaurant_id')->with('languages');
    }
    public function administrator() {
        return $this->belongsTo(User::class, 'administrator_id');
    }

    public function event() {
        // return $this->belongsTo(EventsTypes::class, 'event_type')->with('langs');
    }
}
