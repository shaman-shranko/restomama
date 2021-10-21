@extends('layouts.account')

@section('seo')
    <title>@lang('cabinet.orders.show.lookup')</title>
@endsection

@section('main')
    <div class="card">
        <div class="card-content">
            <div class="right center-align">
                <a href="{{ route('my-orders.index') }}"><i class="material-icons">backspace</i></a>
            </div>
            <h1 class="flow-text">
                {{ $order_langs[app()->getLocale()]['restaurant'] }}. {{ $order->date }}
            </h1>

            <h2 class="flow-text">@lang('cabinet.orders.show.details'):</h2>
            <table>
                <tbody>
                    <tr>
                        <td>@lang('cabinet.orders.show.restaurant'):</td>
                        <td>
                            <a href="{{ route('restaurant-page', ['city_uri' => $order->restaurant->city->uri, 'restaurant_uri' => $order->restaurant->uri]) }}" target="_blank">
                                {{ $order_langs[app()->getLocale()]['restaurant'] }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>@lang('cabinet.orders.show.date_time'):</td>
                        <td>
                            {{ $order->date }} @if(isset($order->time)) {{ $order->time }} @else --:-- @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            @lang('cabinet.orders.show.deposit'):
                        </td>
                        <td>
                            ₴{{ $order->deposit }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            @lang('cabinet.orders.show.service_deposit'):
                        </td>
                        <td>
                            ₴{{ $order->service_deposit }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            @lang('cabinet.orders.show.status'):
                        </td>
                        <td>
                            @lang('order.'.$order->status)
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="right-align">
                @if($order->status == "new")
                    <a href="#" class="btn">@lang('cabinet.orders.show.cancel')</a>
                @elseif($order->status)
{{--                    <a href="#" class="btn">Отмена</a>--}}
{{--                    <a href="#" class="btn">Оплатить</a>--}}
                @else

                @endif


                <a href="#" class="btn">@lang('cabinet.orders.show.cancel')</a>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        tr td:first-child{
            font-weight: bold;
        }
    </style>
@endsection
