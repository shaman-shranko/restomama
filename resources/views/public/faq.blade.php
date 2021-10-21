@extends('layouts.app')

@section('seo')

@endsection

@section('scripts')

@endsection

@section('content')
    <div class="container" style="padding-top: 40px; padding-bottom: 40px;">
        <div class="row">
            <div class="col s12">
                <h1 class="heading-1">Часто задаваемые вопросы</h1>
            </div>
            <div class="col s12 info">
                @if($questions->count() > 0)
                    <ul class="collapsible">
                        @foreach($questions as $question)
                            <li>
                                @php
                                    $iteration = $loop->iteration
                                @endphp
                                @foreach($question->langs as $lang)
                                    @if($lang->lang == app()->getLocale())
                                        <div class="collapsible-header">
                                            {{ $iteration }}.
                                            {!! $lang->title !!}
                                        </div>
                                        <div class="collapsible-body">
                                            {!! $lang->content !!}
                                        </div>
                                    @endif
                                @endforeach
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
