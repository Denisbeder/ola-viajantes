@extends('admin.__admin')

@php
$pageName = 'Menus';
$pageSubName = 'Editar';
@endphp
@section('page_title')
{{ $pageName }} &ndash; {{ $pageSubName }} | {{ config('app.admin.name') }}
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-sm-6">
        {!! Form::model($record, [
        'route' => 'menus.store',
        'files' => false,
        ])
        !!}

        <div class="row">
            <div class="col">
                <h4 class="c-grey-900 mB-30"> {{ $pageName }} <small> &ndash; {{ $pageSubName }}</small></h4>
            </div>
            <div class="col d-flex justify-content-end">
                <div class="btn-group mB-25">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>

        @include('admin.menus._form')

        {!! Form::close() !!}
    </div>
</div>
@endsection