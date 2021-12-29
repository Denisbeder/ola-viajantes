@if((bool) strlen($page->body))
<div class="mb-5 show-text">
    {!! $page->present()->bodyHtml !!}
</div>
@endif

@if(count($pageImages = $page->getMedia('images')) > 0)
<div class="mt-5 mb-5 row row-cols-3" id="gallery">
    @foreach ($pageImages as $item)
    <div class="mb-4 col">
        <a href="{{ $item->getUrl() }}" class="d-block gallery-item">
            {!! $page->present()->img($item->getUrl(), ['width' => 295, 'height' => 207, 'fit' => 'crop', 'class' => 'img-fluid']) !!}
        </a>
    </div>
    @endforeach
</div>
@endif