@extends('site.__preview')

@section('page_title', $data->seo_title ?? $data->title)

@section('content')
    <div class="header">
        
    </div>

    <div class="container mt-5">
        <div class="ad">
            <div style="width: 970px; height: 90px; background-color: #CCC;"></div>
        </div>
    </div>

    <section class="container mb-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">       
                    <h1 class="show-title">{{ $data->title }}</h1>
                    @if((bool) strlen($description = $data->description))
                    <p class="show-description mt-3">{{ $description }}</p>
                    @endif
                    <div class="show-meta mt-5 mb-4 d-flex justify-content-between align-items-end">
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
                        <div style="opacity: .5; pointer-events: none; user-select: none;">
                            @include('site._share')
                        </div>
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
    
                    <div style="opacity: .5; pointer-events: none; user-select: none;">
                        @include('site._comments')
                    </div>
                </div>
    
            <aside class="col-12 col-md-4 mt-5 mt-md-0">
                <div class="ad mb-5">
                    <div style="width: 300px; height: 250px; background-color: #CCC;"></div>
                </div>

                <div style="width: 100%; height: 550px; background-color: #DDD;" class="mb-5"></div>

                <div class="ad mb-5">
                    <div style="width: 300px; height: 250px; background-color: #CCC;"></div>
                </div>

                @for ($i = 0; $i < 4; $i++)
                <div class="media mb-3">
                    <div style="width: 85px; height: 85px; background-color: #CCC;" class="mr-3 rounded-pill align-self-center"></div>
                    <div class="media-body align-self-center">
                        <h5 class="mt-0" style="width: 100px; height: 12px; background-color: #CCC;"></h5>
                        <div class="d-flex flex-wrap">
                            <div style="width: 50px; height: 12px; background-color: #CCC;" class="mr-2 mb-2"></div>
                            <div style="width: 80px; height: 12px; background-color: #CCC;" class="mr-2 mb-2"></div>
                            <div style="width: 150px; height: 12px; background-color: #CCC;" class="mr-2 mb-2"></div>
                            <div style="width: 40px; height: 12px; background-color: #CCC;" class="mr-2 mb-2"></div>
                            <div style="width: 30px; height: 12px; background-color: #CCC;" class="mr-2 mb-2"></div>
                            <div style="width: 180px; height: 12px; background-color: #CCC;" class="mr-2 mb-2"></div>
                            <div style="width: 50px; height: 12px; background-color: #CCC;" class="mr-2"></div>
                            <div style="width: 50px; height: 12px; background-color: #CCC;" class="mr-2"></div>
                        </div>
                    </div>
                </div>
                @endfor  

                <div style="width: 100%; height: 380px; background-color: #DDD;" class="mt-5"></div>
            </aside>
        </div>
    </section>

    <div class="footer mt-5">
        <div class="container d-flex flex-column justify-content-between align-items-center">
            <ul class="menu mt-4">
                <li class="mr-3"></li>
                <li class="mr-3"></li>
                <li class="mr-3"></li>
                <li></li>
            </ul>
            <div style="width: 100%; height: 1px; background-color: #eee" class="mt-4"></div>
            <div class="d-flex justify-content-between align-items-center">
                <div style="width: 230px; height: 12px; background-color: #eee" class="mt-4 mr-3"></div>
                <div style="width: 100px; height: 12px; background-color: #eee" class="mt-4 mr-3"></div>
                <div style="width: 600px; height: 12px; background-color: #eee" class="mt-4"></div>
            </div>
        </div>
    </div>
@endsection