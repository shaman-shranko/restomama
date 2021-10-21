@extends('layouts.app')

@section('seo')
    <title>@lang('home.seo-title')</title>
    <meta name="description" content="@lang('home.seo-description')"/>
    @foreach(config('app.locales') as $locale)
        @if($locale != app()->getLocale())
            <link rel="alternate" hreflang="{{$locale}}" href="https://restomama.com/{{$locale}}">
        @endif
    @endforeach
@endsection
@section('content')
    @include('public.components.main_start', ['cities'=>$cities])
{{--    @include('public.components.main_cities')--}}
    @include('public.components.main_steps')
    @include('public.components.main_popular', ['popular'=>$popular])
    @include('public.components.main_for_partners')
@endsection
