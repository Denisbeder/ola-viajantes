@php $mostViewed = app('mostViewedService')->get(); @endphp
@if($mostViewed->isNotEmpty())

<div class="px-4 pb-2 mt-5 overflow-hidden border rounded border-primary">
    <div class="mb-4 box-title" style="margin-top: -1px;">Mais lidas</div>

    <ul class="mx-n4 list-group list-group-flush">
        @foreach ($mostViewed as $item)
        <li class="list-group-item border-primary">
            <article class="card card-post horizontal">
                <div class="card-body flex-grow-1 justify-content-center d-flex flex-column">
                    <h3 class="mt-1 card-title title-14">
                        <a href="{{ $item->present()->url }}" title="{{ $item->title }}">
                            {{ $item->title }}
                        </a>
                    </h3>
                </div>
                @if($item->hasMedia($item->mediaCollection))
                <a href="{{ $item->present()->url }}" title="{{ $item->title }}" class="flex-grow-0 ml-3 d-flex align-items-center card-img flex-shrink-1 position-relative" 
                    style="max-width: 60px; min-width: 60px; margin-right: 0px !important;">
                    <div class="text-white border border-white position-absolute bg-primary rounded-pill d-flex align-items-center justify-content-center font-weight-bold" style="z-index: 1; border-width: 2px !important; width: 25px; height: 25px; font-size: 11px; left: -12.5px">{{ $loop->index + 1 }}</div>
                    {!!
                        $item->present()->imgFirst(
                            $item->mediaCollection,
                            [
                                'width' => '60', 
                                'height' => '60', 
                                'fit' => 'crop', 
                                'class' => 'img-fluid rounded',
                            ],
                            null,
                            ['class' => 'lazy']
                        )
                    !!}
                </a>
                @else
                <div class="flex-grow-0 ml-3 text-white d-flex align-items-center justify-content-center font-weight-bold card-img bg-primary rounded-pill" 
                    style="min-width: 60px; width: 60px; height: 60px; margin-right: 0px !important;">
                    {{ $loop->index + 1 }}
                </div>
                @endif                
            </article>
        </li>
        @endforeach
    </ul>
</div> 

{{-- <div class="mt-5 card">
    <div class="card-header">
        <strong>Mais lidas</strong>
    </div>
    <div class="card-body">
        <ul class="list-group list-group-flush box-list">
            @foreach ($mostViewed as $item)
            <li class="px-0 list-group-item box-list-item d-flex align-items-center">
                <div class="card card-post horizontal align-items-center">
                    <div class="flex-shrink-0 p-0 flex-grow-1 badge badge-light text-color-2 badge-pill text-muted" style="width: 60px; height: 60px; line-height: 60px; font-size: 18px;">{{ $loop->index + 1 }}</div>
                    <div class="ml-3 card-body flex-grow-1 justify-content-center d-flex flex-column w-100">
                        <h2 class="card-title title-16">
                            <a href="{{ $item->present()->url }}" title="{{ $item->title }}">{{ $item->title }}</a>
                        </h2>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div> --}}
@endif