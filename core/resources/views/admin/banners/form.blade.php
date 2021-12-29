@extends('admin.__admin')

@php
$action = request()->route()->getActionMethod();
$pageName = 'Banners';
$pageSubName = $action === 'edit' ? 'Editar' : 'Criar';
@endphp

@section('page_title')
{{ $pageName }} {{ $pageSubName }} | {{ config('app.admin.name') }}
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-sm-6">        
        @if($action === 'edit')
            {!! Form::model($record, [
                'route' => ['banners.update', $record->id],
                'method' => 'put',
                'files' => true,
            ])
            !!}
        @else
            {!! Form::open([
                'route' => ['banners.store'],
                'files' => true,
            ])
        !!}
        @endif

        <div class="row">
            <div class="col">
                <h4 class="c-grey-900 mB-30">{{ $pageName }} <small>{{ $pageSubName }}</small></h4>
            </div>
            <div class="col">
                <div class="btn-group btn-block mB-25">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ session()->get('url.intended') ?? route('banners.index') }}" class="btn bg-white border">Cancelar</a>
                </div>
            </div>
        </div>

        @include('admin.banners._form')

        {!! Form::close() !!}
    </div>
</div>
@endsection