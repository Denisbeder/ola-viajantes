@extends('site.__default')

@include('site._seo', compact('seo'))

@section('content')
    <div class="container px-0 mt-0 mt-md-5 px-md-3">
        @if(app('mobile-detect')->isMobile())
        <div id="hightlights-carousel" class="owl-carousel" style="max-height: 500px; min-width: 100%;">
            @foreach ([1,2] as $postId)      
                @foreach (${'postsP'.$postId} as $item)
                <article class="card card-post d-flex" style="min-height: 100%; height: 470px; min-width: 100vw;">
                    {!!
                        $item->present()->imgFirst(
                            $item->mediaCollection,
                            [
                                'width' => '312', 
                                'height' => '470', 
                                'fit' => 'crop', 
                                'class' => 'img-fluid rounded-0',
                            ],
                            null,
                            ['class' => 'owl-lazy']
                        )
                    !!}
                    <a href="{{ $item->present()->url }}" title="{{ $item->title }}" class="card-img-overlay rounded-0 {{ !$item->hasMedia($item->mediaCollection) ? 'border' : null }}">
                        @if((bool) strlen($subject = $item->present()->subject))<p class="card-subject">{{ $subject }}</p>@endif
                        @if($item->getTable() === "videos")<span class="card-subject-video">ASSISTA</span>@endif
                        <h1 class="card-title {{ $item->hasMedia($item->mediaCollection) ? 'title-20' : 'title-24' }}">{{ $item->title_short ?? $item->title }}</h1>
                    </a>
                </article>
                @endforeach
            @endforeach
        </div>
        @else
        <div class="row">
            <div class="col-12 col-md-6">
                @foreach ($postsP1 as $item)
                <article class="card card-post" style="min-height: 100%; height: 434px;">
                    {!!
                        $item->present()->imgFirst(
                            $item->mediaCollection,
                            [
                                'width' => 652, 
                                'height' => 434, 
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
                        <h1 class="card-title title-24">{{ $item->title_short ?? $item->title }}</h1>
                        <p class="card-text summary mt-2">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fugit eius tenetur ipsam, et aliquid dolores, hic debitis veritatis molestiae natus possimus nesciunt earum saepe cumque praesentium ratione, sunt unde! Quod?</p>
                    </a>
                </article>
                @endforeach
            </div>

            <div class="col-12 col-md-6">
                @foreach ($postsP2 as $item)
                <article class="card card-post horizontal-mobile" style="min-height: 100%; height: 434px;">
                    {!!
                        $item->present()->imgFirst(
                            $item->mediaCollection,
                            [
                                'width' => 652, 
                                'height' => 434, 
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
                        <h1 class="card-title title-24">{{ $item->title_short ?? $item->title }}</h1>
                        <p class="card-text summary mt-2">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fugit eius tenetur ipsam, et aliquid dolores, hic debitis veritatis molestiae natus possimus nesciunt earum saepe cumque praesentium ratione, sunt unde! Quod?</p>
                    </a>
                </article>
                @endforeach
            </div>
        </div>
        @endif
    </div>
   
    @include('site._ad-top', ['class' => 'mt-5'])

    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="row">
                    <div class="col-12 col-md-6">
                        @foreach ($postsP3 as $item)
                        <article class="card card-post mb-5">
                            {!!
                                $item->present()->imgFirst(
                                    $item->mediaCollection,
                                    [
                                        'width' => 424, 
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
                        @endforeach
                    </div>

                    <div class="col-12 col-md-6">
                        @foreach ($postsP4 as $item)
                        <article class="card card-post mb-5">
                            {!!
                                $item->present()->imgFirst(
                                    $item->mediaCollection,
                                    [
                                        'width' => 424, 
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
                        @endforeach
                    </div>
                </div>

                @foreach ([5,6,7,8] as $postId)  
                    @php $mb = !$loop->last ? 'mb-5' : ''; @endphp
                    @foreach (${'postsP'.$postId} as $item)
                    <article class="card card-post horizontal {{ $mb }}">
                        @if($item->hasMedia($item->mediaCollection))
                        <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" class="d-block card-img {{ $item->getTable() === "videos" ? "popup-video" : null }}">
                            {!!
                                $item->present()->imgFirst(
                                    $item->mediaCollection,
                                    [
                                        'width' =>  310, 
                                        'height' => 207, 
                                        'fit' => 'crop', 
                                    ],
                                    null,
                                    ['class' => 'lazy']
                                )
                            !!}
                        </a>     
                        @endif               
                        @if((bool) strlen($subject = $item->present()->subject))<p class="card-subject">{{ $subject }}</p>@endif
                        @if($item->getTable() === "videos")<span class="card-subject-video">ASSISTA</span>@endif
                        <div class="card-body">
                            <h2 class="card-title title-22">
                                <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" {!! $item->getTable() === "videos" ? 'class="popup-video"' : null !!}>
                                    {{ $item->title_short ?? $item->title }}
                                </a>
                            </h2>
                            <p class="card-text summary mt-2">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fugit eius tenetur ipsam, et aliquid dolores, hic debitis veritatis molestiae natus possimus nesciunt earum saepe cumque praesentium ratione, sunt unde! Quod?</p>
                        </div>
                    </article>
                    @endforeach
                @endforeach
            </div>

            <div class="col-12 col-md-4 mt-5 mt-md-0">
                <div class="sticky-top">
                    @if((bool) strlen($banner = app('bannerService', [2, true, false])->toJson()))
                    <div class="mb-5 ad" data-pos="2" data-ads="{!! $banner !!}"></div>
                    @endif
                    
                    @forelse ($latest->take(3) as $item)
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
            </div>
        </div>
    </div>

    <div class="mt-5 position-relative container-fluid">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <div class="box-title">Os mais visitados</div>
                <small class="text-muted mb-4 d-block">Esses são os nossos posts mais famosos</small>
            </div>

            <div class="d-flex">
                <button type="button" id="mostviews-carousel-prev" class="btn rounded-pill bg-light text-secondary p-0 d-flex justify-content-center align-items-center mr-2" style="width: 50px; height: 50px;"><i class="lni lni-arrow-left"></i></button>
                <button type="button" id="mostviews-carousel-next" class="btn rounded-pill bg-light text-secondary p-0 d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;"><i class="lni lni-arrow-right"></i></button>
            </div>
        </div>
        <div id="mostviews-carousel" class="owl-carousel">
            @foreach ([1,2,3,4,5,6,7,8] as $postId)      
                @foreach (${'postsP'.$postId} as $item)
                <article class="card card-post d-flex">
                    {!!
                        $item->present()->imgFirst(
                            $item->mediaCollection,
                            [
                                'width' => '424', 
                                'height' => '210', 
                                'fit' => 'crop', 
                                'class' => 'img-fluid',
                            ],
                            null,
                            null
                        )
                    !!}
                    <a href="{{ $item->present()->url }}" title="{{ $item->title }}" class="card-img-overlay {{ !$item->hasMedia($item->mediaCollection) ? 'border' : null }}">
                        @if((bool) strlen($subject = $item->present()->subject))<p class="card-subject">{{ $subject }}</p>@endif
                        @if($item->getTable() === "videos")<span class="card-subject-video">ASSISTA</span>@endif
                        <h1 class="card-title title-16 font-weight-normal">{{ $item->title_short ?? $item->title }}</h1>
                    </a>
                </article>
                @endforeach
            @endforeach
        </div>
    </div>

    <div class="mt-5 container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="box-title">Top destinos</div>
                <small class="text-muted mb-4 d-block">Veja alguns dos destinos mais populares entre os viajantes</small>
            </div>

            <div class="d-flex">
                <a href="/destinos">Ver todos os destinos</a>
            </div>
        </div>
        
        <div class="row">
            @foreach ([1,2,3,4,5,6,7,8] as $postId)      
                @foreach (${'postsP'.$postId} as $item)
                <div class="col-2">
                    <article class="card card-post d-flex mb-4">
                    {!!
                        $item->present()->imgFirst(
                            $item->mediaCollection,
                            [
                                'width' => '198', 
                                'height' => '198', 
                                'fit' => 'crop', 
                                'class' => 'img-fluid',
                            ],
                            null,
                            null
                        )
                    !!}
                    <a href="{{ $item->present()->url }}" title="{{ $item->title }}" class="card-img-overlay p-3 {{ !$item->hasMedia($item->mediaCollection) ? 'border' : null }}">
                        <h1 class="card-title title-16 font-weight-normal">{{ $item->title_short ?? $item->title }}</h1>
                    </a>
                </article>
                </div>
                @endforeach
            @endforeach
        </div>
    </div>
@endsection
