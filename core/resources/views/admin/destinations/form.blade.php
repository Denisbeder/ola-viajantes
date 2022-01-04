@extends('admin.__admin')

@php
$action = request()->route()->getActionMethod();
$pageName = 'Destinos';
$pageSubName = $action === 'edit' ? 'Editar' : 'Criar';
@endphp

@section('page_title')
{{ $pageName }} {{ $pageSubName }} | {{ config('app.admin.name') }}
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-sm-8">        
        @if($action === 'edit')
        {!! Form::model($record, [
            'route' => ['destinations.update', $record->id],
            'method' => 'put',
            'files' => true,
            ])
            !!}
        @else
        {!! Form::open([
            'route' => 'destinations.store',
            'files' => true,
            ])
            !!}
        @endif
        
        <div class="row">
            <div class="col">
                <h4 class="c-grey-900 mB-30">{{ $pageName }} <small>{{ $pageSubName }}</small></h4>
            </div>
            <div class="col-5 text-right">
                @can('pages')
                <div class="btn-group btn-block mB-25">
                    <button type="submit" class="btn btn-primary btn-submit-caption">Salvar</button>
                    <button type="submit" name="submit_continue" class="btn btn-light border">Salvar e continuar</button>
                    <a href="{{ session()->get('url.intended') ?? route('pages.index') }}" class="btn bg-white border">Cancelar</a>
                </div>
                @else
                <button type="submit" name="submit_continue" class="btn btn-primary">Salvar e continuar</button>
                @endcan
            </div>
        </div>

        @include('admin.destinations._form')

        {!! Form::close() !!}
    </div>
</div>
@endsection