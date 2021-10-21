@extends('layouts.app')

@section('seo')
    <title>{{$seo_title}}</title>
    <meta name="description" content="{{$seo_description}}"/>
    @foreach(config('app.locales') as $locale)
        @if($locale != app()->getLocale())
            <link rel="alternate" hreflang="{{$locale}}" href="https://restomama.com/{{$locale}}/{{$restaurant->city->uri}}/{{$restaurant->uri}}">
        @endif
    @endforeach
@endsection

@section('styles')
    <style>
        span.price{
            font-size: 1.5em;
            font-weight: bold;
            letter-spacing: 0.01em;
            color: #76BC1C;
        }
        @media (max-width: 600px){
            .characteristic__caption{
                width: 50%;
                max-width: 50%;
                min-width: 50%;
            }
        }
    </style>
@endsection


@section('content')
    @include('public.components.product_home_screen')
    <div class="container container-info">
        <div class="row" style="flex-wrap: wrap">
            @include('public.components.product_characteristics')
            <div class="col s12 m6">
                <form method="post" id="order_form" action="{{ route('order.create', ['city_uri' => $restaurant->city->uri, 'restaurant_uri' => $restaurant->uri]) }}" class="card">
                    @csrf
                    <input type="hidden" name="date" id="date"/>
                    <div class="card-content">
                        <h4 class="heading-4" style="margin-top: 0">@lang('client.product.calendar.title')</h4>
                        <div class="row">
                            <div class="col s12 m6">
                                <div class="load_hall load_restaurant">
                                    <div id="dates_restaurant"></div>
                                </div>
                                @foreach($restaurant->halls as $hall)
                                    <div class="load_hall load_hall_{{$hall->id}}" style="display: none">
                                        <div id="dates_hall_{{$hall->id}}"></div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col s12 m6">
                                <div class="input-field col s12">
                                    <select id="calendar_select" name="location">
                                        <option value="restaurant" selected>@lang('client.product.calendar.whole_restaurant')</option>
                                        @foreach($restaurant->halls as $hall)
                                            @foreach($hall->languages as $lang)
                                                @if($lang->language == app()->getLocale())
                                                    <option value="{{$hall->id}}">{{$lang->name}}</option>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col s12 grid_comment">
                                    <div class="grid_example load"></div>
                                    <div>@lang('client.product.calendar.no_place')</div>
                                </div>
                                <div class="col s12 grid_comment">
                                    <div class="grid_example partial"></div>
                                    <div>@lang('client.product.calendar.has_places')</div>
                                </div>
                                <div class="col s12 grid_comment">
                                    <div class="grid_example free"></div>
                                    <div>@lang('client.product.calendar.free')</div>
                                </div>
                                <div class="input-field col s12">
                                    <button type="submit" class="btn order_button" style="width: 100%;">@lang('client.product.calendar.book')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if(isset($restaurant->menu->items))
        @include('public.components.product_menu')
    @endif
    @if(isset($restaurant->halls))
        @foreach($restaurant->halls as $hall)
            @include('public.components.product_hall')
        @endforeach
    @endif
    @foreach($restaurant->languages as $lang)
        @if($lang->language == app()->getLocale())
            @include('public.components.seo_text')
        @endif
    @endforeach


@endsection

@section('scripts')
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

            // $('.timepicker').timepicker({
            //     twelveHour: false
            // });

            {{--$('#modal1 input[name="quantity"]').on('keyup', function(){--}}
            {{--    let that = $(this);--}}
            {{--    let val = Math.floor(that.val());--}}
            {{--    if(val < 1) val = 1;--}}
            {{--    that.val(val);--}}

            {{--    $('#modal1 span.total').text(Math.floor(val*{{$restaurant->price}}));--}}
            {{--    $('#modal1 span.deposit').text(Math.floor(val*0.2*{{$restaurant->price}}));--}}
            {{--});--}}

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
    </script>
@endsection
