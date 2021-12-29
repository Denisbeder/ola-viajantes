<table id="dataTable" class="table table-hover border-bottom mb-0" cellspacing="0" width="100%" {{ ($touched = session()->get('touched')) ? 'data-touched='.$touched  : null }}>
    <thead>
        <tr>
            <th class="border-top-0" width="1%">{!! Form::cCheckbox('check-all', null, null, null, ['classWrap' => 'ml-3 mb-2', 'data-target' => '.check-single']) !!}</th>
            <th class="border-top-0" width="1%">#</th>
            <th class="border-top-0">Título</th>
            <th class="border-top-0">Descrição</th>
            <th class="border-top-0">Palavras-chaves</th>
            <th class="border-top-0">Usado em</th>
            <th class="border-top-0" width="1%"></th>
        </tr>
    </thead>

    <tbody>
        @foreach ($records as $record)
        <tr id="tr_{{ $record->id }}">
            <td>{!! Form::cCheckbox('record[' . $record->id . ']', null, $record->id, null, ['classWrap' => 'ml-3', 'class' => 'check-single']) !!}</td>
            <td>{{ $record->id }}</td>
            <td>{{ $record->title }}</td>
            <td>{{ $record->description }}</td>
            <td>{{ $record->keywords }}</td>
            <td>{{ optional($record->seoable)->title }}</td>
            <td class="text-right">
                @include('admin._actions-btn', ['edit' => false, 'view' => false, 'comments' => false, 'publish' => false, 'duplicate' => false])
            </td>
        </tr>
        @endforeach
    </tbody>
</table>