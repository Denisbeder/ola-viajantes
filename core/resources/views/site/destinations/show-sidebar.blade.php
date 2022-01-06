@extends('site.__default')

@include('site._seo', compact('seo'))

@section('content')

@include('site._ad-top')

<section class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">           
            <div class="mb-4 show-meta d-flex justify-content-between align-items-end">
                <ul class="list-group list-group-horizontal show-list">
                    <li class="list-group-item show-list-item">
                        <a href="javascript:window.history.back();" class="py-1 text-center border btn btn-sm" title="Voltar">
                            <i class="lni lni-arrow-left"></i>
                        </a>
                    </li>
                    @if(!is_null($category = optional($data->category)->title))
                    <li class="list-group-item show-list-item">
                        <i class="lni lni-bookmark"></i>
                        <a href="{{ $data->category->present()->url }}">{{ $category }}</a>
                    </li>
                    @endif
                </ul>
                @include('site._share')
            </div>
            <h1 class="mb-5 show-title">{{ $data->title }}</h1>
            <div class="clearfix text-justify show-text" id="gallery">
                @if($data->hasMedia('images'))
                <div class="owl-carousel gallery-carousel">
                    @foreach ($data->getMedia('images') as $item)
                        <a href="{{ $item->getUrl() }}" class="d-block gallery-item w-100">
                            {!! $data->present()->img($item->getUrl(), ['width' => 822, 'height' => 325, 'fit' => 'crop', 'class' => 'img-fluid rounded', 'style' => 'width: 100%'], null) !!}
                        </a>                        
                    @endforeach
                </div>
                @endif
                                 
                {!! $data->present()->bodyHtml !!}
            </div>
        </div>

        <aside class="mt-5 col-12 col-md-4 mt-md-0">
            @include('site._sidebar')
        </aside>
    </div>
</section>

@include('site._view-register')
@endsection