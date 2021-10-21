@extends('layouts.account')
@section('seo')
    <title>@lang('management.faq.index.page_title')</title>
@endsection
@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">@lang('management.faq.index.page_title')</h1>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 right-align">
                            <a href="{{ route('questions.create') }}" class="btn waves-effect waves-light">
                                @lang('management.faq.index.add')
                            </a>
                        </div>
                    </div>
                    @if($questions->count() == 0)
                        <div class="row">
                            <div class="col-12">
                                @lang('management.faq.index.empty')
                            </div>
                        </div>
                    @else
                        <table class="highlight responsive-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('management.faq.index.question')</th>
                                <th>@lang('management.faq.index.status')</th>
                                <th>@lang('management.faq.index.order')</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($questions as $question)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        @foreach( $question->languages as $lang)
                                            @if($lang->language == app()->getLocale())
                                                {{ $lang->title }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @if($question->status)
                                            @lang('management.faq.index.publicated')
                                        @else
                                            @lang('management.faq.index.unpublicated')
                                        @endif
                                    </td>
                                    <td>
                                        {{ $question->sorting }}
                                    </td>
                                    <td>
                                        <a href="{{route('questions.edit', ['id' => $question->id])}}" title="@lang('management.faq.index.edit')">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        <form method="post" action="{{ route('questions.destroy', ['id' => $question->id]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit">
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
