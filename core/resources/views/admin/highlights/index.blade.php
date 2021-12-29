@extends('admin.__admin')

@php
$pageName = 'Destaques da Home';
@endphp

@section('page_title')
{{ $pageName }} | {{ config('app.admin.name') }}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-6">
        <h4 class="c-grey-900 mB-30">{{ $pageName }}</h4>
    </div>
    @if($records->isNotEmpty() || !empty(request()->except(['page', 'ps'])))
    <div class="col-lg-6 d-flex align-items-start justify-content-end">
        <div class="form-row justify-content-end">            
            <div class="col">
                @include('admin._mass-action')
            </div>
            <div class="col-auto">
                @include('admin._clear-cache-btn', ['model' => 'Highlight,Post,Video,Gallery,' . App\Page::where('manager->type', 'App\Post')->orwhere('manager->type', 'App\Video')->orwhere('manager->type', 'App\Gallery')->pluck('slug')->implode(',')])
            </div>
        </div>
    </div>
    @endif
</div>

@if($records->isNotEmpty() || !empty(request()->except(['page', 'ps'])))
<div class="bgc-white p-20 bd bdrs-3">
    @include('admin.highlights._table')
</div>
@else
@include('admin._index-empty')
@endif
@endsection
