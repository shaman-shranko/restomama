@extends('layouts.account')
@section('seo')
    <title>@lang('management.images.page_title')</title>
@endsection
@section('scripts')
    <script>
        let imagesTotal = {{$images_count}} - {{$images_resized}};
        let imagesCount = 0;
        $(document).ready(function(){
            $('#create').click(function(e){
                e.preventDefault();
                let form = $('#img_resize');
                if(imagesCount < imagesTotal){
                    resizeOne(form.find('input[name="_token"]').val());
                }
            });
            $('#clear').click(function(e){
                e.preventDefault();

                let form = $('#img_resize');
                let data = new FormData();

                data.append('_token', form.find('input[name="_token"]').val());

                $.ajax({
                    url: '{{route('clean-resizes')}}',
                    async: true,
                    data: data,
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    type: "POST",
                    beforeSend: function(){
                        blockForm();
                    },
                    complete: function(){
                        unblockForm();
                    },
                    success: function(data){
                        alert('Очищено');
                    }
                });
            });
            $('#fix').click(function(e){
                e.preventDefault();

                let form = $('#img_resize');
                let data = new FormData();

                data.append('_token', form.find('input[name="_token"]').val());
                $.ajax({
                    url: '{{route('remove-wrong')}}',
                    async: true,
                    data: data,
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    type: "POST",
                    beforeSend: function(){
                        blockForm();
                    },
                    complete: function(){
                        unblockForm();
                    },
                    success: function(data){
                        alert('Исправлено');
                    }
                });
            });
            function blockForm() {
                $('#img_resize :input').attr('disabled');
            }
            function unblockForm() {
                $('#img_resize :input').removeAttr('disabled');
            }

            function resizeOne(token){
                let data = new FormData();
                data.append('_token', token);
                $.ajax({
                    url: '{{route('resize-one')}}',
                    async: true,
                    data: data,
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    type: "POST",
                    beforeSend: function(){
                        blockForm();
                    },
                    complete: function(){
                        unblockForm();
                    },
                    success: function(data){
                        ++imagesCount;
                        console.log(data);
                        let position = 100*(imagesCount/imagesTotal) - 100;
                        $('.indicator__line').css({'transform': 'translateX('+position+'%)'});
                        if(imagesCount === imagesTotal){
                            alert('Все сделано')
                        }else{
                            resizeOne(token);
                        }
                    }
                });
            }
        });

    </script>
@endsection

@section('styles')
    <style>
        .indicator{
            display: block;
            width: 100%;
            height: 5px;
            margin-top: 30px;
            overflow: hidden;
        }
        .indicator__line{
            display: block;
            width: 100%;
            height: 100%;
            background: #0f9d58;
            transform: translateX(-100%);
        }
    </style>
@endsection

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">
                @lang('management.images.title')
            </h1>
            <div class="card">
                <div class="card-content">
                    <div>
                        @lang('management.images.images_count') <span style="font-weight: bold">{{$images_count}}</span>
                    </div>
                    <div>
                        @lang('management.images.reworked_count') <span style="font-weight: bold">{{$images_resized}}</span>
                    </div>
                    <div>
                        @lang('management.images.need_rework') <span style="font-weight: bold">{{$images_count - $images_resized}}</span>
                    </div>
                    <div>
                        @lang('management.images.problems_gallery') <span style="font-weight: bold">{{$wrong_gallery_images}}</span>
                    </div>
                    <div>
                        @lang('management.images.problems_restaurant') <span style="font-weight: bold">{{$wrong_thumb_images}}</span>
                    </div>
                    <form id="img_resize" style="margin-top: 30px;" method="post">
                        @csrf
                        <div class="input-field">
                            <button id="clear" type="submit" class="btn waves-effect waves-light">@lang('management.images.clear_mins')</button>
                        </div>
                        <div class="input-field">
                            <button id="create" type="submit" class="btn waves-effect waves-light">@lang('management.images.create_mins')</button>
                        </div>
                        <div class="input-field">
                            <button id="fix" type="submit" class="btn waves-effect waves-light">@lang('management.images.remove_problems')</button>
                        </div>
{{--                        <div class="input-field">--}}
{{--                            <button type="submit" class="btn waves-effect waves-light">Создать миниатюры</button>--}}
{{--                        </div>--}}
                    </form>
                    <div class="indicator">
                        <div class="indicator__line"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
