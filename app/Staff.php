<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'restaurant_id', 'role_id', 'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }

    public static function getAdministrators($restaurant_id){
        $staffs = self::where('restaurant_id', '=', $restaurant_id)->with(['role', 'user'])->get();

        $administrators = array();

        foreach($staffs as $staff){
            if($staff->role->alias == 'restaurant_administrator'){
                $administrators[] = array(
                    'name'    => $staff->user->name,
                    'surname' => $staff->user->surname,
                    'phone'   => $staff->user->phone
                );
            }
        }

        return $administrators;
    }
}
