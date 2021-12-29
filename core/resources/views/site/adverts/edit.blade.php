@extends('site.__default')

{{-- @section('page_url', request()->url())
@section('page_type', 'NewsArticle')
@section('page_headline', $data->title)
@section('page_title', sprintf('%s | %s', $data->seo_title ?? $data->title, config('app.site.name')))
@section('page_description', $data->seo_description)
@section('page_published', $data->published_at->toDateTimeLocalString())
@section('page_updated', $data->updated_at->toDateTimeLocalString())
@section('page_author', $data->author)

@if((bool) strlen($seo_keywords = $data->seo_keywords))
@section('page_keywords', $seo_keywords)
@endif


@if(!empty($data->images))
@section('page_image', sprintf('%s/image/%s', config('app.url'), head($data->images)['path']))
@php $imageInfos = imageInfos(storage_path('app/'.head($data->images)['path'])); @endphp
@section('page_image_width', $imageInfos['width'])
@section('page_image_height', $imageInfos['height'])
@else
@section('page_image', config('app.url') . '/imagedefault')
@endif --}}

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
                        <li class="breadcrumb-item"><a href="{{ $page->present()->url }}">{{ $page->title }}</a></li>                        
                        <li class="breadcrumb-item active" aria-current="page">Editar</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>


<section class="container mt-8 mb-8">
    <div class="row justify-content-center">
        <div class="col-12">
            <form action="" method="post" data-method="put" id="adverts-form">
                @include('site.adverts._form')
                <button type="submit" class="mt-4 btn btn-success">Salvar</button>
            </form>
            <a href="{{ $data->present()->urlDelete }}" class="mt-4 btn btn-danger" onclick="return confirm('Você tem certeza que deseja fazer isso?\nEsta ação é irreversível.');">Excluir esse anúncio</a>
            <br />
            <a href="{{ $page->present()->url }}" class="mt-4 border btn btn-light">Cancelar e voltar</a>
        </div>
    </div>
</section>
@endsection