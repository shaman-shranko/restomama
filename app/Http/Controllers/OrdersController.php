<?php

namespace App\Http\Controllers;

use App\Events;
use App\Http\Controllers\Notifications\SMSNotification;
use App\Orders;
use App\Restaurant;
use Illuminate\Http\Request;
use App\City;

class OrdersController extends Controller
{
    public function create(Request $request, $city_uri, $restaurant_uri)
    {
        $request->validate(array(
            'date' => 'required|date',
            'location' => 'required'
        ));

        $restaurant = Restaurant::where('uri', '=', $restaurant_uri)->with(['languages', 'halls', 'schedule'])->first();
        // $events = Events::with('langs')->get();

        $order_data = array();
        $order_data['restaurant'] = $restaurant->id;
        $order_data['location'] = $request->location;
        $order_data['date'] = $request->date;

        session(['order_data' => $order_data]);

        //notification admins

        // $event_langs = array();
        // foreach($events as $event){
        //     foreach ($event->langs as $lang){
        //         $event_langs[$event->id][$lang->lang]['name'] = $lang->name;
        //     }
        // }


        $data['order_data'] = $order_data;
        $data['restaurant'] = $restaurant;
        // $data['events']     = $events;
        // $data['event_langs'] = $event_langs;

        return view('public.order', $data);
    }

    public function continue($city_uri, $restaurant_uri)
    {
        $order_data = session('order_data');
        if (isset($order_data)) {
            $restaurant = Restaurant::with(['languages', 'halls', 'schedule'])->findOrFail($order_data['restaurant']);
            // $events = Events::with('langs')->get();

            // $event_langs = array();
            // foreach($events as $event){
            //     foreach ($event->langs as $lang){
            //         $event_langs[$event->id][$lang->lang]['name'] = $lang->name;
            //     }
            // }

            $data['order_data'] = $order_data;
            $data['restaurant'] = $restaurant;
            // $data['events']     = $events;
            // $data['event_langs'] = $event_langs;

            return view('public.order', $data);
        } else {
            return view('public.errors.something_wrong');
        }
    }

    public function store(Request $request, $restaurant)
    {
        $request->validate(array(
            'location' => 'string|required',
            'quantity' => 'integer|required',
            'phone' => 'string|required',
            'email' => 'email|required',
            'date' => 'date|required',
            'time' => 'string|nullable',
            // 'event'    => 'integer|nullable',
            'all_location' => 'string|nullable',
        ));

        $restaurant_data = Restaurant::findOrFail($restaurant);

        $order = new Orders();
        $order->user_id = auth()->user()->id;
        $order->restaurant_id = $restaurant;
        $order->hall_id = isset($request->location) && $request->location != "restaurant" ? $request->location : null;
        $order->order_all_location = isset($request->all_location) && $request->all_location == "on" ? true : false;
        // $order->event_type          = isset($request->event) ? $request->event : null;
        $order->date = $request->date;
        $order->time = isset($request->time) ? $request->time : null;
        $order->guests = $request->quantity;
        $order->deposit = $restaurant_data->price * $request->quantity;
        $order->service_deposit = ($restaurant_data->price * $request->quantity) * 0.2;

        $order->phone = $request->phone;
        $order->email = $request->email;

        $order->status = "new";

        $order->save();
        $id = $order->id;
        //@TODO('send notification');
        // SMSNotification::order_create();


        $created = Orders::with(['restaurant'])->findOrFail($order->id);
//        $orders_langs = array();
//
//        foreach ($created->restaurant->languages as $lang) {
//            $orders_langs[$lang->language]['restaurant'] = $lang->name;
//        }
        $data['order'] = $created;
//        print_r($order->restaurant->languages);exit;
//        $data['orders_langs'] = $orders_langs;
        return view('public.thanks_for_order', $data);
    }

    public function cancel($order_id)
    {
        $order = Orders::findOrFail($order_id);

    }
}
