<div class="table-responsive">
    <table id="dataTable" class="table table-hover border-bottom mb-0" cellspacing="0" width="100%" {{ ($touched = session()->get('touched')) ? 'data-touched='.$touched  : null }}>
        <thead>
            <tr>
                <th class="border-top-0" class="border-top-0" width="1%">{!! Form::cCheckbox('check-all', null, null, null, ['classWrap' => 'ml-3 mb-2', 'data-target' => '.check-single']) !!}</th>
                <th class="border-top-0" width="1%">#</th>
                <th class="border-top-0" width="1%">Gravatar</th>
                <th class="border-top-0" width="25%">Dados</th>
                <th class="border-top-0">Comentário</th>
                <th class="border-top-0" width="10%">Publicado</th>
                <th class="border-top-0" width="10%"></th>
            </tr>
        </thead>
    
        <tbody>
            @foreach ($records as $record)
            <tr id="tr_{{ $record->id }}">
                <td>{!! Form::cCheckbox('record[' . $record->id . ']', null, $record->id, null, ['classWrap' => 'ml-3', 'class' => 'check-single']) !!}</td>
                <td>{{ $record->id }}</td>
                <td><img src="{{ $record->present()->gravatar }}" class="rounded-pill" width="40" height="40"></td>
                <td>
                    <strong>Nome:</strong> {{ $record->name }}<br>
                    <strong>E-mail:</strong> {{ $record->email }}<br>
                    <strong>Post:</strong> <em>#{{ $record->commentable->id }}</em> <a href="{{ $record->commentable->present()->url }}" target="_blank">{{ $record->commentable->title }}</a><br>
                </td>
                <td class="text-break">{!! nl2br($record->text) !!}</td>
                <td>{!! $record->present()->publishLabel !!}</td>
                <td class="text-right">
                    @include('admin.comments._actions-btn')
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>