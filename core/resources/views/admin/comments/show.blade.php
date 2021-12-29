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
            <th class="text-right" width="40%">Atualizado em</th>
            <td>{{ $record->updated_at->format('d/m/Y H:i:s') }}</td>
        </tr>
        <tr>
            <th class="text-right">Gravatar</th>
            <td><img src="{{ $record->present()->gravatar }}" class="rounded-pill" width="40" height="40"></td>
        </tr>
        <tr>
            <th class="text-right">Nome</th>
            <td>{{ $record->name }}</td>
        </tr>
        <tr>
            <th class="text-right">E-mail</th>
            <td>{{ $record->email }}</td>
        </tr>
        <tr>
            <th class="text-right">Publicado</th>
            <td>{!! $record->present()->publishLabel !!}</td>
        </tr>
        <tr>
            <th class="text-right">IP</th>
            <td>{{ $record->ip }}</td>
        </tr>
        <tr>
            <th class="text-right">Mobile</th>
            <td>{{ $record->present()->mobile }}</td>
        </tr>
        <tr>
            <th class="text-right">Aparelho usado</th>
            <td class="break">{{ $record->device }}</td>
        </tr>
    </tbody>
</table>
@endsection