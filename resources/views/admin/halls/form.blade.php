@extends('layouts.account')
@section('seo')
    <title>@lang('management.halls.page_title')</title>
@endsection
@section('styles')
    <style>
        td{
            vertical-align: top!important;
        }
        .loader-body{
            height: 10px;
            background: #eeeeee;
            border: 1px solid #0f9d58;
            overflow: hidden;
            width: 100%;
        }
        .loader-indicator{
            height: 100%;
            width: 100%;
            background: #0f9d58;
            transform: translateX(-100%);
            transition: transform .3s ease-out;
        }
    </style>
@endsection

@section('scripts')
    @if(isset($hall))
        <script>
            let uploaded = 0;
            let errorUploaded = 0;
            $(document).ready(function(){
                $('#imagesForm').on('submit', function(e){
                    e.preventDefault();
                    let that = $(this);
                    let images = that.find('input[type="file"]')[0].files;
                    uploaded = 0;
                    errorUploaded = 0;
                    let loader = '<div id="loader" class="row loader"><div class="loader-body"><div class="loader-indicator"></div></div><div>';
                    that.append(loader);
                    that.find(':input').attr('disabled', true);

                    uploadOne(that.find('input[name="_token"]').val(), images[uploaded]);

                });
            });
            function uploadOne(token, file){
                let data = new FormData();
                data.append('file', file);
                data.append('_token', token);
                $.ajax({
                    url: '{{route('halls.ajax_upload', ['id' => $hall->id])}}',
                    data: data,
                    async: true,
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    type: "POST",
                    beforeSend: function(){

                    },
                    complete: function(){

                    },
                    success: function(data){
                        ++uploaded;
                        let position = 100*(uploaded/$('#imagesForm').find('input[type="file"]')[0].files.length) - 100;
                        $('#loader .loader-indicator').css({'transform': 'translateX('+position+'%)'});
                        if(uploaded === $('#imagesForm').find('input[type="file"]')[0].files.length){
                            if(errorUploaded > 0){
                                alert("Не загружено "+errorUploaded+" файлов. Проверьте размеры файлов и попробуйте еще раз.");
                            }
                            setTimeout(function(){
                                window.location = window.location.href;
                            }, 500);
                        }else{
                            uploadOne(token, $('#imagesForm').find('input[type="file"]')[0].files[uploaded]);
                        }
                    },
                    error: function(data){
                        ++uploaded;
                        ++errorUploaded;
                        let position = 100*(uploaded/$('#imagesForm').find('input[type="file"]')[0].files.length) - 100;
                        $('#loader .loader-indicator').css({'transform': 'translateX('+position+'%)'});
                        if(uploaded === $('#imagesForm').find('input[type="file"]')[0].files.length){
                            if(errorUploaded > 0){
                                alert("Не загружено "+errorUploaded+" файлов. Проверьте размеры файлов и попробуйте еще раз.");
                            }
                            setTimeout(function(){
                                window.location = window.location.href;
                            }, 500);
                        }else{
                            uploadOne(token, $('#imagesForm').find('input[type="file"]')[0].files[uploaded]);
                        }
                    }
                });
            }
        </script>
    @endif
@endsection

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">
                @if(isset($hall))
                    @foreach($hall->languages as $lang)
                        @if($lang->language == app()->getLocale())
                            {{$lang->name}}
                        @endif
                    @endforeach
                @else
                    @foreach($restaurant->languages as $lang)
                        @if($lang->language == app()->getLocale())
                            {{$lang->name}}. @lang('management.halls.new_hall')
                        @endif
                    @endforeach
                @endif
            </h1>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        @if(isset($hall))
                            <form class="col s12" id="imagesForm" method="get" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <ul class="col s-12">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="row">
                                    <div class="file-field input-field col s12">
                                        <div class="btn">
                                            <span>@lang('management.halls.photo')</span>
                                            <input type="file" name="images[]" multiple required>
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text" placeholder="@lang('management.halls.files_upload')"/>
                                        </div>
                                    </div>
                                    <div class="col s12 right-align">
                                        <button class="btn waves-effect waves-light" type="submit">
                                            @lang('management.halls.add_images')
                                            <i class="material-icons right">save</i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <form class="col s12" action="{{ route('halls.update', ['id' => $hall->id]) }}" method="POST">
                                @method('PATCH')
                        @else
                            <form class="col s12" action="{{ route('halls.store', ['id' => $restaurant->id]) }}" method="POST">
                        @endif
                            @csrf
                            <div class="row">
                                <div class="col s12 right-align">
                                    <button type="submit" class="btn">@lang('management.halls.save')</button>
                                </div>
                                <div class="col s12">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                @foreach(config('app.locales') as $locale)
                                    @if(isset($hall))
                                        @foreach($hall->languages as $lang)
                                            @if($lang->language == $locale)
                                                <div class="input-field col s12">
                                                    <input type="text" name="name[{{$locale}}]" id="name_{{$locale}}"  value="{{$lang->name}}" required>
                                                    <label for="name_{{$locale}}" class="active">@lang('management.halls.title') ({{$locale}})</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="input-field col s12">
                                            <input type="text" name="name[{{$locale}}]" id="name_{{$locale}}" required>
                                            <label for="name_{{$locale}}" class="active">@lang('management.halls.title') ({{$locale}})</label>
                                        </div>
                                    @endif
                                @endforeach

                                <div class="input-field col s12">
                                    <input type="number" name="capacity" id="capacity" @if(isset($hall)) value="{{$hall->capacity}}" @endif required>
                                    <label class="active" for="capacity">@lang('management.halls.count')</label>
                                </div>
                                <div class="input-field col s12">
                                    <input type="number" name="sorting" id="sorting" @if(isset($hall)) value="{{$hall->sorting}}" @endif required>
                                    <label class="active" for="sorting">@lang('management.halls.order')</label>
                                </div>
                                <div class="input-field col s12">
                                    <select name="type" class="validate" required>
                                        <option value="" disabled selected>@lang('management.halls.choose_type')</option>
                                        <option value="halls" @if(isset($hall) && $hall->type == 'halls') selected @endif>@lang('management.halls.hall')</option>
                                        <option value="open_air" @if(isset($hall) && $hall->type == 'open_air') selected @endif>@lang('management.halls.open_air')</option>
                                        <option value="hotel" @if(isset($hall) && $hall->type == 'hotel') selected @endif>@lang('management.halls.hotel')</option>
                                    </select>
                                    <label>@lang('management.halls.location_type'):</label>
                                </div>
                                <div class="input-field col s6 m3">
                                    <label>
                                        <input type="checkbox" class="filled-in" name="is_active" @if(isset($hall) && $hall->active) checked @endif/>
                                        <span>@lang('management.halls.publicate')</span>
                                    </label>
                                </div>
                                <div class="col s12" style="height: 50px"></div>
                            </div>
                            @if(isset($hall))
                                <table class="responsive-table">
                                    <thead>
                                    <th>#</th>
                                    <th>@lang('management.halls.image')</th>
                                    <th>@lang('management.halls.info')</th>
                                    <th></th>
                                    </thead>
                                    <tbody>
                                    @if(isset($hall->gallery))
                                        @foreach($hall->gallery->items as $item)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>
                                                    <img width="200" src="/{{$item->image->filepath}}" alt=""/>
                                                </td>
                                                <td style="width: 100%; padding: 0 15px;">
                                                    @foreach(config('app.locales') as $locale)
                                                        <div class="input-field">
                                                            <input type="text"
                                                                   id="items_{{$item->id}}_title_{{$locale}}"
                                                                   name="items[{{$item->id}}][{{$locale}}][title]"
                                                                   @foreach($item->langs as $lang)
                                                                   @if($lang->lang == $locale)
                                                                   value="{{$lang->title}}"
                                                                @endif
                                                                @endforeach
                                                            />
                                                            <label for="items_{{$item->id}}_title_{{$locale}}" class="active">@lang('management.halls.heading') ({{$locale}}) :</label>
                                                        </div>
                                                        <div class="input-field">
                                                            <input type="text"
                                                                   id="items_{{$item->id}}_subtitle_{{$locale}}"
                                                                   name="items[{{$item->id}}][{{$locale}}][subtitle]"
                                                                   @foreach($item->langs as $lang)
                                                                   @if($lang->lang == $locale)
                                                                   value="{{$lang->subtitle}}"
                                                                @endif
                                                                @endforeach
                                                            />
                                                            <label for="items_{{$item->id}}_subtitle_{{$locale}}" class="active">@lang('management.halls.subheading') ({{$locale}}) :</label>
                                                        </div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <a href="{{route('remove_gallery_item', ['id'=>$item->id])}}" class="red-text lighten-1-text"><i class="material-icons">close</i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
