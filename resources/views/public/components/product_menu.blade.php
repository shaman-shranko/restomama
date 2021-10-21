<div class="productStartScreen menu">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h2 class="heading-2">@lang('client.product.menu.menu')</h2>
            </div>
        </div>
    </div>
    <div class="menuSlider">
        @if(isset($restaurant->menu->items))
            @foreach($restaurant->menu->items as $item)
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
                            <div class="slider-caption">
                                <div class="slider-title">
                                    {{$lang->title}}
                                </div>
                                <div class="slider-subtitle">
                                    {{$lang->subtitle}}
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endforeach
        @endif
    </div>
</div>
