@extends('layouts.account')

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">
                @if(isset($type))
                    Мероприятие: {{ $type_langs[app()->getLocale()]['name'] }}
                @else
                    Новый тип мероприятия
                @endif
            </h1>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        @if(isset($type))
                            <form class="col s12" method="post" action="{{ route('event_types.update', ['id' => $type->id]) }}">
                                @method('PATCH')
                                @else
                                    <form class="col s12" method="post" action="{{ route('event_types.store') }}">
                                        @endif
                                        @csrf
                                        <div class="row">
                                            <div class="col s12 right-align">
                                                <button class="btn waves-effect waves-light" type="submit">
                                                    Cохранить
                                                    <i class="material-icons right">save</i>
                                                </button>
                                            </div>
                                        </div>
                                        @if ($errors->count() > 0)
                                            <div class="row">
                                                <ul class="col s-12">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <div class="row">
                                            @foreach(config('app.locales') as $locale)
                                                <div class="input-field col s12">
                                                    <input type="text" name="lang[{{$locale}}][name]" id="name_ru" @if(isset($type_langs)) value="{{ $type_langs[$locale]['name'] }}" @endif required/>
                                                    <label>Название ({{ $locale }}):</label>
                                                </div>
                                            @endforeach
                                            <div class="input-field col s12">
                                                <input type="number" name="sorting" @if(isset($type)) value="{{$type->sorting}}" @endif required/>
                                                <label for="sorting">Порядок сортировки:</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <div class="switch">
                                                    <label>
                                                        <input type="checkbox" name="active" @if(isset($type) && $type->active) checked @endif>
                                                        <span class="lever"></span>
                                                        Включить
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
