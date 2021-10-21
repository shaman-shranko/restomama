@extends('layouts.account')
@section('seo')
    <title>@lang('management.cities.index.page_title')</title>
@endsection
@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">@lang('management.cities.index.page_title')</h1>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 right-align">
                            <a href="{{ route('cities.create') }}" class="btn waves-effect waves-light">
                                @lang('management.cities.index.add')
                            </a>
                        </div>
                    </div>
                    @if($cities->count() == 0)
                        <div class="row">
                            <div class="col-12">
                                @lang('management.cities.index.empty')
                            </div>
                        </div>
                    @else
                        <table class="highlight responsive-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>URI</th>
                                <th>@lang('management.cities.index.name')</th>
                                <th>@lang('management.cities.index.status')</th>
                                <th>@lang('management.cities.index.order')</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cities as $key => $city)
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td>
                                        {{ $city->uri }}
                                    </td>
                                    <td>
                                        @foreach( $city->languages as $lang)
                                            @if($lang->language == app()->getLocale())
                                                {{ $lang->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @if( $city->active )
                                            @lang('management.cities.index.enabled')
                                        @else
                                            @lang('management.cities.index.disabled')
                                        @endif
                                    </td>
                                    <td>
                                        {{ $city->sorting }}
                                    </td>
                                    <td>
                                        <a href="{{ route('cities.edit', ['id' =>  $city->id ]) }}" title="@lang('management.cities.index.edit')">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        <form method="post" action="{{ route('cities.destroy', ['id' => $city->id ]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" title="@lang('management.cities.index.remove')">
                                                <i class="material-icons red-text lighten-1-text">cancel</i>
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
