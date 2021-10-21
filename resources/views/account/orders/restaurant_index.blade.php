@extends('layouts.account')
@section('seo')
    <title>@lang('management.admin_order.index.page_title')</title>
@endsection
@section('main')
    <div class="card">
        <div class="card-content">
            <h1 class="flow-text">@lang('management.admin_order.index.title')</h1>
            @if($orders->count() > 0)
                <table class="responsive-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('management.admin_order.index.restaurant')</th>
                        <th>@lang('management.admin_order.index.date_time')</th>
                        <th>@lang('management.admin_order.index.status')</th>
                        <th></th>
                    </tr>

                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $orders_langs[$order->id][app()->getLocale()]['restaurant'] }}</td>
                            <td>{{ $order->date }} {{ $order->time }}</td>
                            <td>@lang('order.'.$order->status)</td>
                            <td>
                                <a href="{{ route('restaurant.orders.show', ['restaurant_id' => $order->restaurant_id, 'order_id' => $order->id]) }}"><i class="material-icons">remove_red_eye</i></a>
                                <a href="{{ route('restaurant.orders.edit', ['restaurant_id' => $order->restaurant_id, 'order_id' => $order->id]) }}"><i class="material-icons">create</i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            @else
                @lang('management.admin_order.index.empty')
            @endif
        </div>
    </div>
@endsection
