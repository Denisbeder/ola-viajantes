@extends('admin.__admin')

@php
    $pageName = 'SEO';
@endphp

@section('page_title')
{{ $pageName }} | {{ config('app.admin.name') }}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-6">
        <h4 class="c-grey-900 mB-30">{{ $pageName }}</h4>
    </div>
    @if($records->isNotEmpty())
    <div class="col-lg-6 d-flex align-items-start justify-content-end">
        @include('admin._mass-action', ['duplicate' => false, 'publish' => false, 'unpublish' => false])
    </div>
    @endif
</div>

@if($records->isNotEmpty())
<div class="bgc-white bd bdrs-3">
    @include('admin.seo._table')
    <div class="p-20">
        <div class="row">
            <div class="col d-flex align-items-center">Total de registros {{ $records->total() }}</div>
            <div class="col d-flex align-items-center justify-content-end">{!! $records->links() !!}</div>
        </div>
    </div>
</div>
@else
@include('admin._index-empty', ['message' => 'Nenhum registro aqui ainda.', 'button' => false])
@endif
@endsection