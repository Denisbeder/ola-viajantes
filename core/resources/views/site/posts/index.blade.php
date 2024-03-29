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

            @forelse ($datas as $item)
                <article class="mb-5 card card-post horizontal">
                    @if($item->hasMedia($item->mediaCollection))
                    <a href="{{ $item->present()->url }}" title="{{ $item->title }}" class="d-block card-img">
                        {!!
                            $item->present()->imgFirst(
                                $item->mediaCollection,
                                [
                                    'width' => '300', 
                                    'height' => '225', 
                                    'fit' => 'crop',
                                ],
                                null,
                                //['class' => 'lazy']
                            )
                        !!}
                    </a>
                    @endif
                    <div class="card-body">
                        @if((bool) strlen($subject = $item->present()->subject))<p class="card-subject">{{ $subject }}</p>@endif
                        <h2 class="card-title title-20">
                            <a href="{{ $item->present()->url }}" title="{{ $item->title }}">
                                {{ $item->title_short ?? $item->title }}
                            </a>
                        </h2>
                        <time class="card-time"><i class="mr-1 lni lni-alarm-clock"></i> {{ $item->present()->forHumans }} {{ $item->present()->categoryTitleForFront }}</time>
                        <p class="mt-1 card-text summary d-none d-md-block">{{ $item->present()->summary }}</p>
                    </div>
                </article>
            @empty
            {{-- Vazio --}}
            @endforelse

            {!! $datas->isNotEmpty() ? $datas->links(app('mobile-detect')->isMobile() ? 'pagination::simple-bootstrap-4' : null) : null !!}
        </div>

        <aside class="mt-5 col-12 col-md-4 mt-md-0">            
            @include('site._sidebar')
        </aside>
    </div>
</section>
@endsection