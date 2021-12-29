@extends('site.__default')

@include('site._seo', compact('seo'))

@section('content')

@include('site._ad-top', ['class' => 'mt-5'])

<section class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">           
            <div class="mb-4 show-meta d-flex justify-content-between align-items-center">
                <ul class="list-group list-group-horizontal show-list align-items-center">
                    <li class="list-group-item show-list-item">
                        <a href="javascript:window.history.back();" class="py-1 text-center border btn btn-sm" title="Voltar">
                            <i class="lni lni-arrow-left"></i>
                        </a>
                    </li>
                    @if(!is_null($data->unpublished_at))
                    <li class="list-group-item show-list-item">
                        Termina em
                        <i class="lni lni-alarm-clock"></i>
                        <time datetime="{{ $data->unpublished_at->toDateTimeLocalString() }}"> <strong>{{ $data->unpublished_at->format('d/m/Y') }}</strong> às {{ $data->unpublished_at->format('H:i') }}</time>
                    </li>
                    @endif
                </ul>
                @include('site._share')
            </div>
            <div class="clearfix text-justify show-text" id="gallery">
                <button type="button" data-goto="{{ !is_null($data->mode) ? '#promotions-form' : '#show-title' }}" class="btn btn-warning btn-block btn-lg">
                    <span class="d-block" style="font-size: 28px;"><i class="lni lni-gift"></i> QUERO PARTICIPAR</span>
                    @if(!is_null($data->mode))
                    <small>Para participar preencha o formulário de participação ao final da página.</small>
                    @else
                    <small>Leia abaixo e saiba como participar.</small>
                    @endif
                </button>

                @if($data->hasMedia('image'))
                <div class="show-image">
                    <a href="{{ $data->getFirstMediaUrl('image') }}" class="d-block gallery-item">
                        {!! $data->present()->imgFirst('image', ['width' => '823', 'fit' => 'crop', 'class' => 'img-fluid'], null, ['class' => 'lazy']) !!}
                    </a>
                </div>
                @endif

                <h1 class="mb-5 show-title" id="show-title">{{ $data->title }}</h1>
                
                {!! $data->present()->bodyHtml !!}
            </div>

            @if(!is_null($data->mode))
            @include('site.promotions._form')
            @endif
        </div>

        <aside class="mt-5 col-12 col-md-4 mt-md-0">
            @include('site._sidebar')
        </aside>
    </div>
</section>

@include('site._view-register')
@endsection