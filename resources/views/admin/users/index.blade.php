@extends('layouts.account')
@section('seo')
    <title>@lang('management.users.index.page_title')</title>
@endsection
@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">@lang('management.users.index.title')</h1>
            <a href="{{ route('users.create') }}">@lang('management.users.index.add')</a>
            <div class="card">
                <div class="card-content">
                    <table class="highlight responsive-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('management.users.index.name')</th>
                            <th>@lang('management.users.index.role')</th>
                            <th>E-mail</th>
                            <th>@lang('management.users.index.phone')</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $key => $user)
                            <tr>
                                <td>
                                    {{ $key + 1 }}
                                </td>
                                <td>
                                    {{ $user->name }} {{ $user->surname }}
                                </td>
                                <td>
                                    @foreach( $user->roles as $role)
                                        {{ $role->alias }} <br/>
                                    @endforeach
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    {{ $user->phone }} <br/>
                                    {{ $user->second_phone }}
                                </td>
                                <td>
                                    <a href="{{ route('users.edit', ['id' =>  $user->id ]) }}"><i
                                                class="material-icons">edit</i></a>
                                    <form method="POST" action="{{ route('users.destroy', ['id' =>  $user->id ]) }}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit"
                                                class="btn">@lang('management.users.index.remove')</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
