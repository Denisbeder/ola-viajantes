<table id="dataTable" class="table table-hover border-bottom mb-0" cellspacing="0" width="100%" {{ ($touched = session()->get('touched')) ? 'data-touched='.$touched  : null }}>
    <thead>
        <tr>
            <th class="border-top-0" width="1%">{!! Form::cCheckbox('check-all', null, null, null, ['classWrap' => 'ml-3 mb-2', 'data-target' => '.check-single']) !!}</th>
            <th class="border-top-0"width="1%">#</th>
            <th class="border-top-0"width="5%">Image</th>
            <th class="border-top-0">Título</th>
            <th class="border-top-0">Modo de participação pelo site</th>
            <th class="border-top-0">Participantes</th>
            <th class="border-top-0">Publicado</th>
            <th class="border-top-0" width="1%"></th>
        </tr>
    </thead>
    
    <tbody>
        @foreach ($records as $record)
        <tr id="tr_{{ $record->id }}">
            <td class="align-middle">{!! Form::cCheckbox('record[' . $record->id . ']', null, $record->id, null, ['classWrap' => 'ml-3', 'class' => 'check-single']) !!}</td>
            <td class="align-middle">{{ $record->id }}</td>
            <td class="align-middle">{{ $record->present()->imgFirst('image', ['width' => 60, 'height' => 40, 'fit' => 'crop', 'class' => 'rounded']) }}</td>
            <td class="align-middle"><a href="{{ route('promotions.edit', ['id' => $record->id]) }}">{{ $record->title }}</a></td>
            <td class="align-middle">{!! $record->present()->modeLabel !!}</td>
            <td class="align-middle">{!! $record->present()->participantsLink !!}</td>
            <td class="align-middle">{!! $record->present()->publishLabel !!}</td>
            <td class="text-right">
                @include('admin._actions-btn', [
                    'edit' => '
                        <a href="'. route('promotionsparticipants.index', ['pm' => $record->id]) .'" class="btn btn-primary btn-sm border">Sortear</a>
                        <a href="'. route(request()->segment(2) . '.edit', ['id' => $record->id]) .'" class="btn bg-light btn-sm border">Editar</a>
                    '
                ])
            </td>
        </tr>
        @endforeach
    </tbody>
</table>