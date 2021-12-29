@extends('site.__default')

@include('site._seo', compact('seo'))

@section('content')
<div class="section-title-page">
    <div class="container">
        <div class="row">
            <div class="order-1 col-12 order-md-0 col-md d-flex justify-content-center justify-content-md-start">
                <h1>
                    {{ $page->title }} 
                    @if(isset($category))
                    <span class="font-weight-lighter">&bull; {{ $category->title }}</span>
                    @endif
                </h1>
            </div>
            <div class="col-12 order-0 order-md-1 col-md d-flex align-items-center justify-content-md-end justify-content-center">
                <nav aria-label="breadcrumb">
                    <ol class="p-0 mb-0 mb-3 bg-transparent breadcrumb justify-content-center justify-content-md-end mb-md-0">
                        <li class="breadcrumb-item"><a href="/">Capa</a></li>
                        @if(isset($category))
                        <li class="breadcrumb-item"><a href="{{ $page->present()->url }}">{{ $page->title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $category->title }}</li>
                        @else
                        <li class="breadcrumb-item active">{{ $page->title }}</li>
                        @endif
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container">
    @include('site.pages._content')
</div>

@if(!is_null($current))
<section id="player" class="py-5 bg-wrapper bg-dark">
    @if((bool) strlen($banner = app('bannerService', [1, true, false])->toJson()))
        <div class="mb-5 bg-transparent ad" data-pos="1" data-ads="{!! $banner !!}"></div>
    @endif

    <div class="container container-video">    
        <div class="embed-responsive embed-responsive-16by9 d-flex justify-content-center flex-column align-items-center w-100">
            {!! str_replace('?', '?autoplay=1&', $current->script) !!}
        </div>
      
        <div class="pt-0 pb-0 mt-4 border-0 show-meta">
            <ul class="list-group list-group-horizontal show-list">
                <li class="list-group-item show-list-item">
                    <i class="lni lni-alarm-clock"></i>
                    <time datetime="{{ $current->created_at->toDateTimeLocalString() }}"> <strong>{{ $current->created_at->format('d/m/Y') }}</strong> às {{ $current->created_at->format('H:i') }} </time>
                </li>
            </ul>
        </div>
        <h1 class="mt-3 text-white font-weight-bold" style="font-size: 24px;">{{ $current->title }}</h1>
        @if((bool) strlen($description = $current->description))<p class="mb-0 show-description">{{ $description }}</p>@endif
    </div>
</section>
@else
    @if((bool) strlen($banner = app('bannerService', [1, true, false])->toJson()))
    <section class="container my-5">
        <div class="ad" data-pos="1" data-ads="{!! $banner !!}"></div>
    </section>
    @endif
@endif

<section class="container mt-5">
    <div class="d-flex justify-content-between">
        @if(!is_null($current))
        <div class="mb-5 rounded box-title">
            ASSISTA TAMBÉM
        </div>
        @endif

        @if(is_null($current) && !is_null($category))
        <div class="mb-5 section-title section-title-center">
            <small>Filtrando para:</small> {{ $category->title }}
        </div>
        @endif

        @php
        $allCategories = $page->categories;
        @endphp
        @if($allCategories->isNotEmpty())
        <div class="mb-5 btn-group">
            @if(is_null($current) && !is_null($category))
            <a class="bg-white border btn" href="{{ $page->present()->url }}"><i class="lni lni-close"></i> Limpar filtro</a>
            @endif

            <div class="btn-group">
                <button id="filter-category" type="button" class="bg-white border btn dropdown-toggle" data-toggle="dropdown">
                    Filtrar por categoria
                </button>
                <div class="dropdown-menu" aria-labelledby="filter-category">
                    @foreach ($allCategories as $item)
                    <a class="dropdown-item" href="{{ $item->present()->url }}">{{ $item->title }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    @if($datas->isNotEmpty())
    <div class="row row-cols-1 row-cols-md-3">
        @foreach ($datas as $item)
        <div class="mb-4 col">
            <article class="card card-post d-flex align-items-stretch">
                {!!
                    $item->present()->imgFirst(
                        $item->mediaCollection,
                        [
                            'width' => '378', 
                            'height' => '265', 
                            'fit' => 'crop', 
                            'class' => 'img-fluid',
                        ],
                        null,
                        ['class' => 'lazy']
                    )
                !!}
                <a href="{{ $item->present()->url('videos') }}#player" title="{{ $item->title }}" class="card-img-overlay">
                    @if($item->getTable() === "videos")<span class="card-subject-video">ASSISTA</span>@endif
                    <h2 class="card-title {{ $item->hasMedia($item->mediaCollection) ? 'title-18' : 'title-24' }}">{{ $item->title_short ?? $item->title }}</h2>
                    @if((bool) strlen($category = $item->present()->categoryTitleForFront))<time class="card-time">{{ $category }}</time>@endif
                </a>
            </article>
        </div>
        @endforeach
    </div>
    @else
    <span class="text-center">@include('site._empty')</span>
    @endif

    {!! $datas->isNotEmpty() ? '<div class="mt-5 d-flex justify-content-center">' . $datas->links(app('mobile-detect')->isMobile() ? 'pagination::simple-bootstrap-4' : null) . '</div>' : null !!}
</section>

@include('site._view-register')
@endsection