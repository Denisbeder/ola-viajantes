@extends('site.__default')

@include('site._seo', compact('seo'))

@section('content')
    <div class="pt-8 mb-5 pt-md-12 border-bottom mt-md-n6 position-relative">
        <div class="show-header" style="background-image: url({{ $data->getFirstMediaUrl($data->mediaCollection) }});"></div>
        <div class="container d-flex flex-column">        
            <h1 class="show-title">{{ $data->title }}</h1>
            @if((bool) strlen($description = $data->description))
            <p class="mt-3 mb-0 show-description">{{ $description }}</p>
            @endif            
        </div>

        <div class="mt-5 border-top border-secondary">
            <div class="container">
                <div class="border-0 show-meta d-flex justify-content-between align-items-end">
                    <ul class="list-group list-group-horizontal show-list">
                        @if((bool) strlen($author = $data->present()->writerAuthor))
                        <li class="list-group-item show-list-item border-secondary">
                            {!! $author !!}
                        </li>
                        @endif                           
                        @if((bool) strlen($source = $data->source))
                        <li class="list-group-item show-list-item border-secondary">
                            <i class="lni lni-slice"></i> {{ $source }}
                        </li>
                        @endif
                        @if(!is_null($category = optional($data->category)->title))
                        <li class="list-group-item show-list-item border-secondary">
                            <i class="lni lni-bookmark"></i>
                            <a href="{{ $data->category->present()->url }}">{{ $category }}</a>
                        </li>
                        @endif
                        <li class="list-group-item show-list-item border-secondary">
                            <i class="lni lni-alarm-clock"></i>
                            <time datetime="{{ $data->published_at->toDateTimeLocalString() }}"> <strong>{{ $data->published_at->format('d/m/Y') }}</strong> às {{ $data->published_at->format('H:i') }}</time>
                        </li>
                        @if(($commentsTotal = $data->comments->count()) > 0)
                        <li class="list-group-item show-list-item border-secondary">
                            <i class="lni lni-comments-alt"></i>
                            <a href="javascript:;" data-goto="#comments">{{ $commentsTotal }} <span class="d-none d-md-inline">comentários</span></a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>    
        </div>        
    </div>

    @include('site._ad-top', ['class' => 'mt-5'])

    <section class="container">
        <div class="row">
            <div class="col-1">
                <div class="sticky-top show-share-sticky-top">
                    @include('site._share', ['showSpeech' => true])
                </div>
            </div>
            <div class="col-12 col-md-11">              
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="clearfix show-text" id="gallery">
                            @if((bool) $data->cover_inside && $data->hasMedia('images'))
                            <div class="show-image left">
                                <a href="{{ $data->getFirstMediaUrl($data->mediaCollection) }}" class="d-block gallery-item">
                                    {!! $data->present()->imgFirst($data->mediaCollection, ['width' => '327', 'fit' => 'crop', 'class' => 'img-fluid'], $data->getFirstMedia('images')->getCustomProperty('caption') ) !!}
                                </a>
                                <p>{{ $data->getFirstMedia('images')->getCustomProperty('caption') }}</p>
                            </div>
                            @endif
            
                            {!! $data->present()->bodyHtml !!}
                            
                            @if(count($images = $data->getMedia($data->mediaCollection)->skip(1)) > 0)
                            <div class="mt-5 row row-cols-3">
                                @foreach ($images as $item)
                                <div class="mb-4 col">
                                    <a href="{{ $item->getUrl() }}" class="d-block gallery-item">
                                        {!! $data->present()->img($item->getUrl(), ['width' => 295, 'height' => 207, 'fit' => 'crop', 'class' => 'img-fluid rounded'], $item->getCustomProperty('caption'), ['class' => 'lazy']) !!}
                                    </a>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        @include('site._comments')
                        @include('site.posts._related')                        
                    </div>
                    <aside class="mt-5 col-12 col-md-4 mt-md-0">
                        @if (request()->is('colunas/*/*'))
                            @include('site._sidebar-columns')
                        @else
                            @include('site._sidebar')
                        @endif
                    </aside>
                </div>
            </div>
        </div>
    </section>

    @include('site._view-register')
@endsection
