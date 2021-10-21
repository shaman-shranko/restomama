@extends('layouts.account')
@section('seo')
    <title>@lang('cabinet.orders.index.page_title')</title>
@endsection
@section('main')
    <div class="card">
        <div class="card-content">
            <h1 class="flow-text">@lang('cabinet.orders.index.title')</h1>
            @if($orders->count() > 0)
                <table class="responsive-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('cabinet.orders.index.restaurant')</th>
                        <th>@lang('cabinet.orders.index.date_time')</th>
                        <th>@lang('cabinet.orders.index.status')</th>
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
                                <a href="{{ route('my-orders.show', ['id' => $order->id]) }}"><i class="material-icons">create</i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            @else
                @lang('cabinet.orders.index.empty')
            @endif
        </div>
    </div>
@endsection
