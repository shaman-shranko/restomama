@extends('layouts.app')

@section('content')
    <div class="container container-info">
        <div class="row" style="flex-wrap: wrap">
            <div class="col s12">
                <h4 class="text-center">@lang('client.thanks.thanks')</h4>
            </div>
            <div class="col s12">
                <h6>@lang('client.thanks.your_order')</h6>
            </div>
            <div class="col s12">
                <table class="responsive-table">
                    <tr>
                        <td>#</td>
                        <td>@lang('client.thanks.restaurant')</td>
                        <td>@lang('client.thanks.date_time')</td>
                        <td>@lang('client.thanks.deposit')</td>
                        <td>@lang('client.thanks.service_deposit')</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="{{ route('my-orders.show', ['id' => $order->id]) }}">
                                {{$order->id}}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('restaurant-page', ['city_uri' => $order->restaurant->city->uri, 'restaurant_uri' => $order->restaurant->uri]) }}"
                               target="_blank">
                                @foreach($order->restaurant->languages as $lang)
                                    @if($lang->language==app()->getLocale())
                                        {{ $lang->name }}
                                    @endif
                                @endforeach
                            </a>
                        </td>
                        <td>{{ $order->date }} @if(isset($order->time)) {{ $order->time }} @else --:-- @endif</td>
                        <td>₴{{$order->deposit}}</td>
                        <td>₴{{$order->service_deposit}}</td>
                    </tr>
                </table>
            </div>
            <div class="col s12">
                <h6>@lang('client.thanks.managers_will_connect')</h6>
            </div>
        </div>
    </div>
@endsection
