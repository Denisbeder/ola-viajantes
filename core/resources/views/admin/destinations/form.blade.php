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
    <div class="col-sm-6">
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
            <div class="col d-flex justify-content-end">
                <div class="btn-group mB-25">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="button" class="btn btn-primary border-left border-right-0 border-top-0 border-bottom-0 border-info dropdown-toggle dropdown-toggle-split rounded-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                    <div class="dropdown-menu pt-0 pb-0">
                        <button type="submit" name="submit_continue" class="dropdown-item">Salvar e continuar</button>
                        <button type="submit" name="submit_new" class="dropdown-item">Salvar e criar novo como parente desse</button>
                        @empty(!$lastCreateId = request()->query('lc'))
                        <button type="submit" name="submit_new" value="{{ $lastCreateId }}" class="dropdown-item">Salvar e criar novo como parente de {{ App\Destination::find($lastCreateId)->title }}</button>
                        @endempty
                    </div>
                    <a href="{{ session()->get('url.intended') ?? route('destinations.index') }}" class="btn bg-white border">Cancelar</a>
                </div>
            </div>
        </div>

        @include('admin.destinations._form')

        {!! Form::close() !!}
    </div>
</div>
@endsection
