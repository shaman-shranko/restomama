<ul class="collapsible">
    <li>
        @can('accessAdminPanel')
            <div class="collapsible-header">
                @lang('sidebar.my_cabinet')
            </div>
            <div class="collapsible-body">
                <ul>
                    @endcan
                    <li><a href="{{ route('account') }}">@lang('sidebar.cabinet')</a></li>
                    <li><a href="{{ route('my-orders.index') }}">@lang('sidebar.my_orders')</a></li>
                    <li><a href="{{ route('transactions.index') }}">@lang('sidebar.transactions')</a></li>
                    {{--                        <li><a href="#">?Способы оплаты</a></li>--}}
                    {{--                        <li><a href="#">?Комментарии</a></li>--}}
                    {{--                        <li><a href="#">?Сообщения</a></li>--}}
                    {{--                        <li><a href="#">?Уведомления</a></li>--}}
                    <li><a href="{{route('account-settings.edit', ['id'=>Auth::id()])}}">@lang('sidebar.settings')</a>
                    </li>
                    <li><a href="{{ route('pouch.index') }}">@lang('sidebar.pouch')</a></li>
                    @can('accessAdminPanel')
                </ul>
            </div>
    </li>
    @endcan
    @can('accessAdminPanel')
        <li>
            <div class="collapsible-header">
                @lang('sidebar.management')
            </div>
            <div class="collapsible-body">
                <ul>
                    {{--                        There will be links for restaurants functions--}}
                    @can('edit-restaurants')
                        <li><a href="{{ route('restaurants.index') }}" class="waves-effect">@lang('sidebar.restaurants')</a></li>
                        {{-- <li><a href="{{ route('events.index') }}" class="waves-effect">Мероприятия</a>
            </li> --}}
                    @endcan
                    @can('moderate-restaurants')
                        <li><a href="{{route('workload-list')}}" class="waves-effect">@lang('sidebar.workload')</a></li>
                    @endcan
                    @can('edit-restaurant-categories')
                        <li><a href="{{ route('restaurant-types.index') }}" class="waves-effect">@lang('sidebar.restaurant_types')</a></li>
                    @endcan
                    {{-- @can('edit-restaurants') --}}
                    {{-- <li><a href="{{ route('event_types.index') }}" class="waves-effect">Типы мероприятий</a></li> --}}
                    {{-- @endcan --}}
                    @can('edit-cities')
                        <li><a href="{{ route('cities.index') }}" class="waves-effect">@lang('sidebar.cities')</a></li>
                    @endcan
                    @can('edit-restaurants')
                        <li><a href="{{ route('kitchens.index') }}" class="waves-effect">@lang('sidebar.cuisines')</a></li>
                    @endcan
                    @can('edit-articles')
                        <li><a href="{{route('articles.index')}}" class="waves-effect">@lang('sidebar.articles')</a></li>
                        <li><a href="{{ route('questions.index') }}" class="waves-effect">@lang('sidebar.faq')</a></li>
                    @endcan
                    @can('create-users')
                        <li><a href="{{ route('users.index') }}" class=" waves-effect">@lang('sidebar.users')</a></li>
                        <li><a href="{{ route('roles.index') }}" class="waves-effect">@lang('sidebar.user_roles')</a></li>
                    @endcan
                    @can('editSettings')
                        <li><a href="{{ route('resize-buttons') }}" class="waves-effect">@lang('sidebar.images')</a></li>
                    @endcan
                    @can('edit-restaurants')
                        <li><a href="{{ route('landings.index') }}">Посадочные страницы</a></li>
                    @endcan
                </ul>
            </div>
        </li>
    @endcan
    @foreach($worked_at as $restaurant)
        <li>
            <div class="collapsible-header">
                @foreach($restaurant->languages as $lang)
                    @if($lang->language == app()->getLocale())
                        {{ $lang->name }}
                    @endif
                @endforeach
            </div>
            <div class="collapsible-body">
                <ul>
                    @if(auth()->user()->is_restaurant_administrator($restaurant))
                        <li>
                            <a href="{{ route('restaurant.orders', ['restaurant_id' => $restaurant->id ]) }}"
                               class="waves-effect">@lang('sidebar.orders')</a>
                        </li>
                    @endif
{{--                    @if(auth()->user()->is_restaurant_manager($restaurant))--}}
{{--                        <li>--}}
{{--                            <a href="#" class="waves-effect">Манагер</a>--}}
{{--                        </li>--}}
{{--                    @endif--}}
{{--                    @if(auth()->user()->is_restaurant_owner($restaurant))--}}
{{--                        <li>--}}
{{--                            <a href="#" class="waves-effect">Хозяин</a>--}}
{{--                        </li>--}}
{{--                    @endif--}}
                </ul>
            </div>
        </li>
    @endforeach


</ul>
