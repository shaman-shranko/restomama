<div class="col s12 m6">
    <div class="card">
        <div class="card-content">
            @foreach($restaurant->languages as $lang)
                @if($lang->language == app()->getLocale())
                    <div class="characteristic">
                        <div class="characteristic__caption">
                            <i class="material-icons">location_on</i>
                            @lang('client.product.chars.address'):
                        </div>
                        <div class="characteristic__value">
                            @if(isset($lang->address))
                                {{$lang->address}}
                            @else
                               @lang('client.product.chars.not_set')
                            @endif
                        </div>
                    </div>
                    <div class="characteristic">
                        <div class="characteristic__caption">
                            <i class="material-icons">query_builder</i>
                            @lang('client.product.chars.schedule'):
                        </div>
                        <div class="characteristic__value">
                            @foreach($restaurant->languages as $lang)
                                @if($lang->language == app()->getLocale())
                                    {{$lang->schedule}}
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="characteristic">
                        <div class="characteristic__caption">
                            <i class="material-icons">room_service</i>
                            @lang('client.product.chars.cuisine')
                        </div>
                        <div class="characteristic__value">
                            @foreach($restaurant->kitchens as $type)
                                @foreach($type->languages as $lang)
                                    @if($lang->language == app()->getLocale())
                                        @if($loop->last)
                                            {{$lang->name}}
                                        @else
                                            {{$lang->name}}
                                        @endif
                                    @endif
                                @endforeach
                                @if(!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="characteristic">
                        <div class="characteristic__caption">
                            <i class="material-icons">cake</i>
                            @lang('client.product.chars.gift'):
                        </div>
                        <div class="characteristic__value">
                            @if($restaurant->gift)
                                @foreach($restaurant->languages as $lang)
                                    @if($lang->language == app()->getLocale())
                                        {{$lang->gift_text}}
                                    @endif
                                @endforeach
                            @else
                                @lang('client.product.chars.no')
                            @endif
                        </div>
                    </div>
                    <div class="characteristic">
                        <div class="characteristic__caption">
                            <i class="material-icons">attach_money</i>
                            @lang('client.product.chars.discount'):
                        </div>
                        <div class="characteristic__value">
                            @foreach($restaurant->languages as $lang)
                                @if($lang->language == app()->getLocale())
                                    {{$lang->discount}}
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
