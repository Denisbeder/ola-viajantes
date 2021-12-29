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
            <th class="text-right">Último Login</th>
            <td>{{ optional($record->last_login)->format('d/m/Y H:i:s') }}</td>
        </tr>
        <tr>
            <th class="text-right">Nome</th>
            <td>{{ $record->name }}</td>
        </tr>
        <tr>
            <th class="text-right">E-mail</th>
            <td>{{ $record->email }}</td>
        </tr>
        {{-- <tr>
            <th class="text-right">Admin</th>
            <td>{{ $record->present()->adminLabel }}</td>
        </tr> --}}
        <tr>
            <th class="text-right">Permissões</th>
            <td>{!! $record->present()->permissionsAvaliable !!}</td>
        </tr>
        <tr>
            <th class="text-right">Status</th>
            <td>{!! $record->present()->publishLabel('Ativado') !!}</td>
        </tr>
        <tr>
            <th class="text-right">Usar dados de escritor nas postagens</th>
            <td>{{ (bool) $record->uses_writer ? 'Sim' : 'Não' }}</td>
        </tr>
        <tr>
            <th class="text-right">Ecritor da página</th>
            <td>
                Nome: {{ @$record->writer['name'] }}<br>
                Descrição: {{ @$record->writer['description'] }}<br>
                E-mail: {{ @$record->writer['name'] }}<br>
                URL: {{ @$record->writer['link'] }}<br>
                {!! optional($record->getFirstMedia('avatar'))->img(['class' => 'rounded', 'style' => 'width: 40px; height: 40px; object-fit: cover;']) !!}
            </td>
        </tr>
    </tbody>
</table>
@endsection