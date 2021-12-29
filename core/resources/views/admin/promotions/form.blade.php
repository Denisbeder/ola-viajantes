@extends('admin.__admin')

@php
$action = request()->route()->getActionMethod();
$pageName = 'Promoções';
$pageSelected = $page->title ?? '';
$pageSubName = $action === 'edit' ? 'Editar' : 'Criar';
@endphp

@section('page_title')
{{ $pageSelected }} {!! !$pageSelected ? null : '&ndash;' !!} {{ $pageName }} {{ $pageSubName }} | {{ config('app.admin.name') }}
@endsection

@empty(!$page)
@section('content')
<div class="row justify-content-center">
    <div class="col-sm-6">
        @if($action === 'edit')
            {!! Form::model($record, [
                'route' => ['promotions.update', $record->id],
                'method' => 'put',
                'files' => true,
            ])
            !!}
        @else
            {!! Form::open([
                'route' => 'promotions.store',
                'files' => true,
            ])
        !!}
        @endif

        <div class="row">
            <div class="col">
                <h4 class="c-grey-900 mB-30">{{ $pageName }} <small>{{ $pageSubName }}</small></h4>
            </div>
            <div class="col d-flex justify-content-end">
                <div class="btn-group mB-25">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="submit" name="submit_continue" class="btn btn-light border">Salvar e continuar</button>
                    <a href="{{ session()->get('url.intended') ?? route('promotions.index') }}" class="btn bg-white border">Cancelar</a>
                </div>
            </div>
        </div>

        @include('admin.promotions._form')

        {!! Form::close() !!}
    </div>
</div>
@endsection
@endempty