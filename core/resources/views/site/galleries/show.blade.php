@extends('site.__default')

@include('site._seo', compact('seo'))

@section('content')

@include('site._ad-top', ['class' => 'mt-5'])

<section class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <h1 class="show-title">{{ $data->title }}</h1>
            <div class="mt-5 mb-4 show-meta d-flex justify-content-between align-items-center">
                <ul class="list-group list-group-horizontal show-list d-flex align-items-center">
                    <li class="list-group-item show-list-item">
                        <i class="lni lni-alarm-clock"></i>
                        <time datetime="{{ $data->created_at->toDateTimeLocalString() }}"> <strong>{{ $data->created_at->format('d/m/Y') }}</strong> às {{ $data->created_at->format('H:i') }}</time>
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
            <div class="clearfix text-justify show-text" id="gallery">
                @if((bool) strlen($description = $data->description))
                <p>{!! nl2br($description) !!}</p>
                @endif
                
                @if($data->hasMedia('images'))
                <div class="mt-5 row row-cols-3">
                    @foreach ($data->getMedia('images') as $item)
                    <div class="mb-4 col">
                        <a href="{{ $item->getUrl() }}" class="d-block gallery-item">
                            {!! $data->present()->img($item->getUrl(), ['width' => 295, 'height' => 207, 'fit' => 'crop', 'class' => 'img-fluid rounded'], null, ['class' => 'lazy']) !!}
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <aside class="mt-5 col-12 col-md-4 mt-md-0">
            @include('site._sidebar')
        </aside>
    </div>
</section>

@include('site._view-register')
@endsection