@extends('layouts.account')

@section('seo')
<title>@lang('management.admin_order.show.page_title')</title>
@endsection

@section('main')
<div class="card">
    <div class="card-content">
        <div class="right center-align">
            <a href="{{ $links['back'] }}"><i class="material-icons">backspace</i></a>
        </div>
        <h1 class="flow-text">
            {{ $order_data['customer'] }}. {{ $order_data['date'] }} {{ $order_data['time'] }}
        </h1>
        <hr />
        <div class="row">
            <div class="col m6 s12">
                <h3 class="flow-text">@lang('management.admin_order.show.details')</h3>
                <table class="responsive-table">
                    <tr>
                        <td>@lang('management.admin_order.show.hall'):</td>
                        <td>
                            @if(!$order_data['hall'])
                                @lang('management.admin_order.show.set')
                            @else
                                @lang('management.admin_order.show.not_set')
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>@lang('management.admin_order.show.date_time'):</td>
                        <td>{{ $order_data['date'] }} {{ $order_data['time'] }}</td>
                    </tr>
                    <tr>
                        <td>@lang('management.admin_order.show.count'):</td>
                        <td>{{ $order_data['guests'] }}</td>
                    </tr>
                    {{-- <tr>
                            <td>Тип мероприятия:</td>
                            <td>{{ $order_data['event'] }}</td>
                    </tr> --}}
                    <tr>
                        <td>@lang('management.admin_order.show.deposit'):</td>
                        <td>{{ $order_data['deposit'] }}</td>
                    </tr>
                    <tr>
                        <td>@lang('management.admin_order.show.service_deposit'):</td>
                        <td>{{ $order_data['service_deposit'] }}</td>
                    </tr>
                    <tr>
                        <td>@lang('management.admin_order.show.status')</td>
                        <td>{{ $order_data['status'] }}</td>
                    </tr>
                </table>

            </div>
            <div class="col m6 s12">
                <h3 class="flow-text">@lang('management.admin_order.show.client')</h3>
                <table class="responsive-table">
                    <tr>
                        <td>@lang('management.admin_order.show.name'):</td>
                        <td>{{ $order_data['customer'] }}</td>
                    </tr>
                    <tr>
                        <td>@lang('management.admin_order.show.phone'):</td>
                        <td>{{ $order_data['phone'] }}</td>
                    </tr>
                    <tr>
                        <td>E-mail</td>
                        <td>{{ $order_data['email'] }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <hr style="margin-top: 30px;" />
        <div class="row">
            <div class="col s12">
                @if(isset($links['edit']))
                <a href="{{ $links['edit'] }}" class="btn">@lang('management.admin_order.show.edit')</a>
                @endif
                @if(isset($links['accept']))
                <form style="display: inline-block" action="{{ $links['accept'] }}" method="post">
                    @csrf
                    @method('PUT')
                    <button class="btn" type="submit">@lang('management.admin_order.show.accept')</button>
                </form>
                @endif
                @if(isset($links['reject']))
                <form style="display: inline-block" action="{{ $links['reject'] }}" method="post">
                    @csrf
                    @method('PUT')
                    <button class="btn" type="submit">@lang('management.admin_order.show.decline')</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection