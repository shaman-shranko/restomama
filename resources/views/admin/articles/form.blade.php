@extends ('layouts.account')
@section('seo')
    <title>@lang('management.articles.form.page_title')</title>
@endsection
@section('scripts')
    @include('admin.components.tinymce_script')
@endsection

@section('main')
    <div class="row">
        <div class="col s12">
            <h1 class="flow-text">
                @if(isset($article_lang))
                    {{ $article_lang[app()->getLocale()]['title'] }}
                @else
                    @lang('management.articles.form.new')
                @endif
            </h1>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        @if(isset($article))
                            <form class="col s12" method="post" action="{{ route('articles.update', ['id' => $article->id]) }}">
                                @method('PATCH')
                        @else
                            <form class="col s12" method="post" action="{{ route('articles.store') }}">
                        @endif
                        @csrf
                        <div class="row">
                            <div class="col s12 right-align">
                                <button class="btn waves-effect waves-light" type="submit">
                                    @lang('management.articles.form.save')
                                    <i class="material-icons right">save</i>
                                </button>
                            </div>
                        </div>
                        @if ($errors->count() > 0)
                            <div class="row">
                                <ul class="col s-12">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col s12">
                                <ul class="tabs">
                                    <li class="tab col s3"><a class="active" href="#settings">@lang('management.articles.form.settings')</a></li>
                                    @foreach(config('app.locales') as $key => $lang)
                                        <li class="tab col s3"><a href="#{{ $lang }}">{{ $lang }}</a></li>
                                    @endforeach
                                </ul>
                            </div>

                            <div id="settings" class="col s12">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input @if(isset($article)) value="{{$article->uri}}" @endif id="uri" name="uri" type="text" class="validate  @error('uri') invalid @enderror" required>
                                        <label class="active" for="uri">URI</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <label>
                                            <input type="checkbox" class="filled-in" name="status" @if(isset($article) && $article->status) checked @endif/>
                                            <span>@lang('management.articles.form.publicate')</span>
                                        </label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input @if(isset($article)) value="{{$article->sorting}}" @else value="0" @endif id="sorting" name="sorting" type="number" class="validate  @error('sorting') invalid @enderror" required>
                                        <label class="active" for="sorting">@lang('management.articles.form.order')</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <h2 class="flow-text">@lang('management.articles.form.position')</h2>
                                    <div class="input-field col s12">
                                        <label>
                                            <input type="checkbox" class="filled-in" name="isTopMenu" @if(isset($article) && $article->isTopMenu) checked @endif/>
                                            <span>@lang('management.articles.form.top_menu')</span>
                                        </label>
                                    </div>
                                    <div class="input-field col s12">
                                        <label>
                                            <input type="checkbox" class="filled-in" name="isFooter_1" @if(isset($article) && $article->isFooter_1) checked @endif/>
                                            <span>@lang('management.articles.form.bottom_1')</span>
                                        </label>
                                    </div>
                                    <div class="input-field col s12">
                                        <label>
                                            <input type="checkbox" class="filled-in" name="isFooter_2" @if(isset($article) && $article->isFooter_2) checked @endif/>
                                            <span>@lang('management.articles.form.bottom_2')</span>
                                        </label>
                                    </div>
{{--                                    <div class="input-field col s12">--}}
{{--                                        <label>--}}
{{--                                            <input type="checkbox" class="filled-in" name="isBlog" @if(isset($article) && $article->isBlog) checked @endif/>--}}
{{--                                            <span>Блог</span>--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
                                </div>
                            </div>

                            @foreach(config('app.locales') as $lang)
                                <div id="{{$lang}}" class="col s12">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input
                                                @if(isset($article_lang)) value="{{ $article_lang[$lang]['title']}}" @endif
                                            id="description_{{$lang}}"
                                                name="langs[{{ $lang }}][title]"
                                                type="text" class="validate  @error('info') invalid @enderror"
                                                required>
                                            <label class="active" for="description_{{$lang}}">@lang('management.articles.form.heading')</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input
                                                @if(isset($article_lang)) value="{{$article_lang[$lang]['seo_title']}}" @endif
                                            id="seo_title_{{$lang}}"
                                                name="langs[{{$lang}}][seo_title]"
                                                type="text"
                                                class="validate  @error('surname') invalid @enderror" required>
                                            <label class="active" for="seo_title_{{$lang}}">SEO title</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea
                                                id="seo_description_{{$lang}}"
                                                name="langs[{{$lang}}][seo_description]"
                                                type="text"
                                                class="materialize-textarea validate  @error('surname') invalid @enderror">@if(isset($article_lang)){{$article_lang[$lang]['seo_description']}}@endif</textarea>
                                            <label class="active" for="seo_description_{{$lang}}">SEO description</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <label>
                                                @lang('management.articles.form.text')
                                            </label>
                                            <textarea
                                                id="content_{{$lang}}"
                                                name="langs[{{$lang}}][content]"
                                                hidden>@if(isset($article_lang)){{$article_lang[$lang]['content']}}@endif</textarea>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
