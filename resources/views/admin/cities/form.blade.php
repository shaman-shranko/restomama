@extends('layouts.account')
@section('seo')
    <title>@lang('management.cities.form.page_title')</title>
@endsection
@section('scripts')
    @include('admin.components.tinymce_script')
@endsection

@section('styles')

@endsection

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">
                @if(isset($city_lang))
                    {{ $city_lang[app()->getLocale()]['name'] }}
                @else
                    @lang('management.cities.form.new')
                @endif
            </h1>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        @if(isset($city))
                            <form class="col s12" method="post" action="{{ route('cities.update', ['id' => $city->id]) }}">
                            @method('PATCH')
                        @else
                            <form class="col s12" method="post" action="{{ route('cities.store') }}">
                        @endif
                        @csrf
                        <div class="row">
                            <div class="col s12 right-align">
                                <button class="btn waves-effect waves-light" type="submit">
                                    @lang('management.cities.form.save')
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
                            <div class="col s12">
                                <ul class="tabs">
                                    @foreach(config('app.locales') as $key => $lang)
                                        <li class="tab col s3"><a @if($key == 0) class="active" @endif href="#{{ $lang }}">{{ $lang }}</a></li>
                                    @endforeach
                                    <li class="tab col s3"><a href="#settings">@lang('management.cities.form.settings')</a></li>
                                </ul>
                            </div>

                            @foreach(config('app.locales') as $lang)
                                <div id="{{$lang}}" class="col s12">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input
                                                @if(isset($city_lang)) value="{{ $city_lang[$lang]['name']}}" @endif
                                            id="description_{{$lang}}"
                                                name="langs[{{ $lang }}][name]"
                                                type="text" class="validate  @error('surname') invalid @enderror"
                                                required>
                                            <label class="active" for="description_{{$lang}}">@lang('management.cities.form.heading')</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input
                                                @if(isset($city_lang)) value="{{$city_lang[$lang]['seo_title']}}" @endif
                                            id="seo_title_{{$lang}}"
                                                name="langs[{{$lang}}][seo_title]"
                                                type="text"
                                                class="validate  @error('surname') invalid @enderror" required>
                                            <label class="active" for="seo_title_{{$lang}}">SEO title</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea
                                                id="seo_description_{{$lang}}"
                                                name="langs[{{$lang}}][seo_description]"
                                                type="text"
                                                class="materialize-textarea validate  @error('surname') invalid @enderror">@if(isset($city_lang)){{$city_lang[$lang]['seo_description']}}@endif</textarea>
                                            <label class="active" for="seo_description_{{$lang}}">SEO description</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <label>
                                                @lang('management.cities.form.text')
                                            </label>
                                            <textarea
                                                id="content_{{$lang}}"
                                                name="langs[{{$lang}}][seo_text]"
                                                hidden>@if(isset($city_lang)){{$city_lang[$lang]['seo_text']}}@endif</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div id="settings" class="col s12">
                                <div class="row">
                                    <div class="input-field col s12 m6">
                                        <input @if(isset($city)) value="{{$city->uri}}" @endif id="uri" name="uri" type="text" class="validate  @error('surname') invalid @enderror" required>
                                        <label class="active" for="uri">URI</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6 m3">
                                        <label>
                                            <input type="checkbox" class="filled-in" name="is_active" @if(isset($city) && $city->active) checked @endif/>
                                            <span>@lang('management.cities.form.active')</span>
                                        </label>
                                    </div>
                                    <div class="input-field col s6 m3">
                                        <input @if(isset($city)) value="{{$city->sorting}}" @else value="0" @endif id="sorting" name="sorting" type="number" class="validate  @error('surname') invalid @enderror" required>
                                        <label class="active" for="sorting">@lang('management.cities.form.order')</label>
                                    </div>
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
