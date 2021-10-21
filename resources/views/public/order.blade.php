@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @auth
            <form class="col s12" method="post" action="{{ route('order.store', ['restaurant' => $restaurant->id]) }}">
                <h2 class="flow-text">
                    @foreach($restaurant->languages as $lang)
                        @if($lang->language == app()->getLocale())
                            {{ $lang->name }}. @lang('client.order.title')
                        @endif
                    @endforeach
                </h2>
                @csrf
                <div class="row">
                    <div class="col m6 s12">
                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col s12">
                                        <h3 class="flow-text">@lang('client.order.details')</h3>
                                    </div>
                                    <div class="col m6 s12">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <div class="load_hall load_restaurant">
                                                    <div id="dates_restaurant"></div>
                                                </div>
                                                @foreach($restaurant->halls as $hall)
                                                    <div class="load_hall load_hall_{{$hall->id}}" style="display: none">
                                                        <div id="dates_hall_{{$hall->id}}"></div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col m6 s12">
                                        <div class="row">
                                            <input type="hidden" name="date" value="{{ $order_data['date'] }}"/>
                                            <div class="input-field col s12">
                                                <select id="calendar_select" name="location">
                                                    <option value="restaurant" selected>@lang('client.order.whole_restaurant')</option>
                                                    @foreach($restaurant->halls as $hall)
                                                        @foreach($hall->languages as $lang)
                                                            @if($lang->language == app()->getLocale())
                                                                <option value="{{$hall->id}}">{{$lang->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                                <label for="calendar_select">@lang('client.order.location')</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <input type="text" class="timepicker" name="time" id="time">
                                                <label for="time">@lang('client.order.time')</label>
                                            </div>
                                            <p style="padding-left: 15px; padding-right: 15px;">
                                                <label>
                                                    <input type="checkbox" class="filled-in" name="all_location"/>
                                                    <span>@lang('client.order.get_location')</span>
                                                </label>
                                            </p>
                                            <div class="input-field col s12">
                                                <input type="number" name="quantity" id="quantity" value="1"/>
                                                <label for="quantity">@lang('client.order.quantity')</label>
                                            </div>
                                            {{-- <div class="input-field col s12">
                                                <select id="event" name="event">
                                                    <option value="" selected>Тип мероприятия</option>
                                                    @foreach($events as $event)
                                                        <option value="{{ $event->id }}"> {{$event_langs[$event->id][app()->getLocale()]['name']}} </option>
                                                    @endforeach
                                                </select>
                                            </div> --}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col m3">
                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col s12">
                                        <h3 class="flow-text">@lang('client.order.contacts')</h3>
                                    </div>
                                    <div class="input-field col s12">
                                        <label class="active">@lang('client.order.name')</label>
                                        <span class="fio">
                                    {{ auth()->user()->surname }} {{ auth()->user()->name }} {{ auth()->user()->secondname }}
                                </span>
                                    </div>
                                    <div class="input-field col s12">
                                        <input type="text" name="phone" id="phone" value="{{ auth()->user()->phone }}"/>
                                        <label for="phone">@lang('client.order.phone'):</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input type="email" name="email" id="email" value="{{ auth()->user()->email }}"/>
                                        <label for="email">Email:</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col m3">
                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col s12">
                                        <h3 class="flow-text">
                                            @lang('client.order.total')
                                        </h3>
                                    </div>
                                    <div class="input-field col s12">
                                        @lang('client.order.deposit') : <span class="price">₴<span class="total">{{ $restaurant->price }}</span></span>  <br/>
                                        @lang('client.order.service_deposit') : <span class="price">₴<span class="deposit">{{ $restaurant->price*0.2 }}</span></span>
                                    </div>
                                    <div class="col s12 center-align">
                                        <button type="submit" class="btn">@lang('client.order.book')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @else
            <div class="col s12 m8 offset-m2">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12">
                                <h1 class="flow-text">@lang('client.auth.login_to_continue')</h1>
                                @lang('client.auth.no_account') <a href="{{ route('register') }}">@lang('client.auth.registration')</a>.
                            </div>
                        </div>
                        <div class="row">
                            <form class="col s12" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input placeholder="" id="email" type="email" name="email" class="validate  @error('email') invalid @enderror" required autofocus>
                                        <label for="first_name">{{ __('E-Mail Address') }}</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input placeholder="" id="password" type="password" name="password" class="validate  @error('password') invalid @enderror" required autofocus>
                                        <label for="first_name">{{ __('Password') }}</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <p>
                                            <label>
                                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                                                <span>{{ __('Remember Me') }}</span>
                                            </label>
                                        </p>
                                    </div>
                                    <div class="input-field col s12">
                                        <button type="submit" class="waves-effect waves-light btn">
                                            {{ __('Login') }}
                                        </button>

                                        @if (Route::has('password.request'))
                                            <a class="waves-effect waves-light btn" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endauth
        </div>
    </div>
@endsection

@section('scripts')
    @auth
    <script
        src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
        crossorigin="anonymous" defer></script>
    @if(app()->getLocale() == 'ua')
        <script src="{{ asset('app/js/datepicker_ua.js') }}" defer></script>
    @else
        <script src="{{ asset('app/js/datepicker_ru.js') }}" defer></script>
    @endif
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            //init restaurant schedule
            let Event = function(text, className) {
                this.text = text;
                this.className = className;
            };

            let events = {};
            // Date must be with reset time to 00:00:00
            @foreach($restaurant->schedule as $schedule_row)
                @if($schedule_row->status == 1)
                events[new Date("{{$schedule_row->date}}T00:00:00")] = new Event("Частично занят", "day_partial");
            @elseif($schedule_row->status == 2)
                events[new Date("{{$schedule_row->date}}T00:00:00")] = new Event("Занят", "day_load");
            @endif
            @endforeach


            $("#dates_restaurant").datepicker({
                dateFormat: "yy-mm-dd",
                firstDay: 1,
                minDate: new Date(),
                beforeShowDay: function(date) {
                    let event = events[date];
                    if (event) {
                        return [true, event.className, event.text];
                    }
                    else {
                        return [true, '', ''];
                    }
                },
                onSelect: function (date) {
                    $('#date').val(date);
                }
            });

            // init halls calendars
            let events_halls = [];
            @foreach($restaurant->halls as $hall)
                events_halls[{{$hall->id}}] = {};


            @foreach($hall->schedule as $schedule_row)
                @if($schedule_row->status == 1)
                events_halls['{{$hall->id}}'][new Date("{{$schedule_row->date}}T00:00:00")] = new Event("Частично занят", "day_partial");
            @elseif($schedule_row->status > 1)
                events_halls['{{$hall->id}}'][new Date("{{$schedule_row->date}}T00:00:00")] = new Event("Занят", "day_load");
            @endif
            @endforeach

            $("#dates_hall_{{$hall->id}}").datepicker({
                dateFormat: "yy-mm-dd",
                firstDay: 1,
                minDate: new Date(),
                beforeShowDay: function(date) {
                    let event = events_halls['{{$hall->id}}'][date];
                    if (event) {
                        return [true, event.className, event.text];
                    }
                    else {
                        return [true, '', ''];
                    }
                },
                onSelect: function (date) {
                    $('#date').val(date);
                }
            });
            @endforeach

            //init select options
            $('#calendar_select').change(function(){
                let $that = $(this);
                let $val = $that.val();
                $('.load_hall').hide();
                if($val === 'restaurant'){
                    $('.load_restaurant').show();
                    $("#dates_restaurant").datepicker("setDate", $('#date').val());
                }else{
                    $('.load_hall_'+$val).show();
                    $("#dates_hall_"+$val).datepicker("setDate", $('#date').val());
                }
            });

            let date_now = new Date();

            let dd = date_now.getDate();
            if(dd < 10) dd = "0" + dd;
            let mm = date_now.getMonth() + 1;
            if(mm < 10) mm = "0" + mm;
            let yy = date_now.getFullYear();

            date_now = yy + "-" + mm + "-" + dd;

            $('#date').val(date_now);

            $('.timepicker').timepicker({
                twelveHour: false
            });

            $('input[name="quantity"]').on('keyup', function(){
                let that = $(this);
                let val = that.val();
                if(val !== ""){
                    val = Math.floor(val);
                    if(val < 1){
                        val = 1;
                    }
                }

                that.val(val);

                if(val === "") val = 1;

                $('span.total').text(Math.floor(val*{{$restaurant->price}}));
                $('span.deposit').text(Math.floor(val*0.2*{{$restaurant->price}}));
            });

            $('input[name="quantity"]').on('change', function(){
                let that = $(this);
                let val = Math.floor(that.val());
                if(val < 1) val = 1;
                that.val(val);

                $('span.total').text(Math.floor(val*{{$restaurant->price}}));
                $('span.deposit').text(Math.floor(val*0.2*{{$restaurant->price}}));
            });

            $('#order_form').on('submit', function(event){
                event.preventDefault();

                let that = $(this);
                let date = that.find('#date').val();
                let location = $('#calendar_select').val();
                let all_ok = true;
                let message = '';


                if(location === "restaurant"){
                    if(events[new Date(date+"T00:00:00")] !== undefined && events[new Date(date+"T00:00:00")].text === "Занят"){
                        all_ok = false;
                        message = "Ресторан занят на эту дату";
                    }
                }else{
                    let event = events_halls[location][new Date(date+"T00:00:00")];
                    if(event !== undefined && event.text === "Занят"){
                        all_ok = false;
                        message = "Этот зал занят на эту дату";
                    }
                }
                if(!all_ok){
                    alert(message);
                    $(this).find(":input").disabled(false);
                }else{
                    $(this).unbind('submit').submit();
                }
            })
        });
    @endauth
    </script>
@endsection

@section('styles')
    <style>
        .fio{
            position: relative;
            height: 3rem;
            line-height: 3rem;
            width: 100%;
            font-size: 16px;
            margin: 0 0 8px 0;
            padding: 0;
            display: block;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            z-index: 1;
        }
        span.price{
            font-size: 1.5em;
            font-weight: bold;
            letter-spacing: 0.01em;
            color: #76BC1C;
        }
    </style>
@endsection
