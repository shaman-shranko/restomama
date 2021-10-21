<div class="productStartScreen hall @if($loop->iteration%2)odd @endif">
    <div class="container">
        <div class="row">
            <div class="col s12">
                @foreach($hall->languages as $lang)
                    @if($lang->language == app()->getLocale())
                        <h2 class="heading-2">{{ $lang->name }}</h2>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="menuSlider">
        @if(isset($hall->gallery->items))
            @foreach($hall->gallery->items as $item)
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
