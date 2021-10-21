<header class="navbar-fixed">
    <nav>
        <div class="row">
            <div class="col s12">
                <div class="nav-wrapper">
                    <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>

                    <ul class="right nav-list hide-on-med-and-down sky-head-nav">
                        <li>
                            <ul class="nav-list">
                                @include('public.components.header_nav')
                            </ul>
                        </li>
                        <li>
                            <ul class="nav-list">
                                <li>
                                    <a class="lang-toggle dropdown-trigger" data-target='lang-list'>
                                        <i class="material-icons">language</i>
                                        {{ app()->getLocale() }}
                                    </a>
                                    <ul id='lang-list' class='dropdown-content'>
                                        @foreach(config('app.locales') as $locale)
                                            <li>
                                                <a href="{{route('lang',['lang'=>$locale])}}">
                                                    @if(app()->getLocale() == $locale)
                                                        <i class="material-icons">check_box</i>
                                                    @else
                                                        <i class="material-icons">check_box_outline_blank</i>
                                                    @endif
                                                    {{$locale}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                @guest
                                    <li><a href="{{ route('login') }}"><i class="material-icons">perm_identity</i> {{ __('auth.Login') }}</a></li>
                                    @if(Route::has('register'))
                                        <li><a href="{{ route('register') }}" class="btn">{{ __('auth.Register') }}</a></li>
                                    @endif
                                @else
                                    @can('accessAccount')
                                        <li><a href="{{ route('account') }}"><i class="material-icons">perm_identity</i> Аккаунт</a></li>
                                    @endcan
                                    <li>
                                        <a href="{{ route('logout') }}" class="btn" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">{{ __('auth.Logout') }}</a>
                                        <form id="logout-form_1" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                @endguest
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
<ul id="slide-out" class="sidenav">
    <li>
        <a class="lang-toggle dropdown-trigger" data-target='lang-list-2'>
            <i class="material-icons">language</i>
            {{ app()->getLocale() }}
        </a>
        <ul id='lang-list-2' class='dropdown-content'>
            @foreach(config('app.locales') as $locale)
                <li>
                    <a href="{{route('lang',['lang'=>$locale])}}">
                        @if(app()->getLocale() == $locale)
                            <i class="material-icons">check_box</i>
                        @else
                            <i class="material-icons">check_box_outline_blank</i>
                        @endif
                        {{$locale}}
                    </a>
                </li>
            @endforeach
        </ul>
    </li>
    <li class="account-block">
    @guest
        <a href="{{ route('login') }}"><i class="material-icons">perm_identity</i> {{ __('auth.Login') }}</a>
        @if(Route::has('register'))
            <a href="{{ route('register') }}" class="btn">{{ __('auth.Register') }}</a>
        @endif
    @else
        <a href="{{ route('account') }}"><i class="material-icons">perm_identity</i> Аккаунт</a>
        <a href="{{ route('logout') }}" class="btn" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">{{ __('auth.Logout') }}</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endguest
    </li>

    @include('account.components.account_nav')
    @include('public.components.header_nav')
</ul>
