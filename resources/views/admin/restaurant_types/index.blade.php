@extends('layouts.account')
@section('seo')
    <title>@lang('management.restaurant_types.index.page_title')</title>
@endsection
@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">@lang('management.restaurant_types.index.page_title')</h1>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 right-align">
                            <a href="{{ route('restaurant-types.create') }}" class="btn waves-effect waves-light">
                                @lang('management.restaurant_types.index.add')
                            </a>
                        </div>
                    </div>
                    @if($types->count() == 0)
                    <div class="row">
                        <div class="col-12">
                            @lang('management.restaurant_types.index.empty')
                        </div>
                    </div>
                    @else
                        <table class="highlight responsive-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>URI</th>
                                    <th>@lang('management.restaurant_types.index.name')</th>
                                    <th>@lang('management.restaurant_types.index.status')</th>
                                    <th>@lang('management.restaurant_types.index.order')</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($types as $key => $type)
                                    <tr>
                                        <td>
                                            {{ $key + 1 }}
                                        </td>
                                        <td>
                                            {{ $type->uri }}
                                        </td>
                                        <td>
                                            @foreach( $type->languages as $lang)
                                                @if($lang->language == app()->getLocale())
                                                    {{ $lang->name }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @if( $type->active )
                                                @lang('management.restaurant_types.index.enabled')
                                            @else
                                                @lang('management.restaurant_types.index.disabled')
                                            @endif
                                        </td>
                                        <td>
                                            {{ $type->sorting }}
                                        </td>
                                        <td>
                                            <a href="{{ route('restaurant-types.edit', ['id' =>  $type->id ]) }}" title="@lang('management.restaurant_types.index.edit')">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <form method="POST" action="{{ route('restaurant-types.destroy', ['id' => $type->id ]) }}">
                                                @method("DELETE")
                                                @csrf
                                                <button type="submit" title="удалить"><i class="material-icons red-text lighten-1-text">cancel</i></button>
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
