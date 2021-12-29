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
                <th class="text-right">Nome</th>
                <td>{{ $record->name }}</td>
            </tr>
            <tr>
                <th class="text-right">E-mail</th>
                <td>{{ $record->email }}</td>
            </tr>
            <tr>
                <th class="text-right">Telefone</th>
                <td>{{ $record->phone }}</td>
            </tr>
            <tr>
                <th class="text-right">Dados</th>
                <td>{!! $record->data !!}</td>
            </tr>
            <tr>
                <th class="text-right">IP</th>
                <td>{{ $record->ip }}</td>
            </tr>
            <tr>
                <th class="text-right">Aparelho</th>
                <td>{{ $record->device }}</td>
            </tr>
            <tr>
                <th class="text-right">Mobile</th>
                <td>{{ (bool) $record->is_mobile ? 'Sim' : 'Não' }}</td>
            </tr>
            <tr>
                <th class="text-right">Participando da promoção</th>
            <td>{{ $record->promotion->title }} ({{ $record->promotion->participants->count() }})</td>
            </tr>
        </tbody>
    </table>
@endsection