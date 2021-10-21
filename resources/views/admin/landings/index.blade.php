@extends('layouts.account')

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">Список посадочных</h1>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 right-align">
                            <a href="{{ route('landings.create') }}" class="btn waves-effect waves-light">
                                Добавить
                            </a>
                        </div>
                    </div>

                        <table class="highlight responsive-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>URI</th>
                                <th>Название (Заголовок)</th>
                                <th>Статус</th>
                                <th>Порядок сортировки</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $key => $item)
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td>
                                        {{ $item->uri }}
                                    </td>
                                    <td>
                                        @foreach( $item->langs as $lang)
                                            @if($lang->language == app()->getLocale())
                                                {{ $lang->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @if( $item->is_active )
                                            Включена
                                        @else
                                            Отключена
                                        @endif
                                    </td>
                                    <td>
                                        {{ $item->sorting }}
                                    </td>
                                    <td>
                                        <a href="{{ route('landings.edit', ['id' =>  $item->id ]) }}" title="Редактировать">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        <form method="POST" action="{{ route('restaurant-types.destroy', ['id' => $item->id ]) }}">
                                            @method("DELETE")
                                            @csrf
                                            <button type="submit" title="удалить"><i class="material-icons red-text lighten-1-text">cancel</i></button>
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
