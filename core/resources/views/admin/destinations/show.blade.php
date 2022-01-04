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
            <th class="text-right">Publicado</th>
            <td>{!! $record->present()->publishLabel !!}</td>
        </tr>
        <tr>
            <th class="text-right">Título</th>
            <td>{{ $record->title }}</td>
        </tr>
        <tr>
            <th class="text-right">URL</th>
            <td>{{ $record->present()->url }}</td>
        </tr>
        <tr>
            <th class="text-right">Recurso de gerenciamento</th>
            <td>{!! $record->present()->managerTypeLabel !!}</td>
        </tr>
        <tr>
            <th class="text-right">Imagens</th>
            <td>{!! $record->present()->imgs(['width' => 40, 'height' => 40, 'fit' => 'crop', 'class' => 'rounded mr-1']) !!}</td>
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
        <tr>
            <th class="text-right">SEO título</th>
            <td>{{ $record->seo_title }}</td>
        </tr>
        <tr>
            <th class="text-right">SEO Palavras-chaves</th>
            <td>{{ $record->seo_keywords }}</td>
        </tr>
        <tr>
            <th class="text-right">SEO Descrição</th>
            <td>{{ $record->seo_description }}</td>
        </tr>
        <tr>
            <th class="text-right">Corpo da página</th>
            <td>{{ $record->body }}</td>
        </tr>
    </tbody>
</table>
@endsection