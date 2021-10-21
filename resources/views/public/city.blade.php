@extends('layouts.app')

@section('seo')
    <title>{{$seo_title}}</title>
    <meta name="description" content="{{$seo_description}}"/>
    @foreach(config('app.locales') as $locale)
        @if($locale != app()->getLocale())
            <link rel="alternate" hreflang="{{$locale}}" href="https://restomama.com/{{$locale}}/{{$city_uri}}">
        @endif
    @endforeach
@endsection

@section('content')
    @include('public.components.search_form')
    @include('public.components.products_list')
@endsection
