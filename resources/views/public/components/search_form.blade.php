<section class="searchForm">
    <div class="container">
        <div class="row">
            <form class="card-panel" action="{{route('filter', ['city_uri'=>$city_uri])}}" method="get">
                <div class="row">
                    <div class="input-field col l3">
                        <i class="material-icons prefix">event</i>
                        <input type="text" id="date" class="datepicker" @if(isset($date)) value="{{$date}}" @endif name="date" disabled>
                        <label for="date" class="active">@lang('client.search.date')</label>
                    </div>
                    <div class="input-field col l3">
                        <i class="material-icons prefix">people</i>
                        <input type="number" name="quantity" id="quantity" @if(isset($quantity)) value="{{$quantity}}" @endif/>
                        <label for="quantity" class="active">@lang('client.search.count')</label>
                    </div>
                    <div class="input-field col l3">
                        <i class="material-icons prefix">pie_chart</i>
                        <select name="type">
                            <option value="all" @if(!isset($type)) selected @endif>@lang('client.search.all_restaurants')</option>
                            @foreach($types as $f_type)
                                @foreach($f_type->languages as $lang)
                                    @if($lang->language == app()->getLocale())
                                        <option value="{{$f_type->id}}" @if(isset($type) && $f_type->id == $type) selected @endif>{{$lang->name}}</option>
                                    @endif
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="input-field col l3">
                        <button type="submit" value="submit" class="btn">@lang('client.search.show')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

