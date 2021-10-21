<div class="container product-list">
    @if($restaurants->count() > 0)
    <div class="row">
        @foreach($restaurants as $restaurant)
            @include('public.components.products_loop')
        @endforeach
    </div>
    <div class="row">
        {{ $restaurants->links() }}
    </div>
    @else
        <div class="row">
            <div class="col s12">
                @lang('client.search.empty')
            </div>
        </div>
    @endif
</div>
