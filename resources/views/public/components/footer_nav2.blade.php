<ul>
    @foreach($nav_articles as $article)
        <li>
            <a class="grey-text text-lighten-3" href="{{ route('view-article', ['article_uri' => $article->uri]) }}">
                @foreach($article->languages as $lang)
                    @if($lang->language == app()->getLocale())
                        {{ $lang->title }}
                    @endif
                @endforeach
            </a>
        </li>
    @endforeach
{{--    <li>--}}
{{--        <a class="grey-text text-lighten-3" href="{{ route('faq') }}">--}}
{{--            Часто задаваемые вопросы--}}
{{--        </a>--}}
{{--    </li>--}}
</ul>
