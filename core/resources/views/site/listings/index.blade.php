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

<section class="container">
    <div class="row">
        <div class="col-12 col-md-8">
            @include('site.pages._content')
            
            @php
            $nodes = $datas->toTree();

            $medias = function ($data) {
                $items = $data->getMedia('images');
                if ($items->isEmpty()) {
                    return null;
                }
                $template = '<div class="float-left px-0 mb-3 mr-3 col-12 col-md-6" id="gallery">';
                $template .= '<div class="owl-carousel gallery-carousel">';
                foreach ($items as $item) {
                    $template .= '<a href="' . $item->getUrl() . '" class="d-block gallery-item">';
                    $template .= $data->present()->img($item->getUrl(), ['width' => 390, 'height' => 274, 'fit' => 'crop', 'class' => 'img-fluid rounded'], null, ['class' => 'lazy']);
                    $template .=  '</a>';
                }
                $template .= '</div>';
                $template .= '</div>';

                return $template;
            };

            $tree = function ($datas, $prefix = false) use (&$tree, $medias, $page) {
                $template = '<div class="accordion" id="accordion-'.$page->slug.'">';
                foreach ($datas as $k => $data) {
                    $show = $k === 0 && !$prefix ? 'show' : null;
                    $prefix = $prefix ? $prefix : $page->slug;
                    $template .= '<div class="card">';
                    $template .= '<div class="p-4 text-left card-header bg-light btn btn-link" data-toggle="collapse" data-target="#collapse-'.$data->id.'">';
                    $template .= '<strong>' . $data->title . '</strong> ';
                    $template .= '</div>';
                    $template .= '<div id="collapse-'.$data->id.'" class="collapse '.$show.'" data-parent="#accordion-'. $prefix .'">';
                    $template .= '<div class="clearfix card-body">';
                    $template .=  $medias($data);
                    $template .= $data->present()->bodyHtml;
                    $template .= '<a href="'.$data->present()->url.'" class="py-1 border btn btn-link btn-sm">Abrir</a>';
                    $template .= '</div>';

                    if ($data->children->isNotempty()) {
                        $template .= '<div class="accordion" id="accordion-'.$data->slug.'">';
                        $template .= '<div class="card-body">';
                        $template .= $tree($data->children, $data->slug);
                        $template .= '</div>';
                        $template .= '</div>';
                    }

                    $template .= '</div>';
                    $template .= '</div>';
                }
                $template .= '</div>';
                return $template;
            };

            echo $tree($nodes);
            @endphp

            {!! $datas->isNotEmpty() ? '<nav>' . $datas->links(app('mobile-detect')->isMobile() ? 'pagination::simple-bootstrap-4' : null) . '</nav>' : null !!}
        </div>

        <aside class="mt-5 col-12 col-md-4 mt-md-0">
            @include('site._sidebar')
        </aside>
    </div>
</section>
@endsection