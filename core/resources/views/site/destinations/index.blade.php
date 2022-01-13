@extends('site.__default')

@include('site._seo', compact('seo'))

@section('content')
<div class="mb-5 section-title-page">
    <div class="container">
        <div class="row">
            <div class="order-1 col-12 order-md-0 col-md d-flex justify-content-center justify-content-md-start">
                <h1>Destinos</h1>
            </div>
            <div class="col-12 order-0 order-md-1 col-md d-flex align-items-center justify-content-md-end justify-content-center">
                <nav aria-label="breadcrumb">
                    <ol class="p-0 mb-0 mb-3 bg-transparent breadcrumb justify-content-center justify-content-md-end mb-md-0">
                        <li class="breadcrumb-item"><a href="/">Capa</a></li>
                        <li class="breadcrumb-item active">Destinos</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="container">
    <div class="row">
        <div class="col-12 col-md-8">  
            @foreach($tree as $data)
                    @if($data->descendants->isNotEmpty())
                        <div class="box-title mb-3">{{ $data->title }}</div>
                        <div class="row">
                            @foreach($data->descendants->sortBy('title') as $item)
                                <div class="col-3">
                                    <article class="card card-post mb-5" style="height: 198px;">
                                        {!!
                                            $item->present()->imgFirst(
                                                $item->mediaCollection,
                                                [
                                                    'width' => 198, 
                                                    'height' => 198, 
                                                    'fit' => 'crop', 
                                                    'class' => 'img-fluid',
                                                ],
                                                null,
                                                ['class' => 'lazy']
                                            )
                                        !!}
                                        <a href="{{ $item->present()->url }}" title="{{ $item->title }}" class="card-img-overlay p-3 {{ !$item->hasMedia($item->mediaCollection) ? 'border bg-light text-center' : null }}">
                                            <h1 class="card-title title-18">{{ $item->title }}</h1>
                                        </a>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    @endif
            @endforeach
        </div>

        <aside class="mt-5 col-12 col-md-4 mt-md-0">
            @include('site._sidebar')
        </aside>
    </div>
</section>
@endsection