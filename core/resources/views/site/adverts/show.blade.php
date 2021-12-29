@extends('site.__default')

@include('site._seo', compact('seo'))

@section('content')

@include('site._ad-top', ['class' => 'mt-5'])

<section class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-5" id="gallery">            
            <div class="{{ $data->getMedia('images')->count() > 1 ? "owl-carousel advert-gallery-carousel rounded" : "d-block" }}">
                @foreach ($data->getMedia('images') as $item)
                <a href="{{ $item->getUrl() }}" class="d-block gallery-item">
                    {!! $data->present()->img($item->getUrl(), ['width' => 540, 'height' => 540, 'fit' => 'crop', 'class' => 'img-fluid border rounded']) !!}
                </a>
                @endforeach
            </div>
        </div>

        <div class="col-12 col-md-7">
            <div class="mb-4 show-meta d-flex justify-content-between align-items-end">
                <ul class="list-group list-group-horizontal show-list">
                    <li class="list-group-item show-list-item">
                        <a href="javascript:window.history.back();" class="py-1 text-center border rounded btn btn-sm" title="Voltar">
                            <i class="lni lni-arrow-left"></i>
                        </a>
                    </li>
                </ul>
                @include('site._share')
            </div>
            <h1 class="show-title" style="font-size: 28px;">{{ $data->title }}</h1>
            @if((bool) strlen($where = $data->where))
            <p class="mt-3 show-description">Em {{ $where }}</p>
            @endif

            @if((bool) strlen($amount = $data->amount))
            <strong class="mb-3 d-block" style="font-size: 28px;">R$ {{ $amount }}</strong>
            @endif

            @if(!is_null($optional = $data->optional) && count($optional) > 0)
            <div class="py-3 border-top border-bottom show-meta">
                <strong class="mb-3 d-block">Items ou Opcionais</strong>
                <ul class="list-group list-group-horizontal show-list">
                    @foreach ($optional as $item)                        
                    <li class="list-group-item show-list-item">
                        @if(!is_null($item['icon']))
                        <i class="lni lni-alarm-clock"></i>
                        @endif
                        {{ $item['title'] }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if((bool) strlen($body = $data->body))
            <strong class="mt-3 mb-3 d-block" style="font-size: 14px;">Descrição</strong>
            <p class="show-text text-black-50" style="font-size: 14px;">{!! nl2br($body) !!}</p>
            @endif

            @if(!is_null($phones = $data->phones) && count($phones) > 0)
                <strong class="mt-3 mb-3 d-block" style="font-size: 14px;">Telefones</strong>
                @foreach ($phones as $item)
                    <div class="px-5 py-3 badge badge-success" style="font-size: 20px;"><i class="lni lni-phone"></i> {{ $item }}</div>
                @endforeach
            @endif
        </div>
    </div>
</section>

@include('site._view-register')
@endsection