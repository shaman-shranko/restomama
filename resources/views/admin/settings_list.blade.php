@extends('layouts.account')

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">Список настроек</h1>
            <div class="card">
                <div class="card-content">
                    <table class="highlight responsive-table">
                        <tbody>
                            <tr>
                                <td>
                                    Настройки сайта
                                </td>
                                <td>
                                    action
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Настройки главной страницы
                                </td>
                                <td>
                                    action
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Настройка изображений
                                </td>
                                <td>
                                    <a href="{{route('settings-images')}}">Редактировать</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
