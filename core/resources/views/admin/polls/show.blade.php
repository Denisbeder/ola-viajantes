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
                <th class="text-right">Opções</th>
                <td>
                    @php
                        $lenght = max(array_map('strlen', $record->options->pluck('title')->toArray()));
                    @endphp
                    @foreach ($record->options as $item)  
                        @php
                                $repeat= str_repeat('=', ($lenght + 2) - strlen($item->title));
                        @endphp                      
                        {!! '<strong>' . $item->title . '</strong> ' . $repeat . ' ' !!} <strong>{{ $item->percent }}%</strong> <small>({{ $item->votes_count}} Votos)</small><br>

                    @endforeach
                </td>
            </tr>
            <tr>
                <th class="text-right">Total de votos</th>
                <td>{{ $record->votes_count }}</td>
            </tr>
            <tr>
                <th class="text-right">Publicado</th>
                <td>{!! $record->present()->publishLabel !!}</td>
            </tr>
        </tbody>
    </table>
@endsection