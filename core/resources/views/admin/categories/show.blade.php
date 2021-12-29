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
                <th class="text-right">Total de registros</th>
                <td>{{ $record->present()->totalRecords }}</td>
            </tr>
        </tbody>
    </table>
@endsection