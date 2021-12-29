<form id="promotions-form" action="/support/promotionparticipant/save" method="POST" class="p-4 border bg-light">
    <div id="promotion-alert" class="alert" style="display: none;"></div>
    <input type="hidden" name="id" value="{{ encrypt($data->id) }}">
    <div class="mb-5">
        <strong style="font-size: 20px;">
            PARTICIPAR
        </strong>
    </div>
    <div class="form-group">
        <label for="name">Nome *</label>
        <input type="text" name="name" id="name" class="form-control">
    </div>
    <div class="form-row">
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="email">E-mail *</label>
                <input type="text" name="email" id="email" class="form-control">
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="phone">Telefone *</label>
                <input type="text" name="phone" id="phone" class="form-control phone">
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-between">
        <button type="submit" class="btn btn-sm btn-dark">Enviar</button>
        <div class="text-right text-muted"><small>Campos obrigatório estão marcados com *</small></div>
    </div>
</form>