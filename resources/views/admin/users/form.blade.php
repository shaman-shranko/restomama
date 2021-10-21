@extends('layouts.account')
@section('seo')
    <title>@lang('management.users.form.page_title')</title>
@endsection
@section('scripts')
    <script src="{{ asset('admin/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        @foreach(config('app.locales') as $key => $lang)
        tinymce.init({
            selector:'#content_{{$lang}}',
            height: 500
        });
        @endforeach
    </script>
@endsection

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">
                @if(isset($user))
                    @lang('management.users.form.user') {{ $user->surname }} {{ $user->name }}
                @else
                    @lang('management.users.form.new_user')
                @endif
            </h1>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        @if(isset($user))
                            <form class="col s12" method="post" action="{{ route('users.update', ['id' => $user->id]) }}">
                                @method('PATCH')
                        @else
                            <form class="col s12" method="post" action="{{ route('users.store') }}">
                        @endif
                            @csrf
                            <div class="row">
                                <ul class="col s-12">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">account_circle</i>
                                    <input @if(isset($user->surname)) value="{{ $user->surname }}" @endif id="surname" name="surname" type="text" class="validate  @error('surname') invalid @enderror" required>
                                    <label class="active" for="surname">@lang('management.users.form.surname')</label>
                                </div>
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">account_circle</i>
                                    <input @if(isset($user->name)) value="{{ $user->name }}" @endif id="name" name="name" type="text" class="validate  @error('name') invalid @enderror" required>
                                    <label class="active" for="name">@lang('management.users.form.name')</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">email</i>
                                    <input @if(isset($user->email)) value="{{ $user->email }}" @endif id="email" name="email" type="email" class="validate  @error('email') invalid @enderror" required>
                                    <label class="active" for="email">E-mail</label>
                                </div>
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">fingerprint</i>
                                    <select name="role_id[]" required multiple class="@error('role') invalid @enderror">

                                        @foreach($roles as $role)
                                            @if(isset($user) && $user->roles->contains($role))
                                                <option value="{{ $role->id }}" selected>{{ $role->alias }}</option>
                                            @else
                                                <option value="{{ $role->id }}">{{ $role->alias }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <label>@lang('management.users.form.role')</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">local_phone</i>
                                    <input @if(isset($user->phone)) value="{{ $user->phone }}" @endif id="phone" name="phone" type="tel" class="validate  @error('phone') invalid @enderror" required>
                                    <label class="active" for="phone">@lang('management.users.form.phone')</label>
                                </div>
{{--                                <div class="input-field col s6">--}}
{{--                                    <i class="material-icons prefix">local_phone</i>--}}
{{--                                    <input value="{{ $user->second_phone }}" id="second_phone" name="second_phone" type="tel" class="validate  @error('second_phone') invalid @enderror">--}}
{{--                                    <label class="active" for="second_phone">Доп. телефон</label>--}}
{{--                                </div>--}}
                            </div>
                            <div class="row">
                                <div class="col s6">
                                    <a href="{{ route('users.index') }}" class="btn waves-effect waves-light red lighten-1">
                                        @lang('management.users.form.back')
                                    </a>
                                </div>
                                <div class="col s6 right-align">
                                    <button class="btn waves-effect waves-light" type="submit" name="action">
                                        @lang('management.users.form.save')
                                        <i class="material-icons right">save</i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
