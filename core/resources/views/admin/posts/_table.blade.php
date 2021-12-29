<table id="dataTable" class="table mb-0 table-hover border-bottom" cellspacing="0" width="100%" {{ ($touched = session()->get('touched')) ? 'data-touched='.$touched  : null }}>
    <thead>
        <tr>
            <th class="border-top-0" width="1%">{!! Form::cCheckbox('check-all', null, null, null, ['classWrap' => 'ml-3 mb-2', 'data-target' => '.check-single']) !!}</th>
            <th class="border-top-0" width="1%">#</th>
            <th class="border-top-0" width="5%">Images</th>
            <th class="border-top-0">Título</th>
            @if($hasCategory = App\Category::ofPage(optional($page)->id)->get()->isNotEmpty())
            <th class="border-top-0">Categoria</th>
            @endif
            <th class="border-top-0">Em destaque</th>
            <th class="border-top-0">Publicado</th>
            <th class="border-top-0">Publicado em</th>
            <th class="border-top-0">Publicado por</th>
            <th class="border-top-0" width="1%"></th>
        </tr>
    </thead>

    <tbody>
        @foreach ($records as $record)
        <tr id="tr_{{ $record->id }}" {!! $record->draft ? 'class="bg-light"' : '' !!}>
            <td>{!! Form::cCheckbox('record[' . $record->id . ']', null, $record->id, null, ['classWrap' => 'ml-3', 'class' => 'check-single']) !!}</td>
            <td class="align-middle">{{ $record->id }}</td>
            <td class="align-middle">{!! $record->present()->imgFirst('images', ['width' => 30, 'height' => 30, 'fit' => 'crop', 'class' => 'rounded']) !!}</td>
            <td class="align-middle"><a href="{{ route('posts.edit', ['id' => $record->id]) }}">{{ $record->title }}</a></td>
            @if($hasCategory)
            <td class="align-middle">{!! $record->present()->categoryTitleLabel !!}</td>
            @endif
            <td class="align-middle">{!! $record->present()->highlightLabel !!}</td>
            <td class="align-middle">{!! $record->present()->publishLabel !!}</td>
            <td class="align-middle">{!! optional($record->published_at)->format('d/m/Y H:i') !!}</td>
            <td class="align-middle">{!! $record->user->name ?? '' !!}</td>
            <td class="text-right">
                @include('admin._actions-btn', [
                    'shareInstagram' => [
                        'caption' => $record->title . '
                        
                        ' . $record->description,
                        'media_url' => $record->getFirstMediaPath('images'),
                        'title' => $record->title,
                        'url' => config('app.url') . $record->present()->url,
                    ]
                ])
            </td>
        </tr>
        @endforeach
    </tbody>
</table>