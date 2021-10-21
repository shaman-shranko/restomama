<div class="home_main">
    <div class="home_main_card">
        <div class="home_main_card_text">
            <h1 class="heading-1">@lang('home.heading')</h1>
            <p>
                @lang('home.subheading')
                <br/>
                <br/>
                <a href="#">@lang('buttons.more_cashback')</a>
            </p>
        </div>
        <div class="home_main_card_buttons">
            <form action="{{ route('select-city') }}" class="row" method="post">
                @csrf
                <div class="input-field col s6">
                    <select name="city">
                        
                        @foreach($cities as $item)
                            @foreach($item->languages as $lang)
                                @if($lang->language == app()->getLocale())
                                    <option value="{{ $item->uri }}">{{ $lang->name }}</option>
                                @endif
                            @endforeach
                        @endforeach
                    </select>
                </div>
                <div class="input-field col s6">
                    <button type="submit" class="btn">@lang('buttons.see_restaurants')</button>
                </div>
            </form>
        </div>
    </div>
</div>
