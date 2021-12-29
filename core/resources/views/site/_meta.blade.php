<title>@yield('page_title', config('app.site.name') . ' ' . (((bool) strlen($siteSlogan = config('app.site.slogan'))) ? config('app.site.title_divisor') . ' ' . $siteSlogan : ''))</title>

@hasSection('robots_noindex')
<meta name="robots" content="noindex" />
@endif

@hasSection('page_url')
<link rel="canonical" href="@yield('page_url')">
<meta property="og:url" content="@yield('page_url')">
@endif

@hasSection('page_description')
<meta name="description" content="@yield('page_description')">
<meta itemprop="description" content="@yield('page_description')">
<meta property="og:description" content="@yield('page_description')">
@endif

@hasSection('page_keywords')
<meta name="keywords" content="@yield('page_keywords')">
<meta itemprop="keywords" content="@yield('page_keywords')">
@endif

<meta property="og:locale" content="pt_BR">
<meta property="og:site_name" content="{{ config('app.site.name') }}">

@hasSection('page_type')
<meta property="og:type" content="@yield('page_type', 'article')" />
@endif

@hasSection('page_image')
<meta property="og:image:width" content="@yield('page_image_width', 800)">
<meta property="og:image:height" content="@yield('page_image_height', 600)">
<meta property="og:image" itemprop="image" content="@yield('page_image')" />
<meta name="twitter:card" content="summary">
<meta name="twitter:image" content="@yield('page_image')">
@endif

@hasSection('page_headline')
<meta property="og:title" content="@yield('page_headline')">
@endif

<meta property="fb:app_id" content="">

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    @hasSection('page_type')
    "@type": "@yield('page_type')",
    @endif

    "mainEntityOfPage":{
        "@type":"WebPage",
        "@id":"@yield('page_url')"
    },
    @hasSection('page_headline')
    "headline": "@yield('page_headline')",
    @endif

    @hasSection('page_image')
    "image": {
        "@type": "ImageObject",
        "url": "@yield('page_image')",
        "height": @yield('page_image_height', 800),
        "width": @yield('page_image_width', 800)
    },
    @endif

    @hasSection('page_published')
    "datePublished": "@yield('page_published')",
    @endif

    @hasSection('page_updated')
    "dateModified": "@yield('page_updated')",
    @endif

    @hasSection('page_author')
    "author": {
        "@type": "Person",
        "name": "@yield('page_author')"
    },
    @else
    "author": {
        "@type": "Organization",
        "name": "{{ config('app.site.name') }}"
    },
    @endif

    "publisher": {
        "@type": "Organization",
        "name": "{{ config('app.site.name') }}",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('/assets/site/img/logo.png') }}",
            "width": 600,
            "height": 60
        }
    }@hasSection('page_description'),
    "description": "@yield('page_description')"
    @endif
}
</script>