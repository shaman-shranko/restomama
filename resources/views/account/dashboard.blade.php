@extends('layouts.account')
@section('seo')
    <title>@lang('cabinet.dashboard.page_title')</title>
@endsection
@section('main')
    <div class="container">
        <div class="row">
            <div class="col s12">
                @if(isset($user_orders))
                    <div class="col m6">
                        <div class="card">
                            <div class="card-content">
                                <h6>@lang('cabinet.dashboard.last_orders')</h6>
                                <table>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('cabinet.dashboard.title')</th>
                                        <th>@lang('cabinet.dashboard.date')</th>
                                        <th>@lang('cabinet.dashboard.status')</th>
                                    </tr>
                                    @if(!empty($user_orders))
                                        @foreach($user_orders as $order)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('my-orders.show', ['id' => $order->id]) }}">
                                                        {{$order->id}}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('restaurant-page', ['city_uri' => $order->restaurant->city->uri, 'restaurant_uri' => $order->restaurant->uri]) }}"
                                                       target="_blank">
                                                        @foreach($order->restaurant->languages as $language)
                                                            @if($language->language==app()->getLocale())
                                                                {{$language->name}}
                                                            @endif
                                                        @endforeach
                                                    </a>
                                                </td>
                                                <td>{{$order->date}}</td>
                                                <td>@lang('order.'.$order->status)</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @lang('cabinet.dashboard.empty')
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
                {{--                <div class="card">--}}
                {{--                    <div class="card-content">--}}
                {{--                        еще одна--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--                <div class="card">--}}
                {{--                    <div class="card-content">--}}
                {{--                        и еще одна--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>
        </div>
    </div>
@endsection
