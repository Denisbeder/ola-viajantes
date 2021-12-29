@extends('admin.__modal')

@section('size', 'xl')

@section('body')
<div class="grid-wrapper">
    <div class="grid">
        <div class="focused-image-container top-left">
            <img class="focused-image" src="{{ $record->getUrl() }}" alt="" data-focus-x="0" data-focus-y="0" />
        </div>
        <div class="focused-image-container top-center">
            <img class="focused-image" src="{{ $record->getUrl() }}" alt="" data-focus-x="0" data-focus-y="0" />
        </div>
        <div class="focused-image-container top-right">
            <img class="focused-image" src="{{ $record->getUrl() }}" alt="" data-focus-x="0" data-focus-y="0" />
        </div>
        <div class="focused-image-container center-left">
            <img class="focused-image" src="{{ $record->getUrl() }}" alt="" data-focus-x="0" data-focus-y="0" />
        </div>
        <div class="focused-image-container center-center">
            <img class="focused-image" src="{{ $record->getUrl() }}" alt="" data-focus-x="0" data-focus-y="0" />
        </div>
        <div class="focused-image-container center-right">
            <img class="focused-image" src="{{ $record->getUrl() }}" alt="" data-focus-x="0" data-focus-y="0" />
        </div>
        <div class="focused-image-container bottom-left">
            <img class="focused-image" src="{{ $record->getUrl() }}" alt="" data-focus-x="0" data-focus-y="0" />
        </div>
        <div class="focused-image-container bottom-center">
            <img class="focused-image" src="{{ $record->getUrl() }}" alt="" data-focus-x="0" data-focus-y="0" />
        </div>
        <div class="focused-image-container bottom-right">
            <img class="focused-image" src="{{ $record->getUrl() }}" alt="" data-focus-x="0" data-focus-y="0" />
        </div>
    </div>

    <div class="image-focus-picker-container">
        <h4 class="instruction">
            Arraste e selecione o foco
        </h4>
        <div>
            <img id="focus-picker-img" src="{{ $record->getUrl() }}" alt="" data-focus-x="0" data-focus-y="0" />
        </div>
        
        {!! Form::model($record, [
            'route' => ['medias.update', $record->id],
            'method' => 'put',
            'files' => false,
            'id' => 'medias-form'
            ])
        !!}
            
            <div id="medias-alert" class="alert text-white mt-3" style="display: none;"></div>
            
            @include('admin.medias._form')
            
        {!! Form::close() !!}
            
    </div>
</div>
@endsection