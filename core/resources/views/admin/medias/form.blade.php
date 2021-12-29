@extends('admin.__admin')

@php
$action = request()->route()->getActionMethod();
$pageName = 'Mídias';
$pageSubName = $action === 'edit' ? 'Editar' : 'Criar';
@endphp

@section('page_title')
{{ $pageName }} {{ $pageSubName }} | {{ config('app.admin.name') }}
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-sm-5">
        {!! Form::model($record, [
        'route' => ['medias.update', $record->id],
        'method' => 'put',
        'files' => false,
        ])
        !!}

        <div class="row">
            <div class="col">
                <h4 class="c-grey-900 mB-30">{{ $pageName }} <small>{{ $pageSubName }}</small></h4>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Salvar</button>             
            </div>
        </div>

        <div class="bgc-white p-20 bd bdrs-3">
            @include('admin.medias._form')
        </div>

        {!! Form::close() !!}
    </div>
</div>
@endsection