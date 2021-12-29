
<div class="row">
    @foreach ($records as $k => $items)
    <div class="col-6">
        <div class="card mt-4">
            <div class="card-header bg-light border-bottom-0 d-flex align-items-center justify-content-between"><strong>Posição {{ $k }}</strong></div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush rounded-0 sortable">
                    @foreach ($items as $item)
                        @if(!is_null($highlightable = $item->highlightable))
                        <li class="list-group-item rounded-0 d-flex justify-content-between" data-index="{{ $item->id }}" style="cursor: move">
                            <div>
                                {!! $highlightable->present()->imgFirst('images', ['width' => 30, 'height' => 30, 'fit' => 'crop', 'class' => 'rounded mr-2']) !!}
                                <a href="{{ route(strtolower(Str::plural(class_basename($highlightable))) . '.edit', ['id' => $highlightable->id]) }}">{{ $highlightable->title }}</a>
                            </div>
                            <button type="button" class="btn btn-sm border bg-light confirm-alert" data-confirm-body="Você tem certeza que deseja remover o registro <strong>#{{ $item->id.'-'.$highlightable->title }}</strong>?<br>Esta ação é irreversível!" data-confirm-btn-confirm-label="Deletar" data-confirm-btn-confirm-class="btn-danger" data-confirm-id="{{ $item->id }}" data-confirm-method="delete" title="Deletar">
                                Remover
                            </button>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endforeach
</div>