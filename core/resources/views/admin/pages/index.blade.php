@extends('admin.__admin')

@php
    $pageName = 'Páginas';
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
        <div class="form-row justify-content-end">
            <div class="col">
                {!! Form::cSelect('mass-action', null,
                ['Ação em massa', 'delete' => 'Deletar', 'publish' => 'Publicar', 'unpublish' => 'Não publicar', 'duplicate' => 'Duplicar'], null, ['class' => 'form-control bg-transparent', 'data-target' => '.check-single', 'style' => 'display: none;']) !!}
            </div>
            <div class="col-auto">
                @include('admin._clear-cache-btn', ['model' => 'Page,' . App\Page::pluck('slug')->implode(',')])
            </div>
            @if(auth()->user()->isSuperAdmin)
            <div class="col flex-shrink-1 flex-grow-0">
                <a href="{{ route('pages.create') }}" class="btn btn-primary">Novo</a>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>

@if($records->isNotEmpty())
<div class="bgc-white bd bdrs-3">
    @include('admin.pages._table')
    <div class="p-20">
        <div class="row">
            <div class="col d-flex align-items-center">Total de registros {{ $records->total() }}</div>
            <div class="col d-flex align-items-center justify-content-end">{!! $records->links() !!}</div>
        </div>
    </div>
</div>
@else
@include('admin._index-empty', ['button' => auth()->user()->isSuperAdmin, 'message' => auth()->user()->isSuperAdmin ? null : 'Nenhum resgistro para ser mostrado aqui.'])
@endif
@endsection