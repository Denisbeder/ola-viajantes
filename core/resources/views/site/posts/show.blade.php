@extends('site.__default')

@include('site._seo', compact('seo'))

@section('content')

@include('site._ad-top', ['class' => 'mt-5'])

<section class="container mb-8 mt-8">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">       
                <h1 class="show-title">{{ $data->title }}</h1>
                @if((bool) strlen($description = $data->description))
                <p class="show-description mt-3">{{ $description }}</p>
                @endif
                <div class="show-meta mt-5 mb-4 d-flex justify-content-between align-items-center">
                    <ul class="list-group list-group-horizontal show-list">
                        @if((bool) strlen($author = $data->present()->writerAuthor))
                        <li class="list-group-item show-list-item">
                            {!! $author !!}
                        </li>
                        @endif                           
                        @if((bool) strlen($source = $data->source))
                        <li class="list-group-item show-list-item">
                            <i class="lni lni-slice"></i> {{ $source }}
                        </li>
                        @endif
                        @if(!is_null($category = optional($data->category)->title))
                        <li class="list-group-item show-list-item">
                            <i class="lni lni-bookmark"></i>
                            <a href="{{ $data->category->present()->url }}">{{ $category }}</a>
                        </li>
                        @endif
                        <li class="list-group-item show-list-item">
                            <i class="lni lni-alarm-clock"></i>
                            <time datetime="{{ $data->published_at->toDateTimeLocalString() }}"> <strong>{{ $data->published_at->format('d/m/Y') }}</strong> às {{ $data->published_at->format('H:i') }}</time>
                        </li>
                        @if(($commentsTotal = $data->comments->count()) > 0)
                        <li class="list-group-item show-list-item">
                            <i class="lni lni-comments-alt"></i>
                            <a href="javascript:;" data-goto="#comments">{{ $commentsTotal }} <span class="d-none d-md-inline">comentários</span></a>
                        </li>
                        @endif
                    </ul>
                    @include('site._share')
                </div>
                <div class="show-text clearfix" id="gallery">
                    @if((bool) $data->cover_inside && $data->hasMedia('images'))
                    <div class="show-image left">
                        <a href="{{ $data->getFirstMediaUrl($data->mediaCollection) }}" class="d-block gallery-item">
                            {!! $data->present()->imgFirst($data->mediaCollection, ['width' => '327', 'fit' => 'crop', 'class' => 'img-fluid'], $data->getFirstMedia('images')->getCustomProperty('caption') ) !!}
                        </a>
                        <p>{{ $data->getFirstMedia('images')->getCustomProperty('caption') }}</p>
                    </div>
                    @endif

                    {!! $data->present()->bodyHtml !!}

                    <div class="row row-cols-3 mt-5">
                        @foreach ($data->getMedia($data->mediaCollection)->skip(1) as $item)
                        <div class="col mb-4">
                            <a href="{{ $item->getUrl() }}" class="d-block gallery-item">
                                {!! $data->present()->img($item->getUrl(), ['width' => 295, 'height' => 207, 'fit' => 'crop', 'class' => 'img-fluid rounded'], $item->getCustomProperty('caption'), ['class' => 'lazy']) !!}
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>

                @include('site._comments')
            </div>

        <aside class="col-12 col-md-4 mt-5 mt-md-0">
            @if(request()->is('colunas/*/*'))
                @include('site._sidebar-columns')
            @else
                @include('site._sidebar')
            @endif
        </aside>
    </div>
</section>
@endsection