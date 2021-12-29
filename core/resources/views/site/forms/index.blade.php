@extends('site.__default')

@include('site._seo', compact('seo'))

@section('content')
<div class="mb-5 section-title-page">
    <div class="container">
        <div class="row">
            <div class="order-1 col-12 order-md-0 col-md d-flex justify-content-center justify-content-md-start">
                <h1>
                    {{ $page->title }} 
                </h1>
            </div>
            <div class="col-12 order-0 order-md-1 col-md d-flex align-items-center justify-content-md-end justify-content-center">
                <nav aria-label="breadcrumb">
                    <ol class="p-0 mb-0 mb-3 bg-transparent breadcrumb justify-content-center justify-content-md-end mb-md-0">
                        <li class="breadcrumb-item"><a href="/">Capa</a></li>
                        <li class="breadcrumb-item active">{{ $page->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

@include('site._ad-top')

<section class="container">
    <div class="row">
        <div class="col-12 col-md-8">
            @include('site.pages._content')
            
            @if(!is_null($data))
                @include('site.forms._messages')
                {!! $data->present()->renderForm !!}
            @endif
        </div>

        <aside class="mt-5 col-12 col-md-4 mt-md-0">
            @include('site._sidebar')
        </aside>
    </div>
</section>
@endsection