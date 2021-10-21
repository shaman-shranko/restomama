@extends('layouts.account')
@section('seo')
    <title>@lang('management.restaurants.index.page_title')</title>
@endsection
@section('styles')

@endsection

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">@lang('management.restaurants.index.page_title')</h1>
            <div class="card">
                <div class="card-content">
                    <div class="row right-align">
                        <a href="{{ route('restaurants.create') }}" class="btn waves-effect waves-light">
                            @lang('management.restaurants.index.add')
                        </a>
                    </div>
                    @if($restaurants->count() == 0)
                        <div class="row">
                            @lang('management.restaurants.index.empty')
                        </div>
                    @else
                        <div class="row">
                            <table class="responsive-table">
                                <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        @lang('management.restaurants.index.name')
                                    </th>
                                    <th>
                                        @lang('management.restaurants.index.city')
                                    </th>
                                    <th>
                                        @lang('management.restaurants.index.type')
                                    </th>
                                    <th>

                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($restaurants as $key => $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            @foreach($item->languages as $lang)
                                                <div>
                                                    {{$lang->language}} : {{$lang->name}}
                                                </div>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if(isset($item->city))
                                                @foreach($item->city->languages as $lang)
                                                    @if($lang->language == app()->getLocale())
                                                        {{$lang->name}}
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @foreach($item->types as $type)
                                                @foreach($type->languages as $lang)
                                                    @if($lang->language == app()->getLocale())
                                                        {{$lang->name}}<br/>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{route('restaurants.show', ['id'=>$item->id])}}" class=""><i
                                                        class="material-icons green-text">create</i></a>
                                            <form method="post"
                                                  action="{{route('restaurants.destroy', ['id'=>$item->id])}}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit"
                                                        title="@lang('management.restaurants.index.remove')">
                                                    <i class="material-icons red-text">close</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
