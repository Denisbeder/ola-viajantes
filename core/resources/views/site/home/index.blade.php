@extends('site.__default')

@include('site._seo', compact('seo'))

@section('content')
    @if(!app('mobile-detect')->isMobile())
        @include('site._ad-top', ['class' => 'mt-5'])
    @endif
    
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
                <article class="card card-post" style="min-height: 100%; height: {{ app('mobile-detect')->isMobile() ? '258px' : '490px' }};">
                    {!!
                        $item->present()->imgFirst(
                            $item->mediaCollection,
                            [
                                'width' => app('mobile-detect')->isMobile() ? '312' : '655', 
                                'height' => app('mobile-detect')->isMobile() ? '228' : '490', 
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
                        <h1 class="card-title {{ $item->hasMedia($item->mediaCollection) ? 'title-20' : 'title-24' }}">{{ $item->title_short ?? $item->title }}</h1>
                    </a>
                </article>
                @endforeach
            </div>

            <div class="col-12 col-md-6">
                @foreach ($postsP2 as $item)
                <article class="card card-post horizontal-mobile" style="min-height: 100%; height: {{ app('mobile-detect')->isMobile() ? '258px' : '490px' }};">
                    {!!
                        $item->present()->imgFirst(
                            $item->mediaCollection,
                            [
                                'width' => app('mobile-detect')->isMobile() ? '312' : '655', 
                                'height' => app('mobile-detect')->isMobile() ? '228' : '490', 
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
                        <h1 class="card-title {{ $item->hasMedia($item->mediaCollection) ? 'title-20' : 'title-24' }}">{{ $item->title_short ?? $item->title }}</h1>
                    </a>
                </article>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    
    @if(app('mobile-detect')->isMobile())
        @include('site._ad-top', ['class' => 'mt-5'])
    @endif

    <div class="container mt-md-5">
        <div class="row">
            <div class="col-12 col-md-4">
                @foreach ($postsP3 as $item)
                <article class="mb-4 card card-post horizontal-mobile mb-md-0 {{ $item->hasMedia($item->mediaCollection) ?: 'card-post-no-img' }}">
                    @if($item->hasMedia($item->mediaCollection))
                    <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" class="d-block card-img {{ $item->getTable() === "videos" ? "popup-video" : null }}">
                        {!!
                            $item->present()->imgFirst(
                                $item->mediaCollection,
                                [
                                    'width' => '426', 
                                    'height' => '319', 
                                    'fit' => 'crop', 
                                    'class' => 'img-fluid',
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
                        <h2 class="card-title title-18">
                            <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" {!! $item->getTable() === "videos" ? 'class="popup-video"' : null !!}>
                                {{ $item->title_short ?? $item->title }}
                            </a>
                        </h2>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="col-12 col-md-4">
                @foreach ($postsP4 as $item)
                <article class="mb-4 card card-post horizontal-mobile mb-md-0 {{ $item->hasMedia($item->mediaCollection) ?: 'card-post-no-img' }}">
                    @if($item->hasMedia($item->mediaCollection))
                    <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" class="d-block card-img {{ $item->getTable() === "videos" ? "popup-video" : null }}">
                        {!!
                            $item->present()->imgFirst(
                                $item->mediaCollection,
                                [
                                    'width' => '426', 
                                    'height' => '319', 
                                    'fit' => 'crop', 
                                    'class' => 'img-fluid',
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
                        <h2 class="card-title title-18">
                            <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" {!! $item->getTable() === "videos" ? 'class="popup-video"' : null !!}>
                                {{ $item->title_short ?? $item->title }}
                            </a>
                        </h2>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="col-12 col-md-4">
                @foreach ($postsP5 as $item)
                <article class="mb-4 card card-post mb-md-0 horizontal-mobile {{ $item->hasMedia($item->mediaCollection) ?: 'card-post-no-img' }}">
                    @if($item->hasMedia($item->mediaCollection))
                    <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" class="d-block card-img {{ $item->getTable() === "videos" ? "popup-video" : null }}">
                        {!!
                            $item->present()->imgFirst(
                                $item->mediaCollection,
                                [
                                    'width' => '426', 
                                    'height' => '319', 
                                    'fit' => 'crop', 
                                    'class' => 'img-fluid',
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
                        <h2 class="card-title title-18">
                            <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" {!! $item->getTable() === "videos" ? 'class="popup-video"' : null !!}>
                                {{ $item->title_short ?? $item->title }}
                            </a>
                        </h2>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </div>    

    <div class="container mt-md-5">
        <div class="row">
            <div class="col-12 col-md-4">
                @foreach ($postsP6 as $item)
                <article class="mb-4 card card-post mb-md-0 horizontal-mobile {{ $item->hasMedia($item->mediaCollection) ?: 'card-post-no-img' }}">
                    @if($item->hasMedia($item->mediaCollection))
                    <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" class="d-block card-img {{ $item->getTable() === "videos" ? "popup-video" : null }}">
                        {!!
                            $item->present()->imgFirst(
                                $item->mediaCollection,
                                [
                                    'width' => '426', 
                                    'height' => '319', 
                                    'fit' => 'crop', 
                                    'class' => 'img-fluid',
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
                        <h2 class="card-title title-18">
                            <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" {!! $item->getTable() === "videos" ? 'class="popup-video"' : null !!}>
                                {{ $item->title_short ?? $item->title }}
                            </a>
                        </h2>
                    </div>
                </article>
                @endforeach

                <div class="mt-md-5 row">
                    <div class="col-12 col-md-6">
                        @foreach ($postsP7 as $item)
                        <article class="mb-4 card card-post mb-md-0 horizontal-mobile {!! $item->hasMedia($item->mediaCollection) ?: 'card-post-no-img" style="min-height: 232px; padding: 1.5rem;' !!}">
                            @if($item->hasMedia($item->mediaCollection))
                            <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" class="d-block card-img {{ $item->getTable() === "videos" ? "popup-video" : null }}">
                                {!!
                                    $item->present()->imgFirst(
                                        $item->mediaCollection,
                                        [
                                            'width' => '197', 
                                            'height' => '147', 
                                            'fit' => 'crop', 
                                            'class' => 'img-fluid',
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
                                <h2 class="card-title title-14">
                                    <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" {!! $item->getTable() === "videos" ? 'class="popup-video"' : null !!}>
                                        {{ $item->title_short ?? $item->title }}
                                    </a>
                                </h2>
                            </div>
                        </article>
                        @endforeach
                    </div>

                    <div class="col-12 col-md-6">
                        @foreach ($postsP8 as $item)
                        <article class="mb-4 card card-post mb-md-0 horizontal-mobile {!! $item->hasMedia($item->mediaCollection) ?: 'card-post-no-img" style="min-height: 232px; padding: 1.5rem;' !!}">
                            @if($item->hasMedia($item->mediaCollection))
                            <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" class="d-block card-img {{ $item->getTable() === "videos" ? "popup-video" : null }}">
                                {!!
                                    $item->present()->imgFirst(
                                        $item->mediaCollection,
                                        [
                                            'width' => '197', 
                                            'height' => '147', 
                                            'fit' => 'crop', 
                                            'class' => 'img-fluid',
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
                                <h2 class="card-title title-14">
                                    <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" {!! $item->getTable() === "videos" ? 'class="popup-video"' : null !!}>
                                        {{ $item->title_short ?? $item->title }}
                                    </a>
                                </h2>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                @foreach ($postsP9 as $item)
                    @if(!app('mobile-detect')->isMobile())
                    <article class="card card-post d-flex horizontal-mobile" style="height: {{ app('mobile-detect')->isMobile() ? '319px' : '660px' }};">
                        {!!
                            $item->present()->imgFirst(
                                $item->mediaCollection,
                                [
                                    'width' => app('mobile-detect')->isMobile() ? '426' : '426', 
                                    'height' => app('mobile-detect')->isMobile() ? '319' : '660', 
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
                            <h1 class="card-title {{ $item->hasMedia($item->mediaCollection) ? 'title-18' : 'title-24' }}">{{ $item->title_short ?? $item->title }}</h1>
                        </a>
                    </article>
                    @else
                    <article class="mb-4 card card-post mb-md-0 {{ $item->hasMedia($item->mediaCollection) ?: 'card-post-no-img' }}">
                        @if($item->hasMedia($item->mediaCollection))
                        <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" class="d-block card-img {{ $item->getTable() === "videos" ? "popup-video" : null }}">
                            {!!
                                $item->present()->imgFirst(
                                    $item->mediaCollection,
                                    [
                                        'width' => '426', 
                                        'height' => '319', 
                                        'fit' => 'crop', 
                                        'class' => 'img-fluid',
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
                            <h2 class="card-title title-18">
                                <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" {!! $item->getTable() === "videos" ? 'class="popup-video"' : null !!}>
                                    {{ $item->title_short ?? $item->title }}
                                </a>
                            </h2>
                        </div>
                    </article>
                    @endif
                @endforeach
            </div>

            <div class="col-12 col-md-4">
                @foreach ($postsP10 as $item)
                <article class="mb-4 card card-post mb-md-0 horizontal-mobile {{ $item->hasMedia($item->mediaCollection) ?: 'card-post-no-img' }}">
                    @if($item->hasMedia($item->mediaCollection))
                    <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" class="d-block card-img {{ $item->getTable() === "videos" ? "popup-video" : null }}">
                        {!!
                            $item->present()->imgFirst(
                                $item->mediaCollection,
                                [
                                    'width' => '426', 
                                    'height' => '319', 
                                    'fit' => 'crop', 
                                    'class' => 'img-fluid',
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
                        <h2 class="card-title title-18">
                            <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" {!! $item->getTable() === "videos" ? 'class="popup-video"' : null !!}>
                                {{ $item->title_short ?? $item->title }}
                            </a>
                        </h2>
                    </div>
                </article>
                @endforeach

                <div class="mt-md-5 row">
                    <div class="col-12 col-md-6">
                        @foreach ($postsP11 as $item)
                        <article class="mb-4 card card-post mb-md-0 horizontal-mobile {!! $item->hasMedia($item->mediaCollection) ?: 'card-post-no-img" style="min-height: 232px; padding: 1.5rem;' !!}">
                            @if($item->hasMedia($item->mediaCollection))
                            <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" class="d-block card-img {{ $item->getTable() === "videos" ? "popup-video" : null }}">
                                {!!
                                    $item->present()->imgFirst(
                                        $item->mediaCollection,
                                        [
                                            'width' => '197', 
                                            'height' => '147', 
                                            'fit' => 'crop', 
                                            'class' => 'img-fluid',
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
                                <h2 class="card-title title-14">
                                    <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" {!! $item->getTable() === "videos" ? 'class="popup-video"' : null !!}>
                                        {{ $item->title_short ?? $item->title }}
                                    </a>
                                </h2>
                            </div>
                        </article>
                        @endforeach
                    </div>

                    <div class="col-12 col-md-6">
                        @foreach ($postsP12 as $item)
                        <article class="mb-4 card card-post mb-md-0 horizontal-mobile {!! $item->hasMedia($item->mediaCollection) ?: 'card-post-no-img" style="min-height: 232px; padding: 1.5rem;' !!}">
                            @if($item->hasMedia($item->mediaCollection))
                            <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" class="d-block card-img {{ $item->getTable() === "videos" ? "popup-video" : null }}">
                                {!!
                                    $item->present()->imgFirst(
                                        $item->mediaCollection,
                                        [
                                            'width' => '197', 
                                            'height' => '147', 
                                            'fit' => 'crop', 
                                            'class' => 'img-fluid',
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
                                <h2 class="card-title title-14">
                                    <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" {!! $item->getTable() === "videos" ? 'class="popup-video"' : null !!}>
                                        {{ $item->title_short ?? $item->title }}
                                    </a>
                                </h2>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>  

    <div class="container mt-md-5">
        <div class="row">
            <div class="col-12 col-md-3">
                @foreach ($postsP13 as $item)
                <article class="mb-4 card card-post mb-md-0 horizontal-mobile">
                    @if($item->hasMedia($item->mediaCollection))
                    <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" class="d-block card-img {{ $item->getTable() === "videos" ? "popup-video" : null }}">
                        {!!
                            $item->present()->imgFirst(
                                $item->mediaCollection,
                                [
                                    'width' => '312', 
                                    'height' => '234', 
                                    'fit' => 'crop', 
                                    'class' => 'img-fluid',
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
                        <h2 class="card-title title-16">
                            <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" {!! $item->getTable() === "videos" ? 'class="popup-video"' : null !!}>
                                {{ $item->title_short ?? $item->title }}
                            </a>
                        </h2>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="col-12 col-md-3">
                @foreach ($postsP14 as $item)
                <article class="mb-4 card card-post mb-md-0 horizontal-mobile">
                    @if($item->hasMedia($item->mediaCollection))
                    <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" class="d-block card-img {{ $item->getTable() === "videos" ? "popup-video" : null }}">
                        {!!
                            $item->present()->imgFirst(
                                $item->mediaCollection,
                                [
                                    'width' => '312', 
                                    'height' => '234', 
                                    'fit' => 'crop', 
                                    'class' => 'img-fluid',
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
                        <h2 class="card-title title-16">
                            <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" {!! $item->getTable() === "videos" ? 'class="popup-video"' : null !!}>
                                {{ $item->title_short ?? $item->title }}
                            </a>
                        </h2>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="col-12 col-md-3">
                @foreach ($postsP15 as $item)
                <article class="mb-4 card card-post mb-md-0 horizontal-mobile">
                    @if($item->hasMedia($item->mediaCollection))
                    <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" class="d-block card-img {{ $item->getTable() === "videos" ? "popup-video" : null }}">
                        {!!
                            $item->present()->imgFirst(
                                $item->mediaCollection,
                                [
                                    'width' => '312', 
                                    'height' => '234', 
                                    'fit' => 'crop', 
                                    'class' => 'img-fluid',
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
                        <h2 class="card-title title-16">
                            <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" {!! $item->getTable() === "videos" ? 'class="popup-video"' : null !!}>
                                {{ $item->title_short ?? $item->title }}
                            </a>
                        </h2>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="col-12 col-md-3">
                @foreach ($postsP16 as $item)
                <article class="mb-4 card card-post mb-md-0 horizontal-mobile">
                    @if($item->hasMedia($item->mediaCollection))
                    <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" class="d-block card-img {{ $item->getTable() === "videos" ? "popup-video" : null }}">
                        {!!
                            $item->present()->imgFirst(
                                $item->mediaCollection,
                                [
                                    'width' => '312', 
                                    'height' => '234', 
                                    'fit' => 'crop', 
                                    'class' => 'img-fluid',
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
                        <h2 class="card-title title-16">
                            <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" {!! $item->getTable() === "videos" ? 'class="popup-video"' : null !!}>
                                {{ $item->title_short ?? $item->title }}
                            </a>
                        </h2>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </div>  

    @if($medias->isNotEmpty())
    <div class="pb-6 mt-5 bg-light" id="medias">
        <div class="container">
            <div class="mb-5 box-title center">Vídeos e Fotos</div>
            
            @if(!app('mobile-detect')->isMobile())
            <div class="row">
                <div class="col-3">
                    @foreach([1,2] as $pos)                        
                        @php $mediaItem = $medias->skip($pos)->take(1)->first(); @endphp
                        @if($mediaItem !== null)
                        <div class="mb-4 card card-post">
                            {!!
                                $mediaItem->present()->imgFirst(
                                    $mediaItem->mediaCollection,
                                    [
                                        'width' => '310', 
                                        'height' => '197', 
                                        'fit' => 'crop', 
                                        'class' => 'card-img',
                                    ],
                                    null,
                                    ['class' => 'lazy']
                                )
                            !!}                       
                            <a href="{{ $mediaItem->present()->urlVideo ?? $mediaItem->present()->url }}" title="{{ $mediaItem->title }}" class="p-3 card-img-overlay card-link {{ $mediaItem->getTable() === "videos" ? 'popup-video' : null }}">
                                <div class="rounded-pill d-flex align-items-center justify-content-center bg-primary position-absolute" style="width: 50px; height: 50px; top: 1rem;">
                                    @if($mediaItem->getTable() === "videos" )
                                    <i class="ml-1 lni lni-play"></i>
                                    @else
                                    <i class="lni lni-image"></i>
                                    @endif
                                </div>
                                <h3 class="card-title title-14">{{ $mediaItem->title }}</h3>
                            </a>                       
                        </div>
                        @endif
                    @endforeach
                </div>
                <div class="col-6">                    
                    @php $mediaItem = $medias->skip(0)->take(1)->first(); @endphp
                    @if($mediaItem !== null)
                    <div class="mb-4 card card-post">
                        {!!
                            $mediaItem->present()->imgFirst(
                                $mediaItem->mediaCollection,
                                [
                                    'width' => '650', 
                                    'height' => '420', 
                                    'fit' => 'crop', 
                                    'class' => 'card-img',
                                ],
                                null,
                                ['class' => 'lazy']
                            )
                        !!}                       
                        <a href="{{ $mediaItem->present()->urlVideo ?? $mediaItem->present()->url }}" title="{{ $mediaItem->title }}" class="p-3 card-img-overlay card-link {{ $mediaItem->getTable() === "videos" ? 'popup-video' : null }}">
                            <div class="rounded-pill d-flex align-items-center justify-content-center bg-primary position-absolute" style="width: 50px; height: 50px; top: 1rem;">
                                @if($mediaItem->getTable() === "videos" )
                                <i class="ml-1 lni lni-play"></i>
                                @else
                                <i class="lni lni-image"></i>
                                @endif
                            </div>
                            <h3 class="card-title title-16">{{ $mediaItem->title }}</h3>
                        </a>                       
                    </div>
                    @endif
                </div>
                <div class="col-3">
                    @foreach([3,4] as $pos)                        
                        @php $mediaItem = $medias->skip($pos)->take(1)->first(); @endphp
                        @if($mediaItem !== null)
                        <div class="mb-4 card card-post">
                            {!!
                                $mediaItem->present()->imgFirst(
                                    $mediaItem->mediaCollection,
                                    [
                                        'width' => '310', 
                                        'height' => '197', 
                                        'fit' => 'crop', 
                                        'class' => 'card-img',
                                    ],
                                    null,
                                    ['class' => 'lazy']
                                )
                            !!}                       
                            <a href="{{ $mediaItem->present()->urlVideo ?? $mediaItem->present()->url }}" title="{{ $mediaItem->title }}" class="p-3 card-img-overlay card-link {{ $mediaItem->getTable() === "videos" ? 'popup-video' : null }}">
                                <div class="rounded-pill d-flex align-items-center justify-content-center bg-primary position-absolute" style="width: 50px; height: 50px; top: 1rem;">
                                    @if($mediaItem->getTable() === "videos" )
                                    <i class="ml-1 lni lni-play"></i>
                                    @else
                                    <i class="lni lni-image"></i>
                                    @endif
                                </div>
                                <h3 class="card-title title-14">{{ $mediaItem->title }}</h3>
                            </a>                       
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            
            <div class="row">
                @foreach([5,6,7,8] as $pos)                        
                    @php $mediaItem = $medias->skip($pos)->take(1)->first(); @endphp
                    @if($mediaItem !== null)
                    <div class="col-3">
                        <div class="mb-4 card card-post">
                            {!!
                                $mediaItem->present()->imgFirst(
                                    $mediaItem->mediaCollection,
                                    [
                                        'width' => '310', 
                                        'height' => '197', 
                                        'fit' => 'crop', 
                                        'class' => 'card-img',
                                    ],
                                    null,
                                    ['class' => 'lazy']
                                )
                            !!}                       
                            <a href="{{ $mediaItem->present()->urlVideo ?? $mediaItem->present()->url }}" title="{{ $mediaItem->title }}" class="p-3 card-img-overlay card-link {{ $mediaItem->getTable() === "videos" ? 'popup-video' : null }}">
                                <div class="rounded-pill d-flex align-items-center justify-content-center bg-primary position-absolute" style="width: 50px; height: 50px; top: 1rem;">
                                    @if($mediaItem->getTable() === "videos" )
                                    <i class="ml-1 lni lni-play"></i>
                                    @else
                                    <i class="lni lni-image"></i>
                                    @endif
                                </div>
                                <h3 class="card-title title-14">{{ $mediaItem->title }}</h3>
                            </a>                         
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
            @else
            <div id="medias-carousel" class="rounded owl-carousel">
                @foreach (range(0, 8) as $pos)     
                    @php $mediaItem = $medias->skip($pos)->take(1)->first(); @endphp 
                    @if($mediaItem !== null)
                    <div class="mb-4 card card-post" style="max-height: 243px;">
                        {!!
                            $mediaItem->present()->imgFirst(
                                $mediaItem->mediaCollection,
                                [
                                    'width' => '310', 
                                    'height' => '197', 
                                    'fit' => 'crop', 
                                    'class' => 'card-img',
                                ],
                                null,
                                ['class' => 'lazy']
                            )
                        !!}                       
                        <a href="{{ $mediaItem->present()->urlVideo ?? $mediaItem->present()->url }}" title="{{ $mediaItem->title }}" class="p-3 card-img-overlay card-link {{ $mediaItem->getTable() === "videos" ? 'popup-video' : null }}">
                            <div class="rounded-pill d-flex align-items-center justify-content-center bg-primary position-absolute" style="width: 50px; height: 50px; top: 1rem;">
                                @if($mediaItem->getTable() === "videos" )
                                <i class="ml-1 lni lni-play"></i>
                                @else
                                <i class="lni lni-image"></i>
                                @endif
                            </div>
                            <h3 class="card-title title-14">{{ $mediaItem->title }}</h3>
                        </a>                      
                    </div>
                    @endif
                @endforeach
            </div>
            @endif            

            @php
                $btnVideosUrl = App\Page::firstWhere('slug', 'like', '%videos');
                $btnGalleriesUrl = App\Page::firstWhere('slug', 'like', 'galeria%');
            @endphp

            <div class="mt-3 d-flex align-items-center justify-content-center w-100">
                @if($btnVideosUrl !== null)
                <a href="{{ $btnVideosUrl->present()->url }}" class="mx-2 btn btn-primary">VER MAIS VÍDEOS</a>
                @endif

                @if($btnGalleriesUrl !== null)
                <a href="{{ $btnGalleriesUrl->present()->url }}" class="mx-2 btn btn-primary">VER MAIS FOTOS</a>
                @endif
            </div>
        </div>
    </div>
    @endif

    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="row">
                    @forelse ($postsP17 as $item)
                    <div class="col-12 col-md-4">
                        <article class="mb-4 card card-post mb-md-0 horizontal-mobile">
                            @if($item->hasMedia($item->mediaCollection))
                            <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" class="d-block card-img {{ $item->getTable() === "videos" ? "popup-video" : null }}">
                                {!!
                                    $item->present()->imgFirst(
                                        $item->mediaCollection,
                                        [
                                            'width' => '312', 
                                            'height' => '234', 
                                            'fit' => 'crop', 
                                            'class' => 'img-fluid',
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
                                <h2 class="card-title title-16">
                                    <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" {!! $item->getTable() === "videos" ? 'class="popup-video"' : null !!}>
                                        {{ $item->title_short ?? $item->title }}
                                    </a>
                                </h2>
                            </div>
                        </article>
                    </div>
                    @empty
                    @endforelse

                    @foreach ($latest as $item)
                    <div class="col-12 col-md-4">
                        <article class="mb-md-6 mb-4 card card-post horizontal-mobile {{ $item->hasMedia($item->mediaCollection) ?: 'card-post-no-img' }}">
                            @if($item->hasMedia($item->mediaCollection))
                            <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" class="d-block card-img {{ $item->getTable() === "videos" ? "popup-video" : null }}">
                                {!!
                                    $item->present()->imgFirst(
                                        $item->mediaCollection,
                                        [
                                            'width' => '426', 
                                            'height' => '319', 
                                            'fit' => 'crop', 
                                            'class' => 'img-fluid',
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
                                <h2 class="card-title title-16">
                                    <a href="{{ $item->present()->urlVideo ?? $item->present()->url }}" title="{{ $item->title }}" {!! $item->getTable() === "videos" ? 'class="popup-video"' : null !!}>
                                        {{ $item->title_short ?? $item->title }}
                                    </a>
                                </h2>
                            </div>
                        </article>
                    </div>                    
                    @endforeach
                </div>
                <a href="/ultimas?page=2" class="btn btn-light border btn-block">VER MAIS</a>
            </div>

            <div class="col-12 col-md-4 mt-5 mt-md-0">
                <div class="sticky-top">
                    @if((bool) strlen($banner = app('bannerService', [2, true, false])->toJson()))
                    <div class="mb-5 ad" data-pos="2" data-ads="{!! $banner !!}"></div>
                    @endif
                    
                    @include('site._poll')
                    
                    @include('site._most-views')

                    @php $currentPageSelect = app('getPageService', ['colunas', is_mobile() ? 5 : 20]); @endphp
                    @if(!is_null($currentPageSelect->getCollection()) && $currentPageSelect->getCollection()->isNotEmpty())
                    <div class="px-4 pb-2 mt-5 overflow-hidden border rounded border-primary">
                        <div class="mb-4 d-flex w-100 align-items-end">
                            <div class="box-title" style="margin-top: -1px;">{{ $currentPageSelect->getPage()->title }}</div>
                            <a href="{{ $currentPageSelect->getPage()->present()->url }}" class="ml-auto"><small class="font-weight-bold">VER TODOS <i class="ml-1 lni lni-arrow-right"></i></small></a>
                        </div>

                        <ul class="mx-n4 list-group list-group-flush">
                            @foreach ($currentPageSelect->getCollection() as $item)
                            <li class="list-group-item border-primary">
                                <article class="card card-post horizontal">
                                    @if(!is_null($avatar = $item->page->present()->writerAvatar(['width' => '80', 'height' => '80', 'fit' => 'crop', 'class' => 'rounded-pill card-img-gray'])))
                                    <a href="{{ $item->present()->url }}" title="{{ $item->title }}" class="flex-grow-0 d-flex align-items-center card-img flex-shrink-1" style="max-width: 80px; min-width: 80px;">
                                        {!! $avatar !!}
                                    </a>
                                    @endif
                                    <div class="card-body flex-grow-1 justify-content-center d-flex flex-column">
                                        <a href="{{ $item->page->present()->url }}" title="{{ $item->page->title }}" class="d-block" style="font-size: 14px; line-height: 1">{{ $item->page->title }}</a>
                                        @if(!is_null($name = $item->page->present()->writer['name']))<small class="d-block text-muted">{{ $name }}</small>@endif
                                        <h3 class="mt-1 card-title title-14">
                                            <a href="{{ $item->present()->url }}" title="{{ $item->title }}">
                                                {{ $item->title_short ?? $item->title }}
                                            </a>
                                        </h3>
                                    </div>
                                </article>
                            </li>
                            @endforeach
                        </ul>
                    </div>  
                    @endif 
                </div>
            </div>
        </div>
    </div>

    @php $advertsPageCurrent = App\Page::where('manager->type', 'App\\Advert')->where('publish', 1)->first(); @endphp
    @if($adverts->isNotEmpty())
    @php $advertsPageCurrent = App\Page::find($adverts->pluck('page_id')->first()); @endphp
    <div class="container mt-5">
        <div class="px-4 pb-4 mt-5 overflow-hidden border rounded border-primary">
            <div class="mb-5 d-flex w-100 align-items-end">
                <div class="box-title" style="margin-top: -1px;">{{ $advertsPageCurrent->title }}</div>
                <a href="{{ $advertsPageCurrent->present()->url }}" class="ml-auto"><small class="font-weight-bold">VER TODOS <i class="ml-1 lni lni-arrow-right"></i></small></a>
            </div>
          
            <div id="advert-carousel" class="owl-carousel" style="max-height: 500px; min-width: 100%;">
                @foreach ($adverts as $item)
                    @include('site.adverts._item', ['item' => $item])
                @endforeach
                <a href="{{ $advertsPageCurrent->present()->url }}" class="p-5 text-center text-white rounded bg-success d-flex align-items-center justify-content-center">
                    <strong>Crie seu anúncio grátis agora mesmo!</strong>
                </a>
            </div>

            <a href="{{ $advertsPageCurrent->present()->url }}" class="rounded btn btn-success btn-sm mt-5">Criar <span class="d-none d-md-inline">anúncio</span> grátis</a>
        </div>        
    </div>
    @elseif($advertsPageCurrent !== null) 
    <div class="container mt-5">
        <div class="p-5 text-center border rounded bg-light">
            <h3>Anuncie agora <strong>gratuitamente</strong> no {{ config('app.site.name') }}!</h3>
            <a href="{{ $advertsPageCurrent->present()->url }}" class="mt-5 rounded btn btn-success btn-lg">Criar seu anúncio grátis</a>
        </div>
    </div>
    @endif
@endsection
