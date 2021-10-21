@extends('layouts.app')

@section('seo')
    @foreach($article->languages as $lang)
        @if($lang->language == app()->getLocale())
            <title>{{$lang->seo_title}}</title>
            <meta name="description" content="{{$lang->seo_description}}"/>
        @endif
    @endforeach
    @foreach(config('app.locales') as $locale)
        @if($locale != app()->getLocale())
            <link rel="alternate" hreflang="{{$locale}}" href="https://restomama.com/{{$locale}}/articles/{{$article->uri}}">
        @endif
    @endforeach
@endsection

@section('content')
    @foreach($article->languages as $lang)
        @if($lang->language == app()->getLocale())
            <div class="container" style="padding-top: 40px; padding-bottom: 40px;">
                <div class="row">
                    <div class="col s12">
                        <h1 class="heading-1">{!! $lang->title !!}</h1>
                    </div>
                    <div class="col s12 info">
                        {!! $lang->description !!}
                    </div>
                </div>
            </div>
        @endif
    @endforeach

@endsection
