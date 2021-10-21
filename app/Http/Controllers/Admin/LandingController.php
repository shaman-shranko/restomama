<?php

namespace App\Http\Controllers\Admin;

use App\Landing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandingController extends Controller
{
    public function index()
    {
        $items = Landing::with([
            'langs',
            'restaurant',
            'restaurant.langs'
        ])->get();

        return view('admin.landings.index', [
            'items' => $items
        ]);
    }

    public function create()
    {
        return view('admin.landings.create', [
            'item' => new Landing()
        ]);
    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
