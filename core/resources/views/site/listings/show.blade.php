@extends('site.__default')

@include('site._seo', compact('seo'))

@section('content')

@include('site._ad-top')

<section class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="row">
                <div class="col-12 col-md-1">
                    @include('site._share')
                    <div class="mt-4 shadow-none list-group">
                        <a href="javascript:window.history.back();" class="px-0 text-center list-group-item list-group-item-action" title="Voltar">
                            <i class="lni lni-arrow-left"></i>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-11">
                    @if(!is_null($category = optional($data->category)->title))
                    <div class="mb-4 show-meta">
                        <ul class="list-group list-group-horizontal show-list">        
                            <li class="list-group-item show-list-item">
                                <i class="lni lni-bookmark"></i>
                                <a href="{{ $data->category->present()->url }}">{{ $category }}</a>
                            </li>
                        </ul>
                    </div>
                    @endif
                    <h1 class="mb-5 show-title">{{ $data->title }}</h1>
                    <div class="clearfix text-justify show-text" id="gallery">
                        @if($data->hasMedia('images'))
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="owl-carousel gallery-carousel">
                                    @foreach ($data->getMedia('images') as $item)
                                        <a href="{{ $item->getUrl() }}" class="d-block gallery-item">
                                            {!! $data->present()->img($item->getUrl(), ['width' => 505, 'height' => 352, 'fit' => 'crop', 'class' => 'img-fluid rounded'], null) !!}
                                        </a>                        
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                {!! $data->present()->bodyHtml !!}
                            </div>
                        </div>                        
                        @else
                        {!! $data->present()->bodyHtml !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('site._view-register')
@endsection