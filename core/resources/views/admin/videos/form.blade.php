@extends('admin.__admin')

@php
$action = request()->route()->getActionMethod();
$pageName = 'Vídeos';
$pageSelected = $page->title ?? '';
$pageSubName = $action === 'edit' ? 'Editar' : 'Criar';
@endphp

@section('page_title')
{{ $pageSelected }} {!! !$pageSelected ? null : '&ndash;' !!} {{ $pageName }} {{ $pageSubName }} | {{ config('app.admin.name') }}
@endsection

@empty(!$page)
@section('content')
<div class="row justify-content-center">
    <div class="col-sm-7">
        @if($action === 'edit')
            {!! Form::model($record, [
                'route' => ['videos.update', $record->id],
                'method' => 'put',
                'files' => true,
            ])
            !!}
        @else
            {!! Form::open([
                'route' => 'videos.store',
                'files' => true,
            ])
        !!}
        @endif

        <div class="row">
            <div class="col">
                <h4 class="c-grey-900 mB-30">{{ $pageSelected }} <small>&ndash; {{ $pageName }} {{ $pageSubName }}</small></h4>
            </div>
            <div class="col-5">
                <div class="btn-group btn-block mB-25">
                    <button type="submit" class="btn btn-primary btn-submit-caption">Salvar</button>
                    <a href="{{ session()->get('url.intended') ?? route('videos.index') }}" class="btn bg-white border">Cancelar</a>
                </div>
            </div>
        </div>

        @include('admin.videos._form')

        {!! Form::close() !!}
    </div>
</div>
@endsection
@endempty