<?php

namespace App\Http\Controllers;

use App\Events;
// use App\EventsTypes;
use App\Restaurant;
use App\RestaurantsSchedules;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index($city_uri, $restaurant_uri){
        $restaurant = Restaurant::where('uri','=',$restaurant_uri)->with(['image','languages','gallery','menu','halls','kitchens','city','schedule'])->first();
        $data['restaurant'] = $restaurant;
        foreach($restaurant->languages as $lang){
            if($lang->language == app()->getLocale()){
                $data['seo_title'] = $lang->seo_title;
                $data['seo_description'] = $lang->seo_description;
            }
        }

        // $events = EventsTypes::where('active', '=', 'true')->with('languages')->get();
        // $event_langs = array();
        // foreach($events as $event){
        //     foreach($event->languages as $lang){
        //         $event_langs[$event->id][$lang->language]['name'] = $lang->name;
        //     }
        // }

        // $data['events'] = $events;
        // $data['event_langs'] = $event_langs;

        return view('public.product', $data);
    }
}
