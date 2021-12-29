<div class="btn-group">
    @if (!empty(request()->except(['page', 'ps'])))
    <a href="{{ request()->url() }}" class="btn btn-light border bg-white" title="Limpar filtros"><i class="ti-close"></i></a>
    @endif
    <button class="btn btn-light border bg-white" data-toggle="modal" data-target="#modal-filter"><i class="ti-search"></i> Filtrar</button>
</div>
<div id="modal-filter" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="" method="GET" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filtrar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::cInput('text', 'filter', 'Digite o que deseja encontrar') !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light bg-white border border-light" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </form>
    </div>
</div>