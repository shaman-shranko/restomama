<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

class TransactionsController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $transactions = auth()->user()->transactions()->with(['initiator', 'order'])->get();
        $data['transactions'] = $transactions;
        return view('account.transactions.index', $data);
    }
}
