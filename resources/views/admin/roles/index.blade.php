@extends('layouts.account')
@section('seo')
    <title>@lang('management.roles.index.page_title')</title>
@endsection
@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">@lang('management.roles.index.title')</h1>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 right-align">
                            <a href="{{ route('roles.create') }}" class="btn waves-effect waves-light">
                                @lang('management.roles.index.add')
                            </a>
                        </div>
                    </div>
                    @if($roles->count() == 0)
                        <div class="row">
                            <div class="col-12">
                                @lang('management.roles.index.empty')
                            </div>
                        </div>
                    @else
                        <table class="highlight responsive-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Alias</th>
                                <th>@lang('management.roles.index.name')</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $key => $item)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $item->alias }}
                                    </td>
                                    <td>
                                        @foreach( $item->languages as $lang)
                                            @if($lang->language == app()->getLocale())
                                                {{ $lang->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('roles.edit', ['id' =>  $item->id ]) }}" title="@lang('management.roles.index.edit')">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        <form method="post" action="{{ route('roles.destroy', ['id' => $item->id ]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit">
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
