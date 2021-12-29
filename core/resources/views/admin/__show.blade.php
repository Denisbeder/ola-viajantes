<div class="modal-dialog modal-@yield('size', 'lg')" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detalhes</h5>
            <button type="button" class="close popup-modal-dismiss" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @yield('content')
        </div>
    </div>
</div>