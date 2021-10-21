<div class="container">
    <div class="row">
        <div class="col s12">
            <h2 class="heading-2">Города</h2>
        </div>
        <div class="col s12">
            <div class="row">
                @foreach($cities as $item)
                    <div class="col">
                        <div class="card">
                            <div class="card-content">
                                <a style="color: #333333; font-size: 18px;" href="{{route('city-page', ['uri' => $item->uri ])}}">
                                    @foreach($item->langs as $lang)
                                        @if($lang->lang == app()->getLocale())
                                            {{$lang->heading}}
                                        @endif
                                    @endforeach
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
