@extends('layouts.account')
@section('seo')
    <title>@lang('management.staff.page_title')</title>
@endsection

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">
                @lang('management.staff.new_worker')
            </h1>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        @error('doublecating')
                        <div class="card-panel red darken-2">
                            <span class="white-text">
                                @lang('management.staff.exists')
                            </span>
                        </div>
                        @enderror
                        <form class="col s12" method="get">
                            @csrf
                            <div class="row">
                                <div class="col s12">
                                    <h2 class="flow-text">@lang('management.staff.search_filters')</h2>
                                </div>
                                <div class="input-field col s12">
                                    <input type="text" name="name" id="name" value="{{ request()->input('name') }}"/>
                                    <label for="name" class="active">@lang('management.staff.name')</label>
                                </div>
                                <div class="input-field col s12">
                                    <input type="text" name="surname" id="surname"
                                           value="{{ request()->input('surname') }}"/>
                                    <label for="surname" class="active">@lang('management.staff.surname')</label>
                                </div>
                                <div class="input-field col s12">
                                    <input type="email" name="email" id="email"
                                           value="{{ request()->input('email') }}"/>
                                    <label for="email" class="active">Email</label>
                                </div>
                                <div class="input-field col s12">
                                    <input type="text" name="phone" id="phone" value="{{ request()->input('phone') }}"/>
                                    <label for="phone" class="active">@lang('management.staff.phone')</label>
                                </div>
                                <div class="input-field col s12">
                                    <button type="submit" class="btn">@lang('management.staff.search')</button>
                                </div>
                            </div>
                        </form>
                        <form class="col s12" method="post" action="{{ route('staff.store') }}">
                            @csrf
                            <input type="hidden" name="restaurant" value="{{$restaurant_id}}"/>
                            <div class="row">
                                <div class="col s12">
                                    <h2 class="flow-text">@lang('management.staff.choose_user')</h2>
                                </div>
                                <div class="input-field col s12">
                                    @if($users->count() == 0)
                                        @lang('management.staff.empty_filter')
                                    @else
                                        @foreach($users as $user)
                                            <p>
                                                <label>
                                                    <input class="with-gap" name="user" type="radio"
                                                           value="{{$user->id}}"/>
                                                    <span>{{$user->surname}} {{$user->name}}, ({{$user->phone}}
                                                        , {{$user->email}})</span>
                                                </label>
                                            </p>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="input-field col s12">
                                    <select name="role" required class="">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" selected>{{$role->alias}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-field col s12">
                                    <button type="submit" class="btn">@lang('management.staff.make')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
