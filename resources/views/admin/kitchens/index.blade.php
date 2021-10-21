@extends('layouts.account')
@section('seo')
    <title>@lang('management.cuisines.index.page_title')</title>
@endsection
@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">@lang('management.cuisines.index.page_title')</h1>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 right-align">
                            <a href="{{ route('kitchens.create') }}" class="btn waves-effect waves-light">
                                @lang('management.cuisines.index.add')
                            </a>
                        </div>
                    </div>
                    @if($items->count() == 0)
                        <div class="row">
                            <div class="col-12">
                                @lang('management.cuisines.index.empty')
                                @lang('management.cuisines.form.')
                            </div>
                        </div>
                    @else
                        <table class="highlight responsive-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('management.cuisines.index.name')</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $key => $item)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        @foreach( $item->languages as $lang)
                                            @if($lang->language == app()->getLocale())
                                                {{ $lang->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('kitchens.edit', ['id' =>  $item->id ]) }}" title="@lang('management.cuisines.index.edit')">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        <form method="post" action="{{ route('kitchens.destroy', ['id' => $item->id ]) }}">
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

