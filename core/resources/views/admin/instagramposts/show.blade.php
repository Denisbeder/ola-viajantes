@extends('admin.__show')

@section('content')
<table class="table table-bordered">
    <tbody>
        <tr>
            <th class="text-right">#</th>
            <td>{{ $record->id }}</td>
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
            <th class="text-right">Legenda</th>
            <td>{!! nl2br($record->caption) !!}</td>
        </tr>
        <tr>
            <th class="text-right">URL Instagram</th>
            <td>
                @if((bool) strlen($record->identifier))
                <a href="https://instagram.com/p/{{ $record->identifier }}" target="_blank">Acessar no Instagram</a>
                @else
                <em class="text-muted">Foi gerado o Canvas mas não foi postago com sucesso no Instagram</em>
                @endif
            </td>
        </tr>
        <tr>
            <th class="text-right">URL Site</th>
            <td><a href="{{ $record->url }}" target="_blank">Acessar no site</a></td>
        </tr>
        <tr>
            <th class="text-right">Imagem</th>
            <td>{{ $record->present()->imgFirst('default', ['width' => 600, 'height' => 600, 'fit' => 'crop']) }}</td>
        </tr>
    </tbody>
</table>
@endsection