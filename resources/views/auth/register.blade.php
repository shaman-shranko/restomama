@extends('layouts.app')

@section('seo')
    <title>Регистрация</title>
@endsection

@section('scripts')
    <script src="{{ asset('app/js/jquery.maskedinput.min.js') }}" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            jQuery(function($){
                $('#phone').mask('+38(999)999-99-99');
            });
        });
    </script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m8 offset-m2">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">{{ __('Register') }}</span>

                    <div class="row">
                        <form class="col s12" method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="name">{{ __('Name') }}</label>

                                    <input id="name" type="text" class="validate @error('name') invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="input-field col s12">
                                    <label for="surname">Фамилия</label>

                                    <input id="surname" type="text" class="validate @error('surname') invalid @enderror" name="surname" value="{{ old('surname') }}" required autocomplete="surname">

                                    @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="input-field col s12">
                                    <label for="phone">Телефон</label>

                                    <input id="phone" type="text" class="validate @error('phone') invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="input-field col s12">
                                    <label for="email">{{ __('E-Mail Address') }}</label>

                                    <input id="email" type="email" class="validate @error('email') invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="input-field col s12">
                                    <label for="password">{{ __('Password') }}</label>

                                    <input id="password" type="password" class="validate @error('password') invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="input-field col s12">
                                    <label for="password_confirm">{{ __('Confirm Password') }}</label>
                                    <input id="password_confirm" type="password" name="password_confirmation" required autocomplete="new-password">
                                </div>

                                <div class="input-field col s12">
                                    <button type="submit" class="btn">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
