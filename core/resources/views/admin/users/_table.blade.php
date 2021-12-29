<table id="dataTable" class="table table-hover border-bottom mb-0" cellspacing="0" width="100%" {{ ($touched = session()->get('touched')) ? 'data-touched='.$touched  : null }}>
    <thead>
        <tr>
            <th class="border-top-0" width="1%">{!! Form::cCheckbox('check-all', null, null, null, ['classWrap' => 'ml-3 mb-2', 'data-target' => '.check-single']) !!}</th>
            <th class="border-top-0" width="1%">#</th>
            <th class="border-top-0">Nome</th>
            <th class="border-top-0">E-mail</th>
            {{-- <th class="border-top-0">Admin</th> --}}
            <th class="border-top-0">Permissões</th>
            <th class="border-top-0">Status</th>
            <th class="border-top-0" width="1%"></th>
        </tr>
    </thead>

    <tbody>
        @foreach ($records as $record)
        <tr id="tr_{{ $record->id }}">
            <td class="align-middle">{!! Form::cCheckbox('record[' . $record->id . ']', null, $record->id, null, ['classWrap' => 'ml-3', 'class' => 'check-single']) !!}</td>
            <td class="align-middle">{{ $record->id }}</td>
            <td class="align-middle"><a href="{{ route('users.edit', ['id' => $record->id]) }}">{{ $record->name }}</a></td>
            <td class="align-middle">{{ $record->email }}</td>
            {{-- <td class="align-middle">{{ $record->present()->adminLabel }}</td> --}}
            <td class="align-middle">{!! $record->present()->permissionsAvaliable !!}</td>
            <td class="align-middle">{!! $record->present()->publishLabel('Ativado') !!}</td>
            <td class="text-right">
                @include('admin._actions-btn')
            </td>
        </tr>
        @endforeach
    </tbody>
</table>