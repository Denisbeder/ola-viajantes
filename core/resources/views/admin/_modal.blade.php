<div id="{{ isset($id) ? $id : 'modal' }}" class="mfp-hide" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{!! $title ?? 'Atenção!' !!}</h5>
                <button type="button" class="close popup-modal-dismiss" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @isset($body)
                    {!! $body !!}
                @else
                    Aviso importante! Você tem certeza que deseja fazer isso?<br>
                    Esta ação é irreversível!
                @endisset
            </div>
            <div class="modal-footer">
                @isset($buttonCancel)
                    {!! $buttonCancel !!}
                @else
                    <button type="button" id="confirm-modal-button-cancel" class="btn bg-white border popup-modal-dismiss">Cancelar</button>
                @endisset
            
                @isset($buttonConfirm)
                    {!! $buttonConfirm !!}
                @else
                    <button type="button" id="confirm-modal-button-ok" class="btn bg-primary text-white border popup-modal-dismiss">Ok</button>
                @endisset
            </div>
        </div>
    </div>
</div>