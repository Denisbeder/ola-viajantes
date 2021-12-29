<?xml version="1.0" encoding="UTF-8"?>
<rss xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:media="http://search.yahoo.com/mrss/" version="2.0">
    <channel>
        <title>RSS Google News - {{ config('app.site.name') }}</title>
        <link>{{ config('app.url') }}</link>
        <language>{{ str_replace('_', '-', config('app.locale')) }}</language>
        <webMaster>{{ 'contato@' . parse_url(config('app.url'), PHP_URL_HOST) }} ({{ config('app.site.name') }})</webMaster>
        <copyright>{{ config('app.site.name') }}</copyright>
        <lastBuildDate>{{ $entries->first()->published_at->toRfc822String() }}</lastBuildDate>
        <description>{{ optional(app('settingService')->get('seo'))->get('description') }}</description>

        @foreach($entries as $entry)
        @php
            $images = $entry->getMedia('images');
        @endphp
        <item>
            <title>{{ $entry->title }} - {{ config('app.site.name') }}</title>
            <link>{{ config('app.url') . $entry->present()->url }}</link>
            <guid isPermaLink="false">{{ $entry->present()->url }}</guid>
            <pubDate>{{ $entry->published_at->toRfc822String() }}</pubDate>
            <description>{{ $entry->present()->summary }}</description>
            {{-- <source url="https://www.infomoney.com.br">InfoMoney</source> --}}
            <author>{{ 'redacao@' . parse_url(config('app.url'), PHP_URL_HOST) }} ({{ $entry->present()->getAuthor('name') ?? config('app.site.name') }})</author>
            @if($images->count() > 1 && $images->isNotEmpty())
                <section class="type:slideshow">
                    @foreach($entry->getMedia('images') as $image)
                    <figure>
                        <img src="{{ $image->getUrl('thumb') }}" {!! $loop->first ? 'class="type:primaryImage"' : '' !!} />     
                        @if($image->hasCustomProperty('caption') && !empty($image->getCustomProperty('caption')))
                        <figcaption>{{ $image->getCustomProperty('caption') }}</figcaption>              
                        @endif         
                    </figure>
                    @endforeach
                </section>
            @elseif($entry->hasMedia('images'))
                <figure>
                    <img src="{{ $entry->getFirstMediaUrl('images', 'thumb') }}" class="type:primaryImage" />     
                    @if($entry->getFirstMedia('images')->hasCustomProperty('caption') && !empty($entry->getFirstMedia('images')->getCustomProperty('caption')))
                    <figcaption>{{ $entry->getFirstMedia('images')->getCustomProperty('caption') }}</figcaption>              
                    @endif       
                </figure>
            @endif

            <content:encoded>
                <![CDATA[<p><a href="{{ config('app.url') . $entry->present()->url }}">{{ $entry->title }}</a></p><p>{{ $entry->present()->summary }}</p>@if($entry->hasMedia('images'))<p><a href="{{ config('app.url') . $entry->present()->url }}"><img src="{{ $entry->getFirstMediaUrl('images', 'thumb') }}" /></a>/p>@endif<]]>
            </content:encoded>
        </item>
        @endforeach
    </channel>
</rss>