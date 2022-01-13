<div class="sticky-top">
    @if((bool) strlen($banner = app('bannerService', [2, true, false])->toJson()))
    <div class="mb-5 ad" data-pos="2" data-ads="{!! $banner !!}"></div>
    @endif

    @include('site._poll')              

    @php $latestS = (new App\Supports\Services\LatestAllRecordsService)->limit(3)->get()->take(3); @endphp
    @forelse ($latestS as $item)
    <article class="card card-post mb-5">
        {!!
            $item->present()->imgFirst(
                $item->mediaCollection,
                [
                    'width' => 423, 
                    'height' => 283, 
                    'fit' => 'crop', 
                    'class' => 'img-fluid',
                ],
                null,
                ['class' => 'lazy']
            )
        !!}
        <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" class="card-img-overlay {{ !$item->hasMedia($item->mediaCollection) ? 'border' : null }} {{ $item->getTable() === "videos" ? 'popup-video' : null }}">
            @if((bool) strlen($subject = $item->present()->subject))<p class="card-subject">{{ $subject }}</p>@endif
            @if($item->getTable() === "videos")<span class="card-subject-video">ASSISTA</span>@endif
            <h1 class="card-title title-18">{{ $item->title_short ?? $item->title }}</h1>
        </a>
    </article>
    @empty
    @endforelse
</div>
