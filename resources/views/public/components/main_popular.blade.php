<div class="container product-list">
    <div class="row">
        <div class="col s12">
            <h2 class="heading-2">@lang('home.popular_restaurants')</h2>
        </div>
    </div>
    <div class="row">
        @foreach($popular as $restaurant)
            @include('public.components.products_loop')
        @endforeach
    </div>
</div>
