<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    protected $table = 'transactions';

    protected $fillable = [
        'owner_id',
        'owner_type',
        'type',
        'amount',
        'comment',
        'order_id',
        'initiator_id',
    ];

    public function initiator() {
        return $this->belongsTo(User::class, 'initiator_id');
    }
    
    public function order() {
        return $this->belongsTo(Orders::class, 'order_id');
    }
}
