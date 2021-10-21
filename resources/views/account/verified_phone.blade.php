@extends('layouts.app')

@section('seo')
    <title>Подтверждение номера телефона</title>
@endsection

@section('scripts')
    <script src="{{ asset('app/js/jquery.maskedinput.min.js') }}" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            jQuery(function($){
                $('#code').mask('9999');
            });

            $('.resend_code').click(function(event){
                event.preventDefault();
                let href = $(this).attr('href');
                console.log(href);
            });
        });
    </script>
@endsection
@section('styles')
    <style>
        .verification_code{
            font-size: 50px!important;
            width: 170px!important;
            text-align: center!important;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title center-align">Пожалуйста, введите код из смс, отправленный на Ваш номер. ({{ auth()->user()->phone }})</span>
                        <div class="row">
                            <form class="col s12" method="POST" action=" {{ route('check_verification') }} ">
                                @csrf
                                <div class="row">
                                    <div class="input-field col s6 offset-s3 center-align">
                                        <input placeholder="____" id="code" type="text" name="code" class="verification_code validate  @error('code') invalid @enderror" required autofocus>
                                    </div>
                                    <div class="input-field col s6 offset-s3 center-align">
                                        <button type="submit" class="waves-effect waves-light btn">
                                            Подтвердить
                                        </button>
                                    </div>
{{--                                    <div class="input-field col s6 offset-s3 center-align">--}}
{{--                                        <a class="resend_code" href="{{ route('send_verification') }}">--}}
{{--                                            Заново отправить код подтверждения--}}
{{--                                        </a><br/>--}}
{{--                                        <a href="#">--}}
{{--                                            Ошиблись при вводе номера телефона?--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
