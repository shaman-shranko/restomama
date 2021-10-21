@extends('layouts.account')


@section('seo')
    <title>@lang('management.cuisines.form.page_title')</title>
@endsection
@section('styles')

@endsection

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">
                @if(isset($item))
                    @foreach($item->languages as $lang)
                        @if($lang->language == app()->getLocale())
                            {{ $lang->name }}
                        @endif
                    @endforeach
                @else
                    @lang('management.cuisines.form.new')
                @endif
            </h1>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        @if(isset($item))
                            <form class="col s12" method="post" action="{{ route('kitchens.update', ['id' => $item->id]) }}">
                            @method('PATCH')
                        @else
                            <form class="col s12" method="post" action="{{ route('kitchens.store') }}">
                        @endif
                        @csrf
                        <div class="row">
                            <div class="col s12 right-align">
                                <button class="btn waves-effect waves-light" type="submit">
                                    @lang('management.cuisines.form.save')
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
                            @foreach(config('app.locales') as $lang)
                                @if(isset($item))
                                    @foreach($item->languages as $i_lang)
                                        @if($lang == $i_lang->language)
                                            <div class="input-field col s12">
                                                <input type="text" id="name_{{$lang}}" name="name[{{$lang}}]" value="{{$i_lang->name}}" required/>
                                                <label for="name_{{$lang}}" class="active">@lang('management.cuisines.form.name') ({{$lang}})</label>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                <div class="input-field col s12">
                                    <input type="text" id="name_{{$lang}}" name="name[{{$lang}}]" value="" required/>
                                    <label for="name_{{$lang}}" class="active">@lang('management.cuisines.form.name') ({{$lang}})</label>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
