<ul>
    @foreach($nav_articles as $article)
        <li>
            <a class="grey-text text-lighten-3" href="{{ route('view-article', ['article_uri' => $article->uri]) }}">
                @foreach($article->langs as $lang)
                @if($lang->lang == app()->getLocale())
                {{ $lang->title }}
                @endif
                @endforeach
            </a>
        </li>
    @endforeach
</ul>
