@extends('layouts.account')

@section('scripts')
    @include('admin.components.tinymce_script')
    <script src="{{ asset('admin/js/bundle.min.js') }}"></script>
    <script>
        $('document').ready(function(){
            let instance = new SelectPure(".restaurant", {
                options: [
                    @foreach($restaurants as $restaurant)
                        @foreach($restaurant->langs as $lang)
                            @if($lang->lang == app()->getLocale())
                    {
                        label: '{!! $lang->heading !!}',
                        value: '{{ $restaurant->id }}',
                    },
                            @endif
                        @endforeach
                    @endforeach
                ],
                @if(isset($event))
                    value: '{{$event->restaurant_id}}',
                @endif
                onChange: value => {
                    document.getElementById('restaurant').value = value;
                },
                autocomplete: true,
            });
        });
    </script>
@endsection

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">
                @if(isset($event_langs))
                    {{ $event_langs[app()->getLocale()]['name'] }}
                @else
                    Новое мероприятие
                @endif
            </h1>
            <div class="card">
                <div class="card-content">
                    @if(isset($event))
                        <form action="{{ route('events.update', ['id' => $event->id]) }}" method="post" enctype="multipart/form-data">
                            @method('PATCH')
                    @else
                        <form action="{{ route('events.store') }}" method="post" enctype="multipart/form-data">
                    @endif

                        @csrf
                        <div class="row">
                            <div class="col s12 right-align">
                                <button class="btn waves-effect waves-light" type="submit">
                                    Сохранить
                                    <i class="material-icons right">save</i>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <ul class="tabs">
                                    <li class="tab col s3"><a href="#general">Основные</a></li>
                                    @foreach(config('app.locales') as $locale)
                                        <li class="tab col s3"><a href="#lang_{{ $locale }}">{{ $locale }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div id="general" class="col s12">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" name="uri" id="uri" @if(isset($event->uri)) value="{{ $event->uri }}" @endif required/>
                                        <label for="uri">URL</label>
                                    </div>
                                    <div class="file-field input-field col s12">
                                        <div class="btn">
                                            <span>Фото</span>
                                            <input type="file" name="image">
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text" @if(isset($event->image_id)) value="{{ $event->image_id }}" @endif placeholder="Загрузите файл">
                                        </div>
                                    </div>
                                    <div class="input-field col s12">
                                        <select name="type" required>
                                            <option value="" disabled @if(!isset($event)) selected @endif>Выберите тип</option>
                                            @foreach($types as $type)
                                                @foreach($type->langs as $lang)
                                                    @if($lang->lang == app()->getLocale())
                                                        <option value="{{ $type->id }}" @if(isset($event->event_type_id) && $event->event_type_id == $type->id) selected @endif >{{ $lang->name }}</option>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </select>
                                        <label>Тип мероприятия</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <span class="restaurant select-wrapper"></span>
                                        <label>Ресторан</label>
                                        <input type="hidden" name="restaurant" id="restaurant" @if(isset($event)) value="{{$event->restaurant_id}}" @endif required/>

                                    </div>
                                    <div class="input-field col s12">
                                        <input type="number" name="sorting" id="sorting" @if(isset($event->sorting)) value="{{ $event->sorting }}" @endif required/>
                                        <label for="sorting">Сортировка</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input type="number" name="price" id="price" @if(isset($event->price)) value="{{ $event->price }}" @endif required/>
                                        <label for="price">Средний чек на человека (грн.)</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <label>
                                            <input type="checkbox" class="filled-in" @if(isset($event->active)) checked @endif name="is_active"/>
                                            <span>Опубликовать</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @foreach(config('app.locales') as $locale)
                                <div id="lang_{{ $locale }}" class="col s12">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input type="text" name="lang[{{ $locale }}][name]" id="lang_{{ $locale }}_name" required @if(isset($event_langs)) value="{{ $event_langs[$locale]['name'] }}" @endif/>
                                            <label for="lang_{{ $locale }}_name">Название (отображается в ссылках на страницу)</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input type="text" name="lang[{{ $locale }}][heading]" id="lang_{{ $locale }}_heading" required @if(isset($event_langs)) value="{{ $event_langs[$locale]['heading'] }}" @endif/>
                                            <label for="lang_{{ $locale }}_heading">Заголовок (служит заголовком страницы)</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input type="text" name="lang[{{ $locale }}][seo_title]" id="lang_{{ $locale }}_seo_title" required @if(isset($event_langs)) value="{{ $event_langs[$locale]['seo_title'] }}" @endif/>
                                            <label for="lang_{{ $locale }}_seo_title">SEO-заголовок</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <textarea
                                                id="seo_description_{{ $locale }}"
                                                name="lang[{{ $locale }}][seo_description]"
                                                type="text"
                                                class="materialize-textarea validate">@if(isset($event_langs)){{$event_langs[$locale]['seo_description']}}@endif</textarea>
                                            <label class="active" for="seo_description_{{ $locale }}">SEO description</label>
                                        </div>
                                        <div class="col s12">
                                            <label>
                                                Текст
                                            </label>
                                            <textarea
                                                id="content_{{ $locale }}"
                                                name="lang[{{ $locale }}][seo_text]"
                                                hidden>@if(isset($event_langs)){{$event_langs[$locale]['seo_text']}}@endif</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .select-wrapper {
            margin: auto;
        }

        .select-pure__select {
            align-items: center;
            background: #ffffff;
            border-radius: 0;
            border-bottom: 1px solid #9e9e9e;
            box-sizing: border-box;
            cursor: pointer;
            display: flex;
            font-size: 16px;
            font-weight: 400;
            justify-content: left;
            min-height: 44px;
            padding: 5px 0px;
            position: relative;
            transition: 0.2s;
            width: 100%;
        }

        .select-pure__options {
            background: #ffffff;
            border-radius: 4px;
            border: 1px solid rgba(0, 0, 0, 0.15);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
            box-sizing: border-box;
            color: #363b3e;
            display: none;
            left: 0;
            max-height: 221px;
            overflow-y: scroll;
            position: absolute;
            top: 50px;
            width: 100%;
            z-index: 5;
        }

        .select-pure__select--opened .select-pure__options {
            display: block;
        }

        .select-pure__option {
            background: #fff;
            border-bottom: 1px solid #e4e4e4;
            box-sizing: border-box;
            height: 44px;
            line-height: 25px;
            padding: 10px;
        }

        .select-pure__option--selected {
            color: #e4e4e4;
            cursor: initial;
            pointer-events: none;
        }

        .select-pure__option--hidden {
            display: none;
        }

        .select-pure__selected-label {
            background: #5e6264;
            border-radius: 4px;
            color: #fff;
            cursor: initial;
            display: inline-block;
            margin: 5px 10px 5px 0;
            padding: 3px 7px;
        }

        .select-pure__selected-label:last-of-type {
            margin-right: 0;
        }

        .select-pure__selected-label i {
            cursor: pointer;
            display: inline-block;
            margin-left: 7px;
        }

        .select-pure__selected-label i:hover {
            color: #e4e4e4;
        }

        .select-pure__autocomplete {
            background: #f9f9f8;
            border-bottom: 1px solid #e4e4e4;
            border-left: none;
            border-right: none;
            border-top: none;
            box-sizing: border-box;
            font-size: 16px;
            outline: none;
            padding: 10px!important;
            width: 100%;
        }
    </style>
@endsection
