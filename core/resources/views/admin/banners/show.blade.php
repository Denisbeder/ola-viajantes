@extends('admin.__show')

@section('size', 'xl')

@section('content')
<table class="table table-bordered">
    <tbody>
        <tr>
            <th class="text-right">#</th>
            <td>{{ $record->id }}</td>
        </tr>
        <tr>
            <th class="text-right">Criado por</th>
            <td>{{ optional($record->user)->name }} #{{ optional($record->user)->id }}</td>
        </tr>
        <tr>
            <th class="text-right">Criado em</th>
            <td>{{ $record->created_at->format('d/m/Y H:i:s') }}</td>
        </tr>
        <tr>
            <th class="text-right">Atualizado em</th>
            <td>{{ $record->updated_at->format('d/m/Y H:i:s') }}</td>
        </tr>
        <tr>
            <th class="text-right">Título</th>
            <td>{!! $record->title !!}</td>
        </tr>
        <tr>
            <th class="text-right">URL</th>
            <td>{{ $record->url }}</td>
        </tr>
        <tr>
            <th class="text-right">Posição</th>
            <td>{{ $record->present()->positionLabel }}</td>
        </tr>
        <tr>
            <th class="text-right">Tamanho</th>
            <td>{{ $record->present()->sizeLabel }}</td>
        </tr>
        <tr>
            <th class="text-right">Publicado</th>
            <td>{!! $record->present()->publishLabel !!}</td>
        </tr>
        <tr>
            <th class="text-right">Arquivo</th>
            <td>{!! $record->present()->render(['style' => 'max-width: 100%']) !!}</td>
        </tr>
        <tr>
            <th class="text-right">Aparelho</th>
            <td>{!! $record->present()->deviceLabel !!}</td>
        </tr>
    </tbody>
</table>
@endsection