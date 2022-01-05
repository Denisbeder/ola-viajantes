@extends('admin.__admin')

@php $pageName = 'Destinos'; @endphp

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
                @include('admin._mass-action')
            </div>
            <div class="col-auto">
                @include('admin._clear-cache-btn', ['model' => 'Destination'])
            </div>
            <div class="col flex-shrink-1 flex-grow-0">
                <a href="{{ route('destinations.create') }}" class="btn btn-primary">Novo</a>
            </div>
        </div>
    </div>
    @endif
</div>

@if($records->isNotEmpty())
<div class="bgc-white p-20 bd bdrs-3">
    @include('admin.destinations._table')
    <div class="pT-20">
        <div class="row">
            <div class="col d-flex align-items-center">Total de registros {{ $records->total() }}</div>
            <div class="col d-flex align-items-center justify-content-end">{!! $records->links() !!}</div>
        </div>    
    </div>
</div>
@else
@include('admin._index-empty')
@endif
@endsection