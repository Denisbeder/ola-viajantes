@extends('admin.__admin')

@php
$pageName = 'Formulários';
$pageSelected = $page->title ?? '';
$pageSubName = 'Editar';
@endphp

@section('page_title')
{{ $pageSelected }} {!! !$pageSelected ? null : '&ndash;' !!} {{ $pageName }} {{ $pageSubName }} | {{ config('app.admin.name') }}
@endsection

@empty(!$page)
@section('content')
<div class="row justify-content-center">
    <div class="col-sm-6">
        {!! Form::model($record, [
        'route' => 'forms.store',
        'files' => false,
        ])
        !!}

        <div class="row">
            <div class="col">
                <h4 class="c-grey-900 mB-30">{{ $pageSelected }} <small> {!! !$pageSelected ? null : '&ndash;' !!} {{ $pageName }} {{ $pageSubName }} </small></h4>
            </div>
            <div class="col d-flex justify-content-end">
                <div class="btn-group mB-25">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>

        @include('admin.forms._form')

        {!! Form::close() !!}
    </div>
</div>
@endsection
@endempty