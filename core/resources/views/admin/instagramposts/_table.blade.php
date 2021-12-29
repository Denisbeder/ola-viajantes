<table id="dataTable" class="table table-hover border-bottom mb-0" cellspacing="0" width="100%" {{ ($touched = session()->get('touched')) ? 'data-touched='.$touched  : null }}>
    <thead>
        <tr>
            <th class="border-top-0" width="1%">{!! Form::cCheckbox('check-all', null, null, null, ['classWrap' => 'ml-3 mb-2', 'data-target' => '.check-single']) !!}</th>
            <th class="border-top-0" width="1%">#</th>
            <th class="border-top-0" width="5%">Image</th>
            <th class="border-top-0" width="50%">Legenda</th>
            <th class="border-top-0">URL Instagram</th>
            <th class="border-top-0">URL Site</th>
            <th class="border-top-0" width="1%"></th>
        </tr>
    </thead>
    
    <tbody>
        @foreach ($records as $record)
        <tr id="tr_{{ $record->id }}">
            <td class="align-middle">{!! Form::cCheckbox('record[' . $record->id . ']', null, $record->id, null, ['classWrap' => 'ml-3', 'class' => 'check-single']) !!}</td>
            <td class="align-middle">{{ $record->id }}</td>
            <td class="align-middle">{{ $record->present()->imgFirst('default', ['width' => 60, 'height' => 60, 'fit' => 'crop', 'class' => 'rounded']) }}</td>
            <td class="align-middle text-break">{{ $record->caption }}</td>
            <td class="align-middle">
                @if((bool) strlen($record->identifier))
                <a href="https://instagram.com/p/{{ $record->identifier }}" target="_blank">Acessar no Instagram</a>
                @else
                <em class="text-muted">Foi gerado o Canvas mas não foi postago com sucesso no Instagram</em>
                @endif
            </td>
            <td class="align-middle"><a href="{{ $record->url }}" target="_blank">Acessar no site</a></td>
            <td class="text-right">
                @include('admin._actions-btn', ['edit' => false, 'publish' => false, 'comments' => false, 'duplicate' => false, 'view' => false, 'delete' => false])
            </td>
        </tr>
        @endforeach
    </tbody>
</table>