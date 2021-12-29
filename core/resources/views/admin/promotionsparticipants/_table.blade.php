<table id="dataTable" class="table table-hover border-bottom mb-0" cellspacing="0" width="100%" {{ ($touched = session()->get('touched')) ? 'data-touched='.$touched  : null }}>
    <thead>
        <tr>
            @if(!$promotion->participants->whereNotNull('drawn')->isNotEmpty())
            <th class="border-top-0 align-top" width="1%">{!! Form::cCheckbox('check-all', null, null, null, ['classWrap' => 'ml-3 mb-2', 'data-target' => '.check-single']) !!}</th>
            @endif
            <th class="border-top-0" width="1%">#</th>
            <th class="border-top-0">Nome</th>
            <th class="border-top-0">E-mail</th>
            <th class="border-top-0">Telefone</th>
            <th class="border-top-0" width="1%"></th>
        </tr>
    </thead>
    
    <tbody>
        @foreach ($records as $record)
        <tr id="tr_{{ $record->id }}" {!! !is_null($record->drawn) ? 'class="table-success"' : '' !!}>
            @if(!$promotion->participants->whereNotNull('drawn')->isNotEmpty())
            <td>{!! Form::cCheckbox('record[' . $record->id . ']', null, $record->id, null, ['classWrap' => 'ml-3', 'class' => 'check-single']) !!}</td>
            @endif
            <td class="align-middle">{{ $record->id }}</td>
            <td class="align-middle">{{ $record->name }}</td>
            <td class="align-middle">{{ $record->email }}</td>
            <td class="align-middle">{{ $record->phone }}</td>
            <td class="text-right">
                @include('admin._actions-btn', [
                    'edit' => false,
                    'publish' => false,
                    'view' => false,
                    'details' => false,
                    'duplicate' => false,
                    'comments' => false,
                    'delete' => !$promotion->participants->whereNotNull('drawn')->isNotEmpty(),
                ])
            </td>
        </tr>
        @endforeach
    </tbody>
</table>