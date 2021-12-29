{!!'<' . '?' . 'xml version="1.0" encoding="UTF-8"' . '?' . '>'!!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-news/0.9 http://www.google.com/schemas/sitemap-news/0.9/sitemap-news.xsd">
@foreach($entries as $entry)

<url>
<loc>{{ config('app.url') . $entry->present()->url }}</loc>
<news:news>
<news:publication>
<news:name>{{ config('app.name') }}</news:name>
<news:language>pt-br</news:language>
</news:publication>

<news:publication_date>{{ $entry->published_at->toW3cString() }}</news:publication_date>
<news:title>{{ $entry->title }}</news:title>

@if((bool) strlen($keywords = trim(optional($entry->seo)->keywords, ',')))
<news:keywords>{{ $keywords }}</news:keywords>
@endif
</news:news>
@if($entry->getMedia('images')->isNotEmpty())
@foreach($entry->getMedia('images') as $image)
<image:image>
<image:loc>{{ $image->getUrl('thumb')}}</image:loc>
@if($image->hasCustomProperty('caption'))
<image:caption>{{ $image->getCustomProperty('caption') }}</image:caption>
@endif
</image:image>
@endforeach
@endif
</url>
@endforeach
</urlset>