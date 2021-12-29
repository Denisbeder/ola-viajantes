@extends('admin.__admin')

@php
$pageName = 'Comentários';
@endphp

@section('page_title')
{{ $pageName }} | {{ config('app.admin.name') }}
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mB-30">
    <h4 class="c-grey-900 mb-0">{{ $pageName }}</h4>
    @if($records->isNotEmpty() || !empty(request()->except('page')))
    <div class="d-flex align-items-center justify-content-end">
        <div class="form-row justify-content-end">
            <div class="col">
                @include('admin._mass-action', ['duplicate' => false])
            </div>
            <div class="col-auto">
                @if (!empty(request()->except('page')))
                <a href="{{ request()->url() }}" class="btn btn-light border bg-white" title="Limpar filtros"><i class="ti-close"></i> Limpar filtros</a>
                @endif
            </div>
            <div class="col-auto">
                @include('admin._clear-cache-btn', ['model' => 'Comment,' . App\Page::where('manager->type', 'App\Post')->pluck('slug')->implode(',')])
            </div>
        </div>
    </div>
    @endif
</div>

@if($records->isNotEmpty() || !empty(request()->except('page')))
<div class="bgc-white bd bdrs-3">
    @include('admin.comments._table')
    <div class="p-20">
        <div class="row">
            <div class="col d-flex align-items-center">Total de registros {{ number_format($records->total(), 0, '', '.') }}</div>
            <div class="col d-flex align-items-center justify-content-end">{!! $records->appends(request()->all())->links() !!}</div>
        </div>
    </div>
</div>
@else
@include('admin._index-empty', ['button' => false, 'message' => 'Nenhum registro aqui ainda.'])
@endif
@endsection