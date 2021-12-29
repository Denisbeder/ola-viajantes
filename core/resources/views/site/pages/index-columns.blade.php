@extends('site.__default')

@include('site._seo', compact('seo'))

@section('content')
<div class="mb-5 section-title-page">
    <div class="container">
        <div class="row">
            <div class="order-1 col-12 order-md-0 col-md d-flex justify-content-center justify-content-md-start">
                <h1>
                    {{ $page->title }} 
                </h1>
            </div>
            <div class="col-12 order-0 order-md-1 col-md d-flex align-items-center justify-content-md-end justify-content-center">
                <nav aria-label="breadcrumb">
                    <ol class="p-0 mb-0 mb-3 bg-transparent breadcrumb justify-content-center justify-content-md-end mb-md-0">
                        <li class="breadcrumb-item"><a href="/">Capa</a></li>
                        <li class="breadcrumb-item active">{{ $page->title }}</li>
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
            @if((bool) strlen($page->body))
            <div class="mb-5 show-text">
                {!! $page->present()->bodyHtml !!}
            </div>
            @endif
            
            <div class="card-deck">
                @forelse ($datas as $item)
                    <a href="{{ $item->present()->url }}" class="mb-5 text-center card card-post card-post-no-left-mobile">
                        {!! $item->present()->writerAvatar(['width' => '160', 'height' => '160', 'fit' => 'crop', 'class' => 'card-img mb-3 img-fluid rounded-pill mx-auto', 'style' => 'width: min-content;']) !!}
                        <div class="card-body">
                            <p class="card-text d-none d-md-block">
                                {!! $item->present()->writerName !!}
                            </p>
                            <h2 class="card-title" style="font-size: 26px;">{{ $item->title }}</h2>
                        </div>
                    </a>
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
@endsection