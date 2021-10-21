@extends('layouts.account')
@section('seo')
    <title>@lang('management.restaurants.form.page_title')</title>
@endsection
@section('scripts')
@include('admin.components.tinymce_script')
@endsection

@section('main')
<div class="row">
    <div class="col s12">
        <h1 class="flow-text">
            @if(isset($restaurant_lang) && isset($restaurant_lang[app()->getLocale()]))
            {{ $restaurant_lang[app()->getLocale()]['name'] }}
            @else
                @lang('management.restaurants.form.new_restaurant')
            @endif
        </h1>
        <div class="card">
            <div class="card-content">
                <div class="row">
                    @if(isset($restaurant))
                    <form class="col s12" method="post" enctype="multipart/form-data"
                        action="{{ route('restaurants.update', ['id' => $restaurant->id]) }}">
                        @method('PATCH')
                        @else
                        <form class="col s12" method="post" enctype="multipart/form-data"
                            action="{{ route('restaurants.store') }}">
                            @endif
                            @csrf
                            <div class="row">
                                <div class="col s12 right-align">
                                    <button class="btn waves-effect waves-light" type="submit">
                                        @lang('management.restaurants.form.save')
                                        <i class="material-icons right">save</i>
                                    </button>
                                </div>
                            </div>
                            @if ($errors->count() > 0)
                            <div class="row">
                                <ul class="col s-12">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col s12">
                                    <ul class="tabs">
                                        @foreach(config('app.locales') as $key => $lang)
                                        <li class="tab col s3"><a @if($key==0) class="active" @endif
                                                href="#{{ $lang }}">{{ $lang }}</a></li>
                                        @endforeach
                                        <li class="tab col s3"><a href="#settings">@lang('management.restaurants.form.settings')</a></li>
                                        <li class="tab col s3"><a href="#characteristics">@lang('management.restaurants.form.chars')</a></li>
                                    </ul>
                                </div>

                                @foreach(config('app.locales') as $lang)
                                <div id="{{$lang}}" class="col s12">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input @if(isset($restaurant_lang))
                                                value="{{ $restaurant_lang[$lang]['name']}}" @endif
                                                id="description_{{$lang}}" name="langs[{{ $lang }}][name]" type="text"
                                                class="validate  @error('langs['.$lang.'][name]') invalid @enderror"
                                                required>
                                            <label class="active" for="description_{{$lang}}">@lang('management.restaurants.form.heading')</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input @if(isset($restaurant_lang))
                                                value="{{$restaurant_lang[$lang]['seo_title']}}" @endif
                                                id="seo_title_{{$lang}}" name="langs[{{$lang}}][seo_title]" type="text"
                                                class="validate  @error('surname') invalid @enderror" required>
                                            <label class="active" for="seo_title_{{$lang}}">SEO title</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea id="seo_description_{{$lang}}"
                                                name="langs[{{$lang}}][seo_description]" type="text"
                                                class="materialize-textarea validate  @error('surname') invalid @enderror">@if(isset($restaurant_lang)){{$restaurant_lang[$lang]['seo_description']}}@endif</textarea>
                                            <label class="active" for="seo_description_{{$lang}}">SEO
                                                description</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <label>
                                                @lang('management.restaurants.form.text')
                                            </label>
                                            <textarea id="content_{{$lang}}" name="langs[{{$lang}}][seo_text]"
                                                hidden>@if(isset($restaurant_lang)){{$restaurant_lang[$lang]['seo_text']}}@endif</textarea>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div id="settings" class="col s12">
                                    <div class="row">
                                        <div class="input-field col s12 m6">
                                            <input @if(isset($restaurant)) value="{{$restaurant->uri}}" @endif id="uri"
                                                name="uri" type="text" class="validate  @error('uri') invalid @enderror"
                                                required>
                                            <label class="active" for="uri">URI</label>
                                        </div>
                                        <div class="input-field col s6 m3">
                                            <input @if(isset($restaurant)) value="{{$restaurant->sorting}}" @else
                                                value="0" @endif id="sorting" name="sorting" type="number"
                                                class="validate  @error('surname') invalid @enderror" required>
                                            <label class="active" for="sorting">@lang('management.restaurants.form.order_sort')</label>
                                        </div>
                                        <div class="input-field col s6 m3">
                                            <label>
                                                <input type="checkbox" class="filled-in" name="is_active"
                                                    @if(isset($restaurant) && $restaurant->active) checked @endif/>
                                                <span>@lang('management.restaurants.form.publicate')</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="file-field input-field col s12 m6">
                                            <div class="btn">
                                                <span>Фото</span>
                                                <input type="file" name="image">
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate" type="text" @if(isset($restaurant))
                                                    value="{{$restaurant->images_id}}" @endif
                                                    placeholder="@lang('management.restaurants.form.file_upload')">
                                            </div>
                                        </div>
                                        <div class="input-field col s12 m6">
                                            <input type="text" id="video" name="video" @if(isset($restaurant))
                                                value="{{$restaurant->video}}" @endif class="validate" />
                                            <label class="active" for="video">@lang('management.restaurants.form.video_link')</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12 m6">
                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <input @if(isset($restaurant)) value="{{$restaurant->price}}" @endif
                                                        id="price" name="price" type="number" step="1"
                                                        class="validate  @error('price') invalid @enderror" required>
                                                    <label class="active" for="price">@lang('management.restaurants.form.table_deposit')</label>
                                                </div>
                                                <div class="input-field col s12">
                                                    <input @if(isset($restaurant)) value="{{$restaurant->opt_price}}"
                                                        @endif id="opt_price" name="opt_price" type="number" step="1"
                                                        class="validate  @error('opt_price') invalid @enderror"
                                                        required>
                                                    <label class="active" for="opt_price">@lang('management.restaurants.form.coffee_price')</label>
                                                </div>
                                                <div class="input-field col s12">
                                                    <input @if(isset($restaurant)) value="{{$restaurant->capacity}}"
                                                        @endif id="capacity" name="capacity" type="number" step="1"
                                                        class="validate  @error('capacity') invalid @enderror" required>
                                                    <label class="active" for="capacity">@lang('management.restaurants.form.max_size')</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6">
                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <select name="city" required
                                                        class="@error('city') invalid @enderror">
                                                        <option value="" disabled @if(!isset($restaurant)) selected
                                                            @endif>@lang('management.restaurants.form.choose_city')</option>
                                                        @foreach($cities as $city)
                                                            @foreach($city->languages as $lang)
                                                                @if($lang->language == app()->getLocale())
                                                                    <option value="{{ $city->id }}" @if(isset($restaurant) &&
                                                                        $city->id == $restaurant->cities_id) selected
                                                                        @endif>{{$lang->name}}</option>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                    <label>@lang('management.restaurants.form.city'):</label>
                                                </div>
                                                <div class="input-field col s12">
                                                    <select name="types[]" required multiple
                                                        class="@error('types') invalid @enderror">
                                                        <option value="" disabled @if(!isset($restaurant)) selected @endif>@lang('management.restaurants.form.choose_type')</option>
                                                        @foreach($types as $type)
                                                            @if(isset($restaurant))
                                                                @foreach($type->languages as $lang)
                                                                    @if($lang->language == app()->getLocale())
                                                                        @if($restaurant->types->contains($type))
                                                                            <option value="{{ $type->id }}" selected>{{$lang->name}}</option>
                                                                        @else
                                                                            <option value="{{ $type->id }}">{{$lang->name}}</option>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                @foreach($type->languages as $lang)
                                                                    @if($lang->language == app()->getLocale())
                                                                        <option value="{{ $type->id }}">{{$lang->name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <label>@lang('management.restaurants.form.type'):</label>
                                                </div>
                                                <div class="input-field col s12">
                                                    <select name="kitchens[]" multiple
                                                        class="@error('kitchens') invalid @enderror">
                                                        <option value="" disabled @if(!isset($restaurant)) selected
                                                            @endif>@lang('management.restaurants.form.choose_cuisine')</option>
                                                        @if(isset($restaurant) && $restaurant->kitchens->count())
                                                            @foreach($kitchens as $kitchen)
                                                                @foreach($kitchen->languages as $lang)
                                                                    @if($lang->language == app()->getLocale())
                                                                        @if($restaurant->kitchens->contains($kitchen))
                                                                            <option value="{{ $kitchen->id }}" selected>{{$lang->name}}
                                                                            </option>
                                                                        @else
                                                                            <option value="{{ $kitchen->id }}">{{$lang->name}}</option>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        @else
                                                            @foreach($kitchens as $kitchen)
                                                                @foreach($kitchen->languages as $lang)
                                                                    @if($lang->language == app()->getLocale())
                                                                        <option value="{{ $kitchen->id }}">{{$lang->name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <label>@lang('management.restaurants.form.cuisine'):</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="characteristics" class="col s12">
                                    <div class="row">
                                        <div class="col s12">
                                            <span style="font-weight: bold">Адрес:</span>
                                        </div>
                                        @foreach(config('app.locales') as $lang)
                                        <div class="input-field col s12">
                                            <input @if(isset($restaurant_lang))
                                                value="{{ $restaurant_lang[$lang]['address'] }}" @endif
                                                id="address_{{$lang}}" name="langs[{{$lang}}][address]" type="text"
                                                class="validate @error('langs['.$lang.'][address]') invalid @enderror" />
                                            <label class="active" for="address_{{$lang}}">@lang('management.restaurants.form.address') ({{$lang}}):</label>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <span style="font-weight: bold">@lang('management.restaurants.form.gifts'):</span>
                                        </div>
                                        <div class="input-field col s12">
                                            <label style="position: relative;">
                                                <input type="checkbox" class="filled-in" name="gift"
                                                    @if(isset($restaurant) && $restaurant->gift) checked @endif/>
                                                <span>@lang('management.restaurants.form.has_gifts')</span>
                                            </label>
                                        </div>
                                        @foreach(config('app.locales') as $lang)
                                        <div class="input-field col s12">
                                            @if(isset($restaurant_lang))
                                            <textarea id="gift_text_{{$lang}}" name="langs[{{ $lang }}][gift_text]"
                                                class="materialize-textarea validate  @error('langs['.$lang.'][gift_text]') invalid @enderror">{{ $restaurant_lang[$lang]['gift_text']}}</textarea>
                                            @else
                                            <textarea id="gift_text_{{$lang}}" name="langs[{{ $lang }}][gift_text]"
                                                class="materialize-textarea validate  @error('langs['.$lang.'][gift_text]') invalid @enderror"></textarea>
                                            @endif
                                            <label class="active" for="gift_text_{{$lang}}">@lang('management.restaurants.form.gift_text')
                                                ({{$lang}})</label>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <span style="font-weight: bold">@lang('management.restaurants.form.schedule'):</span>
                                        </div>
                                        @foreach(config('app.locales') as $lang)
                                        <div class="input-field col s12">
                                            @if(isset($restaurant_lang))
                                            <textarea id="shedule_{{$lang}}" name="langs[{{ $lang }}][schedule]"
                                                class="materialize-textarea validate">{{ $restaurant_lang[$lang]['schedule']}}</textarea>
                                            @else
                                            <textarea id="shedule_{{$lang}}" name="langs[{{ $lang }}][schedule]"
                                                class="materialize-textarea validate"></textarea>
                                            @endif
                                            <label for="shedule_{{$lang}}" class="active">@lang('management.restaurants.form.schedule')
                                                ({{$lang}}):</label>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <span style="font-weight: bold">@lang('management.restaurants.form.discount'):</span>
                                        </div>
                                        @foreach(config('app.locales') as $lang)
                                        <div class="input-field col s12">
                                            @if(isset($restaurant_lang))
                                            <textarea id="discount_{{$lang}}" name="langs[{{ $lang }}][discount]"
                                                class="materialize-textarea validate">{{ $restaurant_lang[$lang]['discount']}}</textarea>
                                            @else
                                            <textarea id="discount_{{$lang}}" name="langs[{{ $lang }}][discount]"
                                                class="materialize-textarea validate"></textarea>
                                            @endif
                                            <label for="discount_{{$lang}}" class="active">@lang('management.restaurants.form.discount') ({{$lang}}):</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection