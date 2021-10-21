@extends('layouts.account')

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">
                {{ $event_langs[app()->getLocale()]['restaurant'] }} ->
                {{ $event_langs[app()->getLocale()]['name'] }} ->
                {{ isset($event_langs[app()->getLocale()]['gallery']) ? $event_langs[app()->getLocale()]['gallery'] : 'Новая галлерея'}}
            </h1>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        @if(isset($gallery))
                            <form class="col s12" id="imagesForm" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <ul class="col s12">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <div class="file-field input-field col s12">
                                        <div class="btn">
                                            <span>Фото</span>
                                            <input type="file" name="images[]" multiple required>
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text" placeholder="Загрузите один или несколько файлов"/>
                                        </div>
                                    </div>
                                    <div class="col s12 right-align">
                                        <button class="btn waves-effect waves-light" type="submit">
                                            Добавить изображения
                                            <i class="material-icons right">save</i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <form class="col s12" action="{{ route('event_gallery.update', ['id' => $gallery->id]) }}" method="POST">
                            @method('PATCH')
                        @else
                            <form class="col s12" action="{{ route('event_gallery.store', ['id' => $event->id]) }}" method="POST">
                        @endif
                            @csrf
                            <div class="row">
                                <div class="col s12 right-align">
                                    <button type="submit" class="btn">Сохранить</button>
                                </div>
                                <div class="col s12">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @foreach(config('app.locales') as $locale)
                                <div class="input-field col s12">
                                    <input type="text" name="name[{{$locale}}]" id="name_{{$locale}}" required>
                                    <label for="name_{{$locale}}" class="active">Название ({{$locale}})</label>
                                </div>
                            @endforeach
                            @if(isset($items) && $items->count() > 0)
                                <table class="responsive-table">
                                    <thead>
                                    <th>#</th>
                                    <th>Изображение</th>
                                    <th>Информация</th>
                                    <th></th>
                                    </thead>
                                    <tbody>
                                        @foreach($items as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <img width="200" src="/{{ $item->image->filepath }}" alt=""/>
                                                </td>
                                                <td style="width: 100%; padding: 0 15px;">
                                                    @foreach(config('app.locales') as $locale)
                                                        <div class="input-field">
                                                            <input type="text"
                                                                   id="items_{{ $item->id }}_title_{{ $locale }}"
                                                                   name="items[{{ $item->id }}][{{ $locale }}][title]"
                                                                   @if(isset($items_langs[$item->id][$locale]['title'])) value="{{ $items_langs[$item->id][$locale]['title'] }}" @endif/>
                                                            <label for="items_{{ $item->id }}_title_{{ $locale }}">
                                                                Заголовок ({{ $locale }}) :
                                                            </label>
                                                        </div>
                                                        <div class="input-field">
                                                            <input type="text"
                                                                   id="items_{{ $item->id }}_subtitle_{{ $locale }}"
                                                                   name="items[{{ $item->id }}][{{ $locale }}][title]"
                                                                   @if(isset($items_langs[$item->id][$locale]['subtitle'])) value="{{ $items_langs[$item->id][$locale]['subtitle'] }}" @endif/>
                                                            <label for="items_{{ $item->id }}_subtitle_{{ $locale }}">
                                                                Описание ({{ $locale }}) :
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <a href="{{ route('remove_gallery_item', ['id' => $item->id]) }}" class="red-text lighten-1-text">
                                                        <i class="material-icons">close</i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
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
    @if(isset($gallery))
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
                    url: '{{route('event_gallery.ajax_upload', ['id' => $gallery->id])}}',
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
