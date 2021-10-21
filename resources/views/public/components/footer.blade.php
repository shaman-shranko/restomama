<footer class="page-footer">
    <div class="container">
        <div class="row">
            <div class="col l4 s12">
                <a href="{{ url('/') }}" class="brand-logo"><img src="/images/logo.png" alt=""/></a>
            </div>
            <div class="col l8 s12">
                <div class="row">
                    <div class="col l4 s12">
                        <h5 class="white-text">@lang('footer.info')</h5>
                        @include('public.components.footer_nav1')
                    </div>
                    <div class="col l4 s12">
                        <h5 class="white-text">@lang('footer.help')</h5>
                        @include('public.components.footer_nav2')
                    </div>
                    <div class="col l4 s12">
                        <h5 class="white-text">@lang('footer.contacts')</h5>
                        <ul>
                            <li><a class="grey-text text-lighten-3" href="#!">+38 (099) 99-99-999</a></li>
                            <li><a class="grey-text text-lighten-3" href="#!">example@mail.com</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <div class="row">
                <div class="col s12 center-align">
                    © 2019 @lang('footer.copyright')
                </div>
            </div>
        </div>
    </div>
</footer>
