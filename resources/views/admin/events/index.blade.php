@extends('layouts.account')

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">Мероприятия</h1>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 right-align">
                            <a href="{{ route('events.create') }}" class="btn waves-effect waves-light">
                                Добавить
                            </a>
                        </div>
                    </div>
                    @if($events->count() == 0)
                        <div class="row">
                            <div class="col-12">
                                На данный момент не создано ни одного типа мероприятия
                            </div>
                        </div>
                    @else
                        <table class="highlight responsive-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Название</th>
                                <th>Тип</th>
                                <th>Ресторан</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($events as $event)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        @foreach($event->langs as $lang)
                                            @if($lang->lang == app()->getLocale())
                                                {{ $lang->heading }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($event->type->langs as $lang)
                                            @if($lang->lang == app()->getLocale())
                                                {{ $lang->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($event->restaurant->langs as $lang)
                                            @if($lang->lang == app()->getLocale())
                                                {{ $lang->heading }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('events.show', ['id' => $event->id]) }}">
                                            <i class="material-icons">create</i>
                                        </a>
                                        <form method="post" action="{{ route('events.destroy', ['id' => $event->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">
                                                <i class="material-icons">close</i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
