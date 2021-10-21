@extends('layouts.account')
@section('seo')
    <title>
        @foreach($restaurant->languages as $lang)
            @if($lang->language == app()->getLocale())
                {{$lang->name}}
            @endif
        @endforeach
    </title>
@endsection
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
                @foreach($restaurant->languages as $lang)
                    @if($lang->language == app()->getLocale())
                        {{$lang->name}}
                    @endif
                @endforeach
            </h1>
            <ul class="collapsible sky-data">
                <li>
                    <div class="collapsible-header red lighten-4">
                        @lang('management.restaurants.view.general')
                        <a href="{{ route('restaurants.edit', ['id'=>$restaurant->id]) }}"><i class="material-icons">create</i></a>
                    </div>
                    <div class="collapsible-body">
                        <table>
                            <thead>
                                <tr>
                                    <th>@lang('management.restaurants.view.settings')</th>
                                    @foreach(config('app.locales') as $locale)
                                        <th>{{$locale}}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div>
                                            @if(isset($restaurant->image->filepath))
                                                <img src="/{{$restaurant->image->filepath}}" style="width: 100%; max-width: 300px;"/>
                                            @else
                                                <div>
                                                    <span style="font-weight: 500">@lang('management.restaurants.view.image'):</span> @lang('management.restaurants.view.no')
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <span style="font-weight: 500">URI:</span> {{$restaurant->uri}}
                                        </div>
                                        <div>
                                            <span style="font-weight: 500">@lang('management.restaurants.view.status'):</span>
                                            @if($restaurant->active) @lang('management.restaurants.view.publicated') @else @lang('management.restaurants.view.unpublicated') @endif
                                        </div>
                                        <div>
                                            <span style="font-weight: 500">@lang('management.restaurants.view.order'):</span> {{$restaurant->sorting}}
                                        </div>
                                        <div>
                                            <span style="font-weight: 500">@lang('management.restaurants.view.city'):</span>
                                            @foreach($restaurant->city->languages as $lang)
                                                @if($lang->language == app()->getLocale())
                                                    {{$lang->name}}
                                                @endif
                                            @endforeach
                                        </div>
                                        <div>
                                            <span style="font-weight: 500">@lang('management.restaurants.view.type'):</span>
                                            @foreach($restaurant->types as $type)
                                                @foreach($type->languages as $lang)
                                                    @if($lang->language == app()->getLocale())
                                                        {{$lang->name}},
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </div>
                                        <div>
                                            <span style="font-weight: 500">@lang('management.restaurants.view.cuisine'):</span>
                                            @foreach($restaurant->kitchens as $type)
                                                @foreach($type->languages as $lang)
                                                    @if($lang->language == app()->getLocale())
                                                        {{$lang->name}},
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </div>
                                        <div>
                                            <span style="font-weight: 500">@lang('management.restaurants.view.table_deposit'):</span> {{$restaurant->price}} @lang('management.restaurants.view.uah').
                                        </div>
                                        <div>
                                            <span style="font-weight: 500">@lang('management.restaurants.view.banket_deposit'):</span> {{$restaurant->opt_price}} @lang('management.restaurants.view.uah').
                                        </div>
                                        <div>
                                            <span style="font-weight: 500">@lang('management.restaurants.view.volume'):</span> {{$restaurant->capacity}} @lang('management.restaurants.view.ppl')
                                        </div>
                                        <div>
                                            <span style="font-weight: 500">@lang('management.restaurants.view.video_link'):</span> {{$restaurant->video}}
                                        </div>
                                        <div>
                                            <span style="font-weight: 500">@lang('management.restaurants.view.gift'):</span> @if($restaurant->gift) @lang('management.restaurants.view.yes') @else @lang('management.restaurants.view.no') @endif
                                        </div>
                                    </td>
                                    @foreach(config('app.locales') as $locale)
                                        <td>
                                            @foreach($restaurant->languages as $lang)
                                                @if($lang->lang == $locale)
                                                    <div>
                                                        <span style="font-weight: 500">@lang('management.restaurants.view.heading'):</span> {{$lang->name}}
                                                    </div>
                                                    <div>
                                                        <span style="font-weight: 500">SEO title:</span> {{$lang->seo_title}}
                                                    </div>
                                                    <div>
                                                        <span style="font-weight: 500">SEO description:</span> {{$lang->seo_description}}
                                                    </div>
                                                    <div>
                                                        <span style="font-weight: 500">SEO text:</span> @if(isset($lang->seo_text)) @lang('management.restaurants.view.filled') @else @lang('management.restaurants.view.not_filled') @endif
                                                    </div>
                                                    <div>
                                                        <span style="font-weight: 500">@lang('management.restaurants.view.address'):</span> {{$lang->address}}
                                                    </div>
                                                    <div>
                                                        <span style="font-weight: 500">@lang('management.restaurants.view.schedule'):</span> {{$lang->schedule}}
                                                    </div>
                                                    <div>
                                                        <span style="font-weight: 500">@lang('management.restaurants.view.discount'):</span> {{$lang->discount}}
                                                    </div>
                                                @endif
                                            @endforeach
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header red lighten-4">@lang('management.restaurants.view.staff') <a href="{{ route('staff.create', ['id' => $restaurant->id]) }}"><i class="material-icons">add_circle_outline</i></a></div>
                    <div class="collapsible-body">
                        @if($restaurant->staff->count() == 0)
                            <span>Персонал пока не указан</span>
                        @else
                            <table class="responsive-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('management.restaurants.view.name_surname')</th>
                                        <th>@lang('management.restaurants.view.position')</th>
                                        <th>@lang('management.restaurants.view.phone')</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($restaurant->staff as $staff)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$staff->user->surname}} {{$staff->user->name}}</td>
                                        @foreach($staff->role->languages as $lang)
                                            @if($lang->language == app()->getLocale())
                                                <td>{{$lang->name}}</td>
                                            @endif
                                        @endforeach
                                        <td>{{$staff->user->phone}}</td>
                                        <td>
                                            <form method="post" action="{{ route('staff.destroy', ['id' => $staff->id]) }}">
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
                </li>
                <li>
                    <div class="collapsible-header red lighten-4">@lang('management.restaurants.view.gallery') <a href="{{route('gallery.edit', ['id'=>$restaurant->id])}}"><i class="material-icons">create</i></a></div>
                    <div class="collapsible-body">
                        @if(!isset($restaurant->gallery))
                            <span>@lang('management.restaurants.view.empty_gallery')</span>
                        @else
                            <div class="row">
                                @foreach($restaurant->gallery->items as $item)
                                    <div class="col s3">
                                        <img style="width: 100%" src="/{{$item->image->filepath}}"/>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </li>
                <li>
                    <div class="collapsible-header red lighten-4">@lang('management.restaurants.view.menu') <a href="{{route('menu.edit', ['id'=>$restaurant->id])}}"><i class="material-icons">create</i></a></div>
                    <div class="collapsible-body">
                        @if(!isset($restaurant->menu))
                            <span>@lang('management.restaurants.view.empty_menu')</span>
                        @else
                            <div class="row">
                                @foreach($restaurant->menu->items as $item)
                                    <div class="col s3">
                                        <img style="width: 100%" src="/{{$item->image->filepath}}"/>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </li>
                <li>
                    <div class="collapsible-header red lighten-4">@lang('management.restaurants.view.halls') <a href="{{route('halls.create', ['id'=>$restaurant->id])}}"><i class="material-icons">add_circle_outline</i></a></div>
                    <div class="collapsible-body">
                        @if(isset($restaurant->halls))
                            @foreach($restaurant->halls as $hall)
                                <div class="row">
                                    <div class="col s12">
                                        @foreach($hall->languages as $lang)
                                            @if($lang->language == app()->getLocale())
                                                <h4 class="flow-text">{{$lang->name}} @if($hall->active) @lang('management.restaurants.view.publicated') @else @lang('management.restaurants.view.unpublicated')  @endif
                                                    <div class="sky-actions">
                                                        <a href="{{route('halls.edit', ['id' => $hall->id])}}"><i class="material-icons">create</i></a>
                                                        <form method="post" action="{{route('halls.destroy', ['id' => $hall->id])}}">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit">
                                                                <i class="material-icons">close</i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </h4>
                                                <hr/>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col s12">
                                        @if(isset($hall->gallery))
                                            <div class="row">
                                                @foreach($hall->gallery->items as $item)
                                                    <div class="col s3">
                                                        <img style="width: 100%" src="/{{$item->image->filepath}}"/>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span>@lang('management.restaurants.view.no_halls_gallery')</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <span>@lang('management.restaurants.view.no_halls')</span></div>
                        @endif

                </li>
{{--                <li>--}}
{{--                    <div class="collapsible-header red lighten-4">Мероприятия</div>--}}
{{--                    <div class="collapsible-body"><span>На данный момент ничего не создано</span></div>--}}
{{--                </li>--}}
            </ul>
        </div>
    </div>
@endsection
