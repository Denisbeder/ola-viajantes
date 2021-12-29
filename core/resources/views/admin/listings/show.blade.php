@extends('admin.__show')

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
                <th class="text-right">Publicado em</th>
                <td>{{ optional($record->published_at)->format('d/m/Y H:i:s') }}</td>
            </tr>
            <tr>
                <th class="text-right">Publicação expira em</th>
                <td>{{ optional($record->unpublished_at)->format('d/m/Y H:i:s') }}</td>
            </tr>
            <tr>
                <th class="text-right">Título</th>
                <td>{{ $record->title }}</td>
            </tr>
            <tr>
                <th class="text-right">Slug</th>
                <td>{{ $record->slug }}</td>
            </tr>
            <tr>
                <th class="text-right">Publicado</th>
                <td>{!! $record->present()->publishLabel !!}</td>
            </tr>
            <tr>
                <th class="text-right">Texto</th>
                <td>{!! $record->body !!}</td>
            </tr>
            <tr>
                <th class="text-right">Imagens</th>
                <td>{!! $record->present()->imgs(['width' => 40, 'height' => 40, 'fit' => 'crop', 'class' => 'rounded mr-1']) !!}</td>
            </tr>
        </tbody>
    </table>
@endsection