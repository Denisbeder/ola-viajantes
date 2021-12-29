<table id="dataTable" class="table table-hover border-bottom mb-0" cellspacing="0" width="100%" {{ ($touched = session()->get('touched')) ? 'data-touched='.$touched  : null }}>
    <thead>
        <tr>
            <th class="border-top-0" width="1%">{!! Form::cCheckbox('check-all', null, null, null, ['classWrap' => 'ml-3 mb-2', 'data-target' => '.check-single']) !!}</th>
            <th class="border-top-0" width="1%">#</th>
            <th class="border-top-0">Título</th>
            <th class="border-top-0">Página</th>
            <th class="border-top-0">Publicado</th>
            <th class="border-top-0" width="1%"></th>
        </tr>
    </thead>

    <tbody>
        @foreach ($records as $record)
        <tr id="tr_{{ $record->id }}">
            <td class="align-middle">{!! Form::cCheckbox('record[' . $record->id . ']', null, $record->id, null, ['classWrap' => 'ml-3', 'class' => 'check-single']) !!}</td>
            <td class="align-middle">{{ $record->id }}</td>
            <td class="align-middle"><a href="{{ route('categories.edit', ['id' => $record->id]) }}">{{ $record->title }}</a></td>
            <td class="align-middle">{!! $record->present()->pageTitleLabel !!}</td>
            <td class="align-middle">{!! $record->present()->publishLabel !!}</td>
            <td class="text-right">
                @include('admin._actions-btn', ['view' => false, 'comments' => false])
            </td>
        </tr>
        @endforeach
    </tbody>
</table>