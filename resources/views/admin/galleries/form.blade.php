@extends('layouts.account')
@section('seo')
    <title>@lang('management.galleries.page_title')</title>
@endsection
@section('styles')
    <style>
        td {
            vertical-align: top !important;
        }

        .loader-body {
            height: 10px;
            background: #eeeeee;
            border: 1px solid #0f9d58;
            overflow: hidden;
            width: 100%;
        }

        .loader-indicator {
            height: 100%;
            width: 100%;
            background: #0f9d58;
            transform: translateX(-100%);
            transition: transform .3s ease-out;
        }
    </style>
@endsection

@section('scripts')
    <script>
        let uploaded = 0;
        let errorUploaded = 0;
        $(document).ready(function () {
            $('#imagesForm').on('submit', function (e) {
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
        function uploadOne(token, file) {
            let data = new FormData();
            data.append('file', file);
            data.append('_token', token);
            $.ajax({
                url: '{{route('gallery.ajax_upload', ['id' => $restaurant->id])}}',
                data: data,
                async: true,
                contentType: false,
                processData: false,
                dataType: "JSON",
                type: "POST",
                beforeSend: function () {

                },
                complete: function () {

                },
                success: function (data) {
                    ++uploaded;
                    let position = 100 * (uploaded / $('#imagesForm').find('input[type="file"]')[0].files.length) - 100;
                    $('#loader .loader-indicator').css({'transform': 'translateX(' + position + '%)'});
                    if (uploaded === $('#imagesForm').find('input[type="file"]')[0].files.length) {
                        if (errorUploaded > 0) {
                            alert("Не загружено " + errorUploaded + " файлов. Проверьте размеры файлов и попробуйте еще раз.");
                        }
                        setTimeout(function () {
                            window.location = window.location.href;
                        }, 500);
                    } else {
                        uploadOne(token, $('#imagesForm').find('input[type="file"]')[0].files[uploaded]);
                    }
                },
                error: function (data) {
                    ++uploaded;
                    ++errorUploaded;
                    let position = 100 * (uploaded / $('#imagesForm').find('input[type="file"]')[0].files.length) - 100;
                    $('#loader .loader-indicator').css({'transform': 'translateX(' + position + '%)'});
                    if (uploaded === $('#imagesForm').find('input[type="file"]')[0].files.length) {
                        if (errorUploaded > 0) {
                            alert("Не загружено " + errorUploaded + " файлов. Проверьте размеры файлов и попробуйте еще раз.");
                        }
                        setTimeout(function () {
                            window.location = window.location.href;
                        }, 500);
                    } else {
                        uploadOne(token, $('#imagesForm').find('input[type="file"]')[0].files[uploaded]);
                    }
                }
            });
        }
    </script>
@endsection

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">
                @lang('management.galleries.restaurant_gallery')
                @foreach($restaurant->languages as $lang)
                    @if($lang->language == app()->getLocale())
                        {{$lang->name}}
                    @endif
                @endforeach
            </h1>
            <p>@lang('management.galleries.recommendation')</p>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <form id="imagesForm" class="col s12" method="post" enctype="multipart/form-data">
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
                                        <span>@lang('management.galleries.photo')</span>
                                        <input type="file" name="images[]" multiple>
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text"
                                               placeholder="@lang('management.galleries.upload_file')">
                                    </div>
                                </div>
                                <div class="col s12 right-align">
                                    <button class="btn waves-effect waves-light" type="submit">
                                        @lang('management.galleries.add')
                                        <i class="material-icons right">save</i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        @if(isset($restaurant->gallery))
                            <form id="infoTable"
                                  action="{{ route('gallery.update', ['id' => $restaurant->gallery_id]) }}"
                                  method="POST">
                                <div class="row">
                                    <div class="col s12 right-align">
                                        <button type="submit" class="btn">@lang('management.galleries.save')</button>
                                    </div>
                                    <div class="col s12">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @method('PATCH')
                                @csrf
                                <table class="responsive-table">
                                    <thead>
                                    <th>#</th>
                                    <th>@lang('management.galleries.image')</th>
                                    <th>@lang('management.galleries.info')</th>
                                    <th></th>
                                    </thead>
                                    <tbody>
                                    @foreach($restaurant->gallery->items as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                <img width="200" src="/{{$item->image->filepath}}" alt=""/>
                                            </td>
                                            <td style="width: 100%; padding: 0 15px;">
                                                @foreach(config('app.locales') as $locale)
                                                    <div class="input-field">
                                                        <input type="text"
                                                               id="items_{{$item->id}}_alt_{{$locale}}"
                                                               name="items[{{$item->id}}][{{$locale}}][alt]"
                                                               @foreach($item->langs as $lang)
                                                               @if($lang->lang == $locale)
                                                               value="{{$lang->alt}}"
                                                                @endif
                                                                @endforeach
                                                        />
                                                        <label for="items_{{$item->id}}_alt_{{$locale}}"
                                                               class="active">@lang('management.galleries.description')
                                                            ({{$locale}}) :</label>
                                                    </div>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{route('remove_gallery_item', ['id'=>$item->id])}}"
                                                   class="red-text lighten-1-text"><i
                                                            class="material-icons">close</i></a>
                                            </td>
                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
