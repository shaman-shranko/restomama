@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
@foreach(config('app.locales') as $locale)
<url>
<loc>https://restomama.com/{{$locale}}</loc>
<changefreq>daily</changefreq>
@foreach(config('app.locales') as $add_loc)
@if($add_loc !== $locale)
<xhtml:link rel="alternate" hreflang="{{$add_loc}}" href="https://restomama.com/{{$add_loc}}"/>
@endif
@endforeach
</url>
@endforeach
@foreach($cities as $city)
@foreach(config('app.locales') as $locale)
<url>
<loc>https://restomama.com/{{$locale}}/{{$city->uri}}</loc>
<changefreq>daily</changefreq>
@foreach(config('app.locales') as $add_loc)
@if($add_loc !== $locale)
<xhtml:link rel="alternate" hreflang="{{$add_loc}}" href="https://restomama.com/{{$add_loc}}/{{$city->uri}}"/>
@endif
@endforeach
</url>
@endforeach
@endforeach
@foreach($restaurants as $restaurant)
@foreach(config('app.locales') as $locale)
<url>
<loc>https://restomama.com/{{$locale}}/{{$restaurant->city->uri}}/{{$restaurant->uri}}</loc>
<changefreq>daily</changefreq>
@foreach(config('app.locales') as $add_loc)
@if($add_loc !== $locale)
<xhtml:link rel="alternate" hreflang="{{$add_loc}}" href="https://restomama.com/{{$add_loc}}/{{$restaurant->city->uri}}/{{$restaurant->uri}}"/>
@endif
@endforeach
</url>
@endforeach
@endforeach
</urlset>
