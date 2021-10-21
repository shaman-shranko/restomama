<?php

namespace App\Http\Controllers\RestaurantManagement;

use App\Http\Controllers\Notifications\SMSNotification;
use App\Orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show list of orders
     * @param $restaurant_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($restaurant_id)
    {
        $orders = Orders::where('restaurant_id', '=', $restaurant_id)->with(['restaurant'])->orderBy('created_at', 'desc')->get();

        $orders_langs = array();
        foreach($orders as $order){
            foreach($order->restaurant->languages as $lang){
                $orders_langs[$order->id][$lang->language]['restaurant'] = $lang->name;
            }
        }

        $data['orders'] = $orders;
        $data['orders_langs'] = $orders_langs;

        return view('account.orders.restaurant_index', $data);
    }

    public function show($restaurant_id, $order_id){
        $order = Orders::with(['user', 'restaurant'])->findOrFail($order_id);

//        dd($order);

        $order_data['date']            = $order->date;
        $order_data['time']            = $order->time;
        foreach($order->restaurant->languages as $lang){
            if($lang->language == app()->getLocale()){
                $order_data['restaurant']      = $lang->namespace;
            }
        }
        $order_data['hall']            = false;

        $order_data['deposit']         = $order->deposit;
        $order_data['service_deposit'] = $order->service_deposit;
        $order_data['status']          = $order->status;
        $order_data['customer']        = $order->user->surname.' '.$order->user->name;
        $order_data['phone']           = $order->user->phone;
        $order_data['email']           = $order->user->email;
        $order_data['status']          = __('order.'.$order->status);
        $order_data['guests']          = $order->guests;

        // if(isset($order->event)){
        //     foreach ($order->event->langs as $lang){
        //         if($lang->lang == app()->getLocale()){
        //             $order_data['event'] = $lang->name;
        //         }
        //     }
        // }else{
        //     $order_data['event'] = 'Не указано';
        // }

//        dd($order_data);

        $links['back']            = route('restaurant.orders', ['restaurant_id' => $restaurant_id]);
        if($order->status == 'new'){
            $links['accept']      = route('restaurant.orders.accept', ['order_id' => $order_id]);
            $links['reject']      = route('restaurant.orders.reject', ['order_id' => $order_id]);
            $links['edit']        = route('restaurant.orders.edit', ['restaurant_id' => $restaurant_id, 'order_id' => $order_id]);
        }

        return view('account.orders.restaurant_show', compact(['links', 'order_data']));
    }

    public function edit($restaurant_id, $order_id)
    {
        $order = Orders::with(['user', 'restaurant'])->findOrFail($order_id);

//        dd($order);

        $order_data['date']            = $order->date;
        $order_data['time']            = $order->time;
        foreach($order->restaurant->languages as $lang){
            if($lang->language == app()->getLocale()){
                $order_data['restaurant']      = $lang->name;
            }
        }
        $order_data['hall']            = false;

        $order_data['deposit']         = $order->deposit;
        $order_data['service_deposit'] = $order->service_deposit;
        $order_data['status']          = $order->status;
        $order_data['customer']        = $order->user->surname.' '.$order->user->name;
        $order_data['phone']           = $order->user->phone;
        $order_data['email']           = $order->user->email;
        $order_data['status']          = __('order.'.$order->status);
        $order_data['guests']          = $order->guests;

//         if(isset($order->event)){
//             foreach ($order->event->langs as $lang){
//                 if($lang->lang == app()->getLocale()){
//                     $order_data['event'] = $lang->name;
//                 }
//             }
//         }else{
//             $order_data['event'] = 'Не указано';
//         }

// //        dd($order_data);

        $links['back']            = route('restaurant.orders', ['restaurant_id' => $restaurant_id]);
        $links['update']          = route('restaurant.orders.update', ['restaurant_id' => $restaurant_id, 'order_id' => $order_id]);

        return view('account.orders.restaurant_form', compact(['links', 'order_data']));
    }

    public function accept($order_id){
        $order = Orders::findOrFail($order_id);
        $order->status = 'confirmed';
        $order->save();
        /**
         * @TODO Enable after new settings
         */
        // SMSNotification::order_accept($order_id);

        return redirect()->route('restaurant.orders', ['restaurant_id' => $order->restaurant_id]);
    }

    public function reject($order_id){
        $order = Orders::findOrFail($order_id);
        $order->status = 'not_confirmed';
        $order->save();
        /**
         * @TODO Enable after new settings
         */
        // SMSNotification::order_reject($order_id);

        return redirect()->route('restaurant.orders', ['restaurant_id' => $order->restaurant_id]);
    }

}
