<div class="col l4 m6 s12">
    <a href="{{route('restaurant-page', ['restaurant_uri'=>$restaurant->uri, 'city_uri'=>$restaurant->city->uri])}}"
       class="card">
        <div class="card-image">
            @if(isset($restaurant->image))
                @php
                    $sizesSet = \App\Http\Controllers\Admin\ImageController::imageResponsive($restaurant->image, config('image.sizes.card'));
                @endphp
                @foreach($restaurant->languages as $lang)
                    @if($lang->language == app()->getLocale())
                        <img class="responsively-lazy" src="{{$sizesSet['src']}}" data-srcset="{{$sizesSet['srcset']}}"
                             alt="{{$lang->heading}}">
                    @endif
                @endforeach
            @else
                <img src="https://via.placeholder.com/500x350"/>
            @endif
            <button class="btn-floating halfway-fab waves-effect waves-light favorite"><i class="material-icons">favorite</i>
            </button>
        </div>
        <div class="card-content">
            @foreach($restaurant->languages as $lang)
                @if($lang->language == app()->getLocale())
                    <h3 class="card__name">{{$lang->name}}</h3>
                @endif
            @endforeach
            <div class="product__priceGroup">
                <i class="material-icons">monetization_on</i>
                <div class="caption">
                    @lang('home.common_bill'):
                </div>
                <div class="price">
                    ₴{{$restaurant->price}}
                </div>
            </div>
            <div class="product__priceGroup">
                <i class="material-icons">local_cafe</i>
                <div class="caption">
                    @lang('home.cup_coffee_price'):
                </div>
                <div class="price">
                    ₴{{$restaurant->opt_price}}
                </div>
            </div>
            {{--            <div class="product_bottom">--}}
            {{--                <div class="rating">--}}
            {{--                    <i class="material-icons active">star</i>--}}
            {{--                    <i class="material-icons active">star</i>--}}
            {{--                    <i class="material-icons active">star</i>--}}
            {{--                    <i class="material-icons active">star</i>--}}
            {{--                    <i class="material-icons">star</i>--}}
            {{--                </div>--}}
            {{--                21 отзыв <i class="material-icons">forum</i>--}}
            {{--            </div>--}}
        </div>
    </a>
</div>
