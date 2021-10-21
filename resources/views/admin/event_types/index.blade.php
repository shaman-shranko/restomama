@extends('layouts.account')

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">Типы мероприятий</h1>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 right-align">
                            <a href="{{ route('event_types.create') }}" class="btn waves-effect waves-light">
                                Добавить
                            </a>
                        </div>
                    </div>
                    @if($types->count() == 0)
                        <div class="row">
                            <div class="col-12">
                                На данный момент не создано ни одного типа мероприятия
                            </div>
                        </div>
                    @else
                        <table class="highlight responsive-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Название</th>
                                <th>Статус</th>
                                <th>Порядок сортировки</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($types as $key => $type)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        @foreach( $type->langs as $lang)
                                            @if($lang->lang == app()->getLocale())
                                                {{ $lang->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @if( $type->active )
                                            Включен
                                        @else
                                            Отключен
                                        @endif
                                    </td>
                                    <td>
                                        {{ $type->sorting }}
                                    </td>
                                    <td>
                                        <a href="{{ route('event_types.edit', ['id' =>  $type->id ]) }}" title="Редактировать">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        <form method="post" action="{{ route('event_types.destroy', ['id' => $type->id ]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" title="Удалить">
                                                <i class="material-icons red-text lighten-1-text">cancel</i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

