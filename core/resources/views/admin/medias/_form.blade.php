@if (Str::contains($record->mime_type, 'image'))
<div class="form-group" style="display: none;">
    {!! Form::cInput('text', 'coordinates', 'Coordenadas', ['readonly', 'id' => 'coordinates'], $record->getCustomProperty('coordinates')) !!}
</div>
@endif 

<div class="form-group">
    {!! Form::cInput('text', 'caption', 'Legenda', [], $record->getCustomProperty('caption')) !!}
</div>

<div class="form-group mb-0">
    <button type="submit" class="btn btn-primary">Salvar</button>
</div>