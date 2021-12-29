@extends('admin.__admin')

@php
$action = request()->route()->getActionMethod();
$pageName = 'Mural de anúncios';
$pageSelected = $page->title ?? '';
$pageSubName = $action === 'edit' ? 'Editar' : 'Criar';
@endphp

@section('page_title')
{{ $pageSelected }} {!! !$pageSelected ? null : '&ndash;' !!} {{ $pageName }} {{ $pageSubName }} | {{ config('app.admin.name') }}
@endsection

@empty(!$page)
@section('content')
<div class="row justify-content-center">
    <div class="col-sm-8">
        @if($action === 'edit')
            {!! Form::model($record, [
                'route' => ['adverts.update', $record->id],
                'method' => 'put',
                'files' => true,
            ])
            !!}
        @else
            {!! Form::open([
                'route' => 'adverts.store',
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
                    <button type="submit" class="border btn btn-light btn-submit-caption">Salvar</button>
                    <button type="submit" name="submit_continue" class="btn btn-primary">Salvar e continuar</button>
                    <a href="{{ session()->get('url.intended') ?? route('adverts.index') }}" class="bg-white border btn">Cancelar</a>
                </div>
            </div>
        </div>

        @include('admin.adverts._form')

        {!! Form::close() !!}
    </div>
</div>
@endsection
@endempty