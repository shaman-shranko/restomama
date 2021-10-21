<div class="productStartScreen">
    <div class="productSlider">
        @if(isset($restaurant->gallery))
            @foreach($restaurant->gallery->items as $item)
                @php
                    $sizesSet = \App\Http\Controllers\Admin\ImageController::imageResponsive($item->image, config('image.sizes.fullwidth'));
                @endphp
                @foreach($item->langs as $lang)
                    @if($lang->lang == app()->getLocale())
                        <div class="productSlider__item">
                            <img class="img-responsive"
                                 src="{{$sizesSet['src']}}"
                                 srcset="{{$sizesSet['srcset']}}"
                                 alt="{{$lang->alt}}"/>
                        </div>
                    @endif
                @endforeach
            @endforeach
        @else
            @php
                $sizesSet = \App\Http\Controllers\Admin\ImageController::imageResponsive($restaurant->image, config('image.sizes.fullwidth'));
            @endphp
            <div class="productSlider__item">
                <img class="img-responsive responsively-lazy" src="{{$sizesSet['src']}}"
                     data-srcset="{{$sizesSet['srcset']}}" alt=""/>
            </div>
        @endif
    </div>
    <div class="productStartScreen__card slider_card">
        @foreach($restaurant->languages as $lang)
            @if($lang->language == app()->getLocale())
                <h1 class="heading-1">{{$lang->name}}</h1>
            @endif
        @endforeach

        {{--        <div class="product_bottom">--}}
        {{--            <div class="rating">--}}
        {{--                <i class="material-icons active">star</i>--}}
        {{--                <i class="material-icons active">star</i>--}}
        {{--                <i class="material-icons active">star</i>--}}
        {{--                <i class="material-icons active">star</i>--}}
        {{--                <i class="material-icons">star</i>--}}
        {{--            </div>--}}
        {{--            21 отзыв <i class="material-icons">forum</i>--}}
        {{--        </div>--}}
        <div class="product__priceGroup">
            <div class="caption">
                @lang('client.product.home.deposit'):
            </div>
            <div class="price">
                ₴{{$restaurant->price}}
            </div>
        </div>
    </div>
</div>
