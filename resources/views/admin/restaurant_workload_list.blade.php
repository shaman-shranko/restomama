@extends('layouts.account')
@section('seo')
    <title>@lang('management.workload.index.page_title')</title>
@endsection
@section('styles')
    <link href='{{asset('admin/fullcalendar/core/main.min.css')}}' rel='stylesheet'/>
    <link href='{{asset('admin/fullcalendar/daygrid/main.min.css')}}' rel='stylesheet'/>
@endsection

@section('scripts')

@endsection

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">@lang('management.workload.index.name')</h1>
            <div class="card">
                <div class="card-content">
                    <table class="responsive-table">
                        @foreach($restaurants as $item)
                            <tr>
                                <td>
                                    {{$loop->iteration}}
                                </td>
                                <td>
                                    @foreach($item->languages as $lang)
                                        @if($lang->language == app()->getLocale())
                                            {{$lang->name}}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{route('workload-place', ['id' => $item->id])}}">
                                        <i class="material-icons">create</i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            {{ $restaurants->links() }}
        </div>
    </div>
@endsection
