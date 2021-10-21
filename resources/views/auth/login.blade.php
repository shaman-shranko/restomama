@extends('layouts.app')

@section('seo')
    <title>Вход</title>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m8 offset-m2">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">{{ __('Login') }}</span>
                    <div class="row">
                        <form class="col s12" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row">
                                <div class="input-field col s12">
                                    <input placeholder="" id="email" type="email" name="email" class="validate  @error('email') invalid @enderror" required autofocus>
                                    <label for="first_name">{{ __('E-Mail Address') }}</label>
                                </div>
                                <div class="input-field col s12">
                                    <input placeholder="" id="password" type="password" name="password" class="validate  @error('password') invalid @enderror" required autofocus>
                                    <label for="first_name">{{ __('Password') }}</label>
                                </div>
                                <div class="input-field col s12">
                                    <p>
                                        <label>
                                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                                            <span>{{ __('Remember Me') }}</span>
                                        </label>
                                    </p>
                                </div>
                                <div class="input-field col s12">
                                    <button type="submit" class="waves-effect waves-light btn">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="waves-effect waves-light btn" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
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
