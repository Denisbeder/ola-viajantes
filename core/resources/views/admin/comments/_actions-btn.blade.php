<div class="btn-group">
    {!! Form::open(['url' => route('comments.update', ['id' => $record->id]), 'method' => 'PUT']) !!}
    {!! Form::hidden('publish', $record->publish ? 0 : 1) !!}
    <button class="btn btn-light btn-sm border" title="{{ $record->present()->buttonPublishLabel }}">{{ $record->present()->buttonPublishLabel }}</button>
    {!! Form::close() !!}
    <button type="button" class="btn btn-light btn-sm border dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
    <div class="dropdown-menu dropdown-menu-right">
        <a href="{{ route('comments.show', ['id' => $record->id]) }}" title="Detalhes" class="dropdown-item popup-modal-link">Detalhes</a>

        <button type="button" class="dropdown-item confirm-alert" data-confirm-body="Você tem certeza que deseja deletar o registro <strong>#{{ $record->id.'-'.$record->name }}</strong>?<br>Esta ação é irreversível!" data-confirm-btn-confirm-label="Deletar" data-confirm-btn-confirm-class="btn-danger" data-confirm-id="{{ $record->id }}" data-confirm-method="delete" title="Deletar">
            Deletar
        </button>
    </div>
</div>