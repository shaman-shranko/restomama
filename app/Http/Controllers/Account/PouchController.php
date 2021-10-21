<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

class PouchController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('account.pouch.index');
    }

}
