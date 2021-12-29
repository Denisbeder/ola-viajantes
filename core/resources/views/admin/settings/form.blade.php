@extends('admin.__admin')

@php
$pageName = 'Configurações';
$pageSubName = 'Editar';
@endphp
@section('page_title')
{{ $pageName }} &ndash; {{ $pageSubName }} | {{ config('app.admin.name') }}
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-sm-12">
        {!! Form::model($record, [
        'route' => 'settings.store',
        'files' => true,
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

        @include('admin.settings._form')

        {!! Form::close() !!}
        <form action="/admin/settings/3" method="POST" id="sitemap_generate">
            @csrf
            @method('PUT')
        </form>
    </div>
</div>
@endsection