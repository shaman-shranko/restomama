<?php

namespace App\Http\Controllers\Account;

use App\Orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = auth()->user()->orders()->with(['restaurant'])->get();

        $orders_langs = array();

        foreach ($orders as $order){
            foreach ($order->restaurant->languages as $lang){
                $orders_langs[$order->id][$lang->language]['restaurant'] = $lang->name;
            }
        }

        $data['orders'] = $orders;
        $data['orders_langs'] = $orders_langs;

        return view('account.orders.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //don`t need it
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = auth()->user()->orders()->with(['restaurant'])->findOrFail($id);

        $order_langs = array();

        foreach($order->restaurant->languages as $lang){
            $order_langs[$lang->language]['restaurant'] = $lang->name;
        }
        // if(isset($order->event)){
        //     foreach ($order->event->langs as $lang){
        //         $order_langs[$lang->lang]['event'] = $lang->name;
        //     }
        // }

        $data['order'] = $order;
        $data['order_langs'] = $order_langs;

        return view('account.orders.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
