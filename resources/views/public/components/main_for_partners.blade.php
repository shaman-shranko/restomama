<div class="container" style="padding-bottom: 40px;">
    <div class="row">
        <div class="col s12">
            <h2 class="heading-2"> @lang('home.partner_title')</h2>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            @lang('home.partner_text')
        </div>
        <div class="col s12 right-align" style="margin-top: 20px;">
            <a href="{{ route('view-article', ['article_uri' => 'partners']) }}" class="btn">@lang('home.partner_button')</a>
        </div>
    </div>
</div>
