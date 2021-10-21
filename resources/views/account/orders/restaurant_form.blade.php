@extends('layouts.account')

@section('seo')
    <title>@lang('management.admin_order.form.page_title')</title>
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
            <hr/>
            <div class="row">
                <div class="col s12">
                    <h3 class="flow-text">@lang('management.admin_order.form.info')</h3>
                    <div class="row">
                        <div class="col s12">
                            {{ $order_data['customer'] }}
                        </div>
                        <div class="col s12">
                            {{ $order_data['phone'] }}
                        </div>
                        <div class="col s12">
                            {{ $order_data['email'] }}
                        </div>
                    </div>
                    <h3 class="flow-text">@lang('management.admin_order.form.edit')</h3>
                    <form method="post" class="row" action="{{ $links['update'] }}">
                        @method('PUT')
                        <div class="col s12 input-field">
                            hall
                        </div>
                        <div class="col s12 input-field">
                            event
                        </div>
                        <div class="col s12 input-field">
                            <input type="text" value="{{ $order_data['date'] }}" id="date" class="datepicker" name="date">
                            <label for="date" class="active">@lang('management.admin_order.form.date'):</label>
                        </div>
                        <div class="col s12 input-field">
                            <input type="text" value="{{ $order_data['time'] }}" class="timepicker" name="time" id="time" required>
                            <label for="time" class="active">@lang('management.admin_order.form.time'):</label>
                        </div>
                        <div class="col s12 input-field">
                            <input type="number" value="{{ $order_data['guests'] }}" name="guests" id="guests" required/>
                            <label for="guests" class="active">@lang('management.admin_order.form.count'):</label>
                        </div>
                        <div class="col s12 input-field">
                            <input type="number" value="{{ $order_data['deposit'] }}" name="deposit" id="deposit" required/>
                            <label for="deposit" class="active">@lang('management.admin_order.form.deposit'):</label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('.datepicker').datepicker();
            $('.timepicker').timepicker({
                twelveHour: false,
            });
        });
    </script>
@endsection
