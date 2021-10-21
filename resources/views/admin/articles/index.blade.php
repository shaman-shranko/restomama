@extends ('layouts.account')
@section('seo')
    <title>@lang('management.articles.index.page_title')</title>
@endsection
@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">@lang('management.articles.index.page_title')</h1>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 right-align">
                            <a href="{{ route('articles.create') }}" class="btn waves-effect waves-light">
                                @lang('management.articles.index.add')
                            </a>
                        </div>
                    </div>
                    @if($articles->count() == 0)
                        <div class="row">
                            <div class="col-12">
                                @lang('management.articles.index.empty')
                            </div>
                        </div>
                    @else
                        <table class="highlight responsive-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>URI</th>
                                <th>@lang('management.articles.index.name')</th>
                                <th>@lang('management.articles.index.status')</th>
                                <th>@lang('management.articles.index.order')</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($articles as $article)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $article->uri }}
                                    </td>
                                    <td>
                                        @foreach( $article->languages as $lang)
                                            @if($lang->language == app()->getLocale())
                                                {{ $lang->title }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @if($article->status)
                                            @lang('management.articles.index.publicated')
                                        @else
                                            @lang('management.articles.index.unpublicated')
                                        @endif
                                    </td>
                                    <td>
                                        {{ $article->sorting }}
                                    </td>
                                    <td>
                                        <a href="{{route('articles.edit', ['id' => $article->id])}}" title="@lang('management.articles.index.edit')">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        <form method="post" action="{{route('articles.destroy', ['id' => $article->id])}}">
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
