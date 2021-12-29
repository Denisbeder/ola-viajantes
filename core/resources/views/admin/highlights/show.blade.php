@extends('admin.__show')

@section('content')
<table class="table table-bordered mb-0">
    <tbody>
        <tr>
            <th class="text-right" width="200px">#</th>
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
            <th class="text-right">URL</th>
            <td><a href="{{ config('app.url') . $record->present()->url }}" target="_blank">{{ config('app.url') . $record->present()->url }}</a></td>
        </tr>
        @if($hasCategory = App\Category::ofPage(optional($page)->id)->get()->isNotEmpty())
        <tr>
            <th class="text-right">Categoria</th>
            <td>{!! $record->present()->categoryTitleLabel !!}</td>
        </tr>
        @endif
        <tr>
            <th class="text-right">Em destaque</th>
            <td>{!! $record->present()->highlightLabel !!}</td>
        </tr>
        <tr>
            <th class="text-right">Chapéu</th>
            <td>{{ $record->hat }}</td>
        </tr>
        <tr>
            <th class="text-right">Autor</th>
            <td>{{ $record->present()->getAuthor('name') }}</td>
        </tr>
        <tr>
            <th class="text-right">Fonte</th>
            <td>{{ $record->source }}</td>
        </tr>
        <tr>
            <th class="text-right">Título</th>
            <td>{{ $record->title }}</td>
        </tr>
        <tr>
            <th class="text-right">Texto</th>
            <td>{!! $record->body !!}</td>
        </tr>
        <tr>
            <th class="text-right">Publicado</th>
            <td>{!! $record->present()->publishLabel !!}</td>
        </tr>
        <tr>
            <th class="text-right">Destaque página inicial</th>
            <td>{!! $record->present()->highlightLabel !!}</td>
        </tr>
        <tr>
            <th class="text-right">Permitir comentários</th>
            <td>{!! $record->commentable ? 'Sim' : 'Não' !!}</td>
        </tr>
        <tr>
            <th class="text-right">Total de visualizações</th>
            <td>{{ $record->views->count() }}</td>
        </tr>
        <tr>
            <th class="text-right">Total de comentários</th>
            <td>{{ $record->comments_count }}</td>
        </tr>
        <tr>
            <th class="text-right">Imagens</th>
            <td>{!! $record->present()->imgs(['width' => 40, 'height' => 40, 'fit' => 'crop', 'class' => 'rounded mr-1']) !!}</td>
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
    </tbody>
</table>
@endsection