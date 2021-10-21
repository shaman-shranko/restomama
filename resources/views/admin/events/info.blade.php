@extends('layouts.account')

@section('styles')
    <style>
        .sky-data .collapsible-header{
            display: flex;
            justify-content: space-between;
        }
        .sky-data .collapsible-body{
            display: block!important;
            height: auto!important;
            padding: 2rem!important;
        }
        .sky-actions{
            float: right;
        }
    </style>
@endsection

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">
                {{ $event_langs[app()->getLocale()]['restaurant'] }}. {{ $event_langs[app()->getLocale()]['name'] }}
            </h1>
            <ul class="collapsible sky-data">
                <li>
                    <div class="collapsible-header red lighten-4">
                        Основная информация
                        <a href="{{ route('events.edit', ['id'=>$event->id]) }}"><i class="material-icons">create</i></a>
                    </div>
                    <div class="collapsible-body">
                        <table>
                            <thead>
                                <tr>
                                    <th>Настройки</th>
                                    @foreach(config('app.locales') as $locale)
                                        <th>{{$locale}}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div>
                                            @if(isset($event->image->filepath))
                                                <img src="/{{ $event->image->filepath }}" style="width: 100%; max-width: 300px;"/>
                                            @else
                                                <div>
                                                    <span style="font-weight: 500">Изображение:</span> нет
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <span style="font-weight: 500">URI:</span> {{ $event->uri }}
                                        </div>
                                        <div>
                                            <span style="font-weight: 500">Статус:</span>
                                            @if($event->active) Опубликовано @else Не опубликовано @endif
                                        </div>
                                        <div>
                                            <span style="font-weight: 500">Сортировка:</span> {{ $event->sorting }}
                                        </div>
                                        <div>
                                            <span style="font-weight: 500">Тип:</span> @if(isset($event_langs[app()->getLocale()]['type'])) {{ $event_langs[app()->getLocale()]['type'] }} @endif
                                        </div>
                                        <div>
                                            <span style="font-weight: 500">Ресторан:</span> @if(isset($event_langs[app()->getLocale()]['restaurant'])) {{ $event_langs[app()->getLocale()]['restaurant'] }} @endif
                                        </div>
                                        <div>
                                            <span style="font-weight: 500">Депозит столика:</span> {{ $event->price }} грн.
                                        </div>
                                    </td>
                                    @foreach(config('app.locales') as $locale)
                                        <td>
                                            <div>
                                                <span style="font-weight: 500">Название:</span> {{ $event_langs[$locale]['name'] ?: 'не указано' }}
                                            </div>
                                            <div>
                                                <span style="font-weight: 500">Заголовок:</span> {{ $event_langs[$locale]['heading'] ?: 'не указано' }}
                                            </div>
                                            <div>
                                                <span style="font-weight: 500">SEO заголовок:</span> {{ $event_langs[$locale]['seo_title'] ?: 'не указано' }}
                                            </div>
                                            <div>
                                                <span style="font-weight: 500">SEO описание:</span> {{ $event_langs[$locale]['seo_description'] ?: 'не указано' }}
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </li>
                <li>
                    <div class="collapsible-header red lighten-4">
                        Галлереи
                        <a href="{{ route('event_gallery.create', [ 'id' => $event->id ]) }}"><i class="material-icons">add_circle_outline</i></a>
                    </div>
                    <div class="collapsible-body">
                        @if(isset($event->galleries) && $event->galleries->count() > 0)
                            @foreach($event->galleries as $gallery)
                                <div class="row">
                                    <div class="col s12">
                                        <h4 class="flow-text">
                                            {{ isset($galleries_langs[$gallery->id][app()->getLocale()]['name']) ? $galleries_langs[$gallery->id][app()->getLocale()]['name'] : 'Без названия' }}
                                            <div class="sky-actions">
                                                <a href="{{route('event_gallery.edit', ['id' => $gallery->id])}}"><i class="material-icons">create</i></a>
                                                <form method="post" action="{{route('event_gallery.destroy', ['id' => $gallery->id])}}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </form>
                                            </div>
                                        </h4>
                                        <hr/>
                                    </div>
                                    <div class="col s12">
                                        @if($gallery->items->count() > 0)
                                            @foreach($gallery->items as $item)
                                                <div class="col s3">
                                                    <img style="width: 100%" src="/{{$item->image->filepath}}"/>
                                                </div>
                                            @endforeach
                                        @else
                                            Изображения пока не загруженны
                                        @endif
                                    </div>
                                </div>

                            @endforeach
                        @else
                            Галлерей пока не создано
                        @endif
                    </div>
                </li>
            </ul>
        </div>
    </div>
@endsection
