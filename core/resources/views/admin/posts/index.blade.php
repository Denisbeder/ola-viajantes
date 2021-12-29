@extends('admin.__admin')

@php
$pageName = 'Posts';
$pageSelected = $page->title ?? '';
@endphp

@section('page_title')
{{ $pageSelected }} {!! !$pageSelected ? null : '&ndash;' !!} {{ $pageName }} | {{ config('app.admin.name') }}
@endsection

@empty(!$page)
@section('content')
<div class="row">
    <div class="col-lg-6">
        <h4 class="c-grey-900 mB-30">{{ $pageSelected}} <small>&ndash; {{ $pageName }}</small></h4>
    </div>
    @if($records->isNotEmpty() || !empty(request()->except(['page', 'ps'])))
    <div class="col-lg-6 d-flex align-items-start justify-content-end">
        <div class="form-row justify-content-end">            
            <div class="col">
                @include('admin._mass-action')
            </div>
            <div class="col-auto">
                @include('admin._clear-cache-btn', ['model' => 'Post,Highlight,' . $page->slug])
            </div>
            <div class="col-auto">
                @include('admin.posts._filter')
            </div>
            <div class="col flex-shrink-1 flex-grow-0">
                <a href="{{ route('posts.create') }}" class="btn btn-primary">Novo</a>
            </div>
        </div>
    </div>
    @endif
</div>

@if($records->isNotEmpty() || !empty(request()->except(['page', 'ps'])))
<div class="bgc-white bd bdrs-3">
    @include('admin.posts._table')
    <div class="p-20">
        <div class="row">
            <div class="col d-flex align-items-center">Total de registros {{ $records->total() }}</div>
            <div class="col d-flex align-items-center justify-content-end">{!! $records->appends(request()->all())->links() !!}</div>
        </div>
    </div>
</div>
@else
@include('admin._index-empty')
@endif
@endsection
@endempty