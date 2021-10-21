@extends('layouts.account')
@section('seo')
    <title>@lang('management.workload.form.page_title')</title>
@endsection
@section('styles')
    <link href='{{asset('admin/fullcalendar/core/main.min.css')}}' rel='stylesheet'/>
    <link href='{{asset('admin/fullcalendar/daygrid/main.min.css')}}' rel='stylesheet'/>
    <style>
        .tabs .tab a {
            color: #000000 !important;
        }

        .tabs .tab a:hover, .tabs .tab a.active {
            color: #F65050 !important;
        }
    </style>
@endsection

@section('scripts-bottom')
    <script src='{{asset('admin/fullcalendar/core/main.min.js')}}'></script>
    @if(app()->getLocale() == 'ua')
        <script src='{{asset('admin/fullcalendar/core/locales/uk.js')}}'></script>
    @elseif(app()->getLocale() == 'ru')
        <script src='{{asset('admin/fullcalendar/core/locales/ru.js')}}'></script>
    @endif
    <script src='{{asset('admin/fullcalendar/daygrid/main.min.js')}}'></script>
    <script src='{{asset('admin/fullcalendar/interaction/main.min.js')}}'></script>
    <script>

        $('.modal').modal();
        // initCalendar('restaurant_calendar');
        let calendar_array = [];
        @foreach($restaurant->halls as $hall)
            calendar_array.h{{$hall->id}} = initCalendar('hall_{{$hall->id}}_calendar', [
                @foreach($hall->schedule as $schedule)
            {
                id: "{{$schedule->date}}",
                start: "{{$schedule->date}}",
                @switch($schedule->status)
                        @case(1)
                title: 'Частично занят',
                color: '#ff7d00',
                @break
                        @case(2)
                title: 'Занят',
                color: '#ff0000',
                @break
                        @case(3)
                title: 'Выходной',
                color: '#0000ff',
                @break
                @endswitch
            },
            @endforeach
        ]);
        @endforeach

        function initCalendar(id, schedule) {
            let calendarEl = document.getElementById(id);

            let calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['dayGrid', 'interaction'],
                @if(app()->getLocale() == 'ua')
                locale: 'uk',
                @elseif(app()->getLocale() == 'ru')
                locale: 'ru',
                @endif
                height: 500,
                fixedWeekCount: false,
                allDayDefault: true,
                firstDay: 1,
                events: schedule,
                dateClick: function (info) {
                    let moment = info.view.calendar.getDate();
                    let currentDate = "" + moment.getFullYear() + "-" + moment.getMonth() + "-" + moment.getDay();
                    let currentDateM = moment;
                    moment = info.date;
                    let clickedDate = "" + moment.getFullYear() + "-" + moment.getMonth() + "-" + moment.getDay();
                    let clickedDateM = moment;
                    if (clickedDate === currentDate || clickedDateM > currentDateM) {
                        let firstInput = $('.schedule-form input[type="radio"][value="0"]');
                        if (info.view.calendar.getEventById(info.dateStr) === null) {
                            firstInput.attr('disabled', true);
                            $('.schedule-form input[type="radio"][value="1"]').trigger('click');
                        } else {
                            firstInput.attr('disabled', false);
                            $('.schedule-form input[type="radio"]').attr('checked', false);
                            firstInput.trigger('click');
                        }
                        var elem = document.getElementById('modal1');
                        $('.schedule-form input[name="date"]').val(info.dateStr);
                        $('.schedule-form input[name="hall_id"]').val($(info.dayEl).parents('.schedule_tab').find('input[type="hidden"]').val());
                        var instance = M.Modal.getInstance(elem);
                        instance.open();
                    }
                }
            });

            calendar.render();

            return calendar;
        }
        $('.schedule-form button').click(function (e) {
            e.preventDefault();
            // console.log('validate');
            $.ajax({
                url: "{{route('change-schedule')}}",
                type: 'POST',
                dataType: 'json',
                data: $('.schedule-form').serialize(),
                success: function (response) {
                    console.log(response);
                    let event = calendar_array['h' + response.id].getEventById(response.date);
                    let title = '';
                    let color = '';
                    switch (response.status) {
                        case "0":
                            title = "Свободен";
                            color = "#00ff00";
                            break;
                        case "1":
                            title = "Частично занят";
                            color = "#ff7d00";
                            break;
                        case "2":
                            title = "Занят";
                            color = "#ff0000";
                            break;
                        case "3":
                            title = "Выходной";
                            color = "#0000ff";
                            break;
                    }
                    if (event !== null) {
                        event.remove();
                    }
                    if (response.status !== "0") {
                        calendar_array['h' + response.id].addEvent({
                            id: response.date,
                            title: title,
                            start: response.date,
                            color: color
                        });
                    }
                },
                error: function (data) {
                    let errors = $.parseJSON(data.responseText);
                    $.each(errors, function (key, value) {
                        console.log(value);
                    });
                }
            });
            $('#modal1').modal('close');
        });
    </script>
@endsection

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">
                @foreach($restaurant->languages as $lang)
                    @if($lang->language == app()->getLocale())
                        {{$lang->name}}. @lang('management.workload.form.schedule')
                    @endif
                @endforeach
            </h1>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12">
                            <ul class="tabs">
                                {{--                                <li class="tab"><a class="active" href="#restaurant">Ресторан</a></li>--}}
                                @foreach($restaurant->halls as $hall)
                                    <li class="tab">
                                        <a href="#hall_{{$hall->id}}">
                                            @foreach($hall->languages as $lang)
                                                @if($lang->language == app()->getLocale())
                                                    {{$lang->name}}
                                                @endif
                                            @endforeach
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div id="restaurant" class="col s12 schedule_tab">
                            <div id="restaurant_calendar"></div>
                        </div>
                        @foreach($restaurant->halls as $hall)
                            <div id="hall_{{$hall->id}}" class="col s12 schedule_tab">
                                <input type="hidden" value="{{$hall->id}}"/>
                                <div id="hall_{{$hall->id}}_calendar"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal1" class="modal bottom-sheet" style="padding-bottom: 30px;">
        <div class="modal-content">
            <div class="container" style="max-width: 500px;">
                <h4>@lang('management.workload.form.state'):</h4>
                <form class="ajax-form schedule-form" action="" method="post">
                    @csrf
                    <input type="hidden" name="hall_id"/>
                    <input type="hidden" name="date"/>
                    <p>
                        <label>
                            <input name="status" value="0" type="radio" checked/>
                            <span>@lang('management.workload.form.free')</span>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input name="status" value="1" type="radio"/>
                            <span>@lang('management.workload.form.partial')</span>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input name="status" value="2" type="radio"/>
                            <span>@lang('management.workload.form.busy')</span>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input name="status" value="3" type="radio"/>
                            <span>@lang('management.workload.form.end')</span>
                        </label>
                    </p>
                    <p class="right-align">
                        <button type="submit" class="waves-effect btn">OK</button>
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection
