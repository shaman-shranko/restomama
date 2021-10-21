<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LiqpayController extends Controller
{
    public static function create(){
        copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
    }
}
