@extends('admin.__admin')

@php
$pageName = 'Promoções Participantes';
$pageSelected = $page->title ?? '';
@endphp

@section('page_title')
{{ $pageSelected }} {!! !$pageSelected ? null : '&ndash;' !!} {{ $pageName }} | {{ config('app.admin.name') }}
@endsection


@empty(!$page)
@section('content')
<div class="row">
    <div class="col-lg-6">
        <h4 class="c-grey-900 mB-10">{{ $pageSelected}} <small>&ndash; {{ $pageName }}</small></h4>
        <h2 class="c-grey-900 mB-30">{{ $promotion->title }}</h2>
    </div>
    @if($records->isNotEmpty())
    <div class="col-lg-6 d-flex text-right align-items-end mB-20 justify-content-end">
        <div class="form-row justify-content-end">
            <div class="col-auto">
                @include('admin._clear-cache-btn', ['model' => 'PromotionParticipant,' . $page->slug])
            </div>
            <div class="col">
                <a href="{{ route('promotions.index') }}" class="btn bg-white border">Voltar</a>
            </div>
            <div class="col-auto">
                @include('admin._mass-action', [
                'duplicate' => false,
                'publish' => false,
                'unpublish' => false,
                ])
            </div>
        </div>
    </div>
    @endif
</div>

<div class="row">
    <div class="col-4">
        @include('admin.promotionsparticipants._drawn')
        @include('admin.promotionsparticipants._form')
    </div>
    <div class="col-8">
        @if($records->isNotEmpty())
        <div class="bgc-white p-20 bd bdrs-3">
            <h4>Participantes</h4>
            @include('admin.promotionsparticipants._table')
            <div class="pT-20">
                <div class="row">
                    <div class="col d-flex align-items-center">Total de registros {{ $records->total() }}</div>
                    <div class="col d-flex align-items-center justify-content-end">{!! $records->appends(request()->query())->links() !!}</div>
                </div>
            </div>
        </div>
        @else
        @include('admin._index-empty', [
        'button' => '<a href="'.route('promotions.index', ['ps' => request()->query('ps')]).'" class="btn btn-lg btn-primary mt-3">Voltar</a> ',
        'message' => 'Nenhum participante encontrado.'
        ])
        @endif
    </div>
</div>
@endsection
@endempty