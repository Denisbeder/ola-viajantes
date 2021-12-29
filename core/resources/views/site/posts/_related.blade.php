@php
    $excludeIds = collect([]);
    $relatedService = new \App\Supports\Services\RelatedService;
    $relatedItems = $relatedService->from($data)->get()->filter(function ($item) use ($data) {
        return $item->id !== $data->id;
    })->each(function ($item) use ($excludeIds) {
        $excludeIds->push(['id' => $item->id, 'type' => get_class($item)]);
    });
    $excludeIds->push(['id' => $data->id, 'type' => get_class($data)]);
    $latestItems = (new \App\Supports\Services\LatestAllRecordsService)->excludeIds($excludeIds)->limit(5)->get()->take(5);
    $moreDatas = $relatedItems->merge($latestItems);
@endphp    
@if($moreDatas->isNotEmpty())                    
<div class="pt-3 mt-5 border-top">
    <strong class="d-block" style="font-size: 20px;">VEJA TAMBÉM</strong>
    
    @foreach ($moreDatas as $item)
    <article class="mt-5 card card-post horizontal">
        @if($item->hasMedia($item->mediaCollection))
        <a href="{{ $item->present()->url }}" title="{{ $item->title }}" class="d-block card-img">
            {!!
                $item->present()->imgFirst(
                    $item->mediaCollection,
                    [
                        'width' => '228', 
                        'height' => '164', 
                        'fit' => 'crop', 
                    ],
                    null,
                    //['class' => 'lazy']
                )
            !!}
        </a>
        @endif
        <div class="card-body">
            @if((bool) strlen($subject = $item->present()->subject))<p class="mb-2 card-subject">{{ $subject }}</p>@endif
            <h2 class="card-title title-18">
                <a href="{{ $item->present()->url }}" title="{{ $item->title }}">
                    {{ $item->title_short ?? $item->title }}
                </a>
            </h2>
            <time class="card-time d-none d-md-block"><i class="mr-1 lni lni-alarm-clock"></i> {{ $item->present()->forHumans }} {{ $item->present()->categoryTitleForFront }}</time>
            <p class="mt-1 card-text summary d-none d-md-block">{{ $item->present()->summary }}</p>
        </div>
    </article>
    @endforeach
</div>
@endif