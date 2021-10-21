<?php

namespace App\Http\Controllers;

use App\City;
use App\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class SitemapController extends Controller
{
    public function index(){
        $restaurants = Restaurant::with(['languages','city'])->orderBy('updated_at', 'desc')->get();
        $cities = City::orderBy('updated_at', 'desc')->get();

        $data['restaurants'] = $restaurants;
        $data['cities'] = $cities;

        $content = view('sitemap.index', $data)->render();

        File::put(public_path().'/sitemap.xml', $content);

        return Response::make($content, 200)->header('Content-Type', 'application/xml');
    }
}
