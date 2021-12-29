@extends('site.__default')

@include('site._seo', compact('seo'))

@section('content')
<div class="mb-5 section-title-page">
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

@include('site._ad-top')

<section class="container">
    <div class="row">
        <div class="col-12 col-md-8">
            @include('site.pages._content')
            
            <div class="row row-cols-1 row-cols-md-2">
                @forelse ($datas as $item)
                <div class="mb-4 col">
                    <article class="card card-post d-flex align-items-stretch">
                        {!!
                            $item->present()->imgFirst(
                                $item->mediaCollection,
                                [
                                    'width' => '378', 
                                    'height' => '378', 
                                    'fit' => 'crop', 
                                    'class' => 'img-fluid',
                                ],
                                null,
                                ['class' => 'lazy']
                            )
                        !!}
                        <a href="{{ $item->present()->url }}" title="{{ $item->title }}" class="card-img-overlay">
                            <h2 class="card-title {{ $item->hasMedia($item->mediaCollection) ? 'title-18' : 'title-24' }}">{{ $item->title }}</h2>
                            @if((bool) strlen($category = $item->present()->categoryTitleForFront))<time class="card-time">{{ $category }}</time>@endif
                        </a>
                    </article>
                </div>
                @empty
                {{-- Vazio --}}
                @endforelse
            </div>

            {!! $datas->isNotEmpty() ? '<nav>' . $datas->links(app('mobile-detect')->isMobile() ? 'pagination::simple-bootstrap-4' : null) . '</nav>' : null !!}
        </div>

        <aside class="mt-5 col-12 col-md-4 mt-md-0">
            @include('site._sidebar')
        </aside>
    </div>
</section>

@include('site._view-register')
@endsection