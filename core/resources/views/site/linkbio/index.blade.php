@extends('site.__linkbio')

{{-- @include('site._seo', compact('seo')) --}}

@section('content')
    <div class="container flex-column align-items-center d-flex justify-content-center" style="max-width: 680px;">
        <a class="mt-5 mb-8" target="_blank" href="/" title="{{ config('app.site.name') }}">
            <img src="/assets/site/svg/logo-color.svg" class="logo" alt="{{ config('app.site.name') }}" />
        </a>    
        <a href="/" class="mb-3 border border-secondary btn-sm btn btn-default btn-block">Visitar site</a>
        <div class="mb-3 mx-n1 row row-cols-3 align-self-start"> 
            @forelse ($datas as $item)
            <div class="p-1 col" style="min-width: 211px;">
                <article class="mb-0 card card-post d-flex align-items-stretch">
                    <a href="{{ $item->url }}" target="_blank" class="card-img">
                        {!!
                            $item->present()->imgFirst(
                                'default',
                                [
                                    'width' => '211', 
                                    'height' => '211', 
                                    'fit' => 'crop', 
                                    'class' => 'img-fluid rounded-0',
                                ],
                            )
                        !!}
                    </a>
                </article>
            </div>
            @empty
            {{-- Vazio --}}
            @endforelse
        </div>
        {!! $datas->isNotEmpty() ? $datas->links(app('mobile-detect')->isMobile() ? 'pagination::simple-bootstrap-4' : null) : null !!}
    </div>
@endsection