<table id="dataTable" class="table table-hover border-bottom mb-0" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="border-top-0" width="1%"><div class="ml-2">#</div></th>
            <th class="border-top-0">Título</th>
            <th class="border-top-0">Total</th>
        </tr>
    </thead>
    
    <tbody >
        @foreach ($records as $record)
        <tr>
            <td class="align-middle"><div class="ml-2">{{ $record->relatable->id }}</div></td>
            <td class="align-middle"><a href="{{ route($record->relatable->getTable().'.edit', $record->relatable->id) }}">{{ $record->relatable->title ?? '' }}</a></td>
            <td class="align-middle">{{ $record->relatable->related->count() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>