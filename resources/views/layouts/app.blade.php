<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('seo')

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('app/js/responsivelyLazy.min.js') }}" defer></script>
    <script src="{{ asset('app/js/jquery.js') }}" defer></script>
    <script src="{{ asset('app/js/materialize.min.js') }}" defer></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js" defer></script>

    <script src="{{ asset('app/js/app.js') }}?v=001" defer></script>

    @yield('scripts')

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400|Roboto:400,500,500i,700&display=swap&subset=cyrillic-ext" rel="stylesheet">

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link href="{{ asset('app/css/app.css') }}?v=001" rel="stylesheet">

    @yield('styles')
</head>
<body>
    <div class="wrapper">
        @include('public.components.header')

        <main>
            @yield('content')
        </main>

        @include('public.components.footer')
    </div>
</body>
</html>
