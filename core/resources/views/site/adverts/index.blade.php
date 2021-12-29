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
    @include('supports._messages')
    <div class="row">
        @include('site.pages._content')
        
        <aside class="col-12 col-md-3">
            <button class="mb-md-5 mb-3 rounded btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#adverts-modal">
                CRIAR ANÚNCIO GRÁTIS <i class="lni lni-circle-plus ml-2"></i>
            </button>

            @if(app('mobile-detect')->isMobile())

                <button class="btn btn-light border btn-block" type="button" data-toggle="modal" data-target="#filter-modal">
                    <i class="lni lni-funnel mr-2"></i> Filtrar
                </button>
                
                <div class="modal fade" id="filter-modal" tabindex="-1" aria-labelledby="filter-modalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="filter-modalLabel">Filtros</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @include('site.adverts._filters')
                            </div>
                        </div>
                    </div>
                </div>
            @else
                @include('site.adverts._filters')
            @endif                     
        </aside>

        <div class="mt-5 col-12 col-md-9 mt-md-0">
            <div class="row">
                @forelse ($datas as $item)
                @include('site.adverts._item', ['item' => $item, 'class' => ' mb-5 col-12 col-md-3', 'lazy' => ['class' => 'lazy']])
                @empty
                {{-- Vazio --}}
                @endforelse
            </div>

            {!! $datas->isNotEmpty() ? '<nav>' . $datas->links(app('mobile-detect')->isMobile() ? 'pagination::simple-bootstrap-4' : null) . '</nav>' : null !!}
        </div>
    </div>
</section>

@include('site.adverts._modal')
@endsection