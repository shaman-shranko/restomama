<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class Dashboard extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['user_orders'] = auth()->user()->orders()->with(['restaurant'])->orderBy('id', 'desc')->limit(3)->get();
        return view('account.dashboard', $data);
    }


}
