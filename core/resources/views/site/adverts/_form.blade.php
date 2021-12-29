<input name="page_id" type="hidden" value="{{ encrypt($page->id) }}">
@if(isset($data))
<input name="id" type="hidden" value="{{ encrypt($data->id) }}">
@endif

<div id="advert-alert" class="alert" style="display: none;"></div>
<div class="form-group">
    <label for="email">E-mail</label>
    @if(!isset($data))
    <input name="email" id="email" type="text" class="form-control border" value="{{ isset($data) ? $data->email : '' }}">
    @else
    <br>
    <div class="form-control border bg-light">{{ $data->email }}</div>
    <input name="email" type="hidden" value="{{ $data->email }}">
    @endif
</div>

<div class="form-group">
    <label for="title">Título</label>
    @if(!isset($data))
    <input name="title" id="title" type="text" class="form-control border" value="{{ isset($data) ? $data->title : '' }}">
    @else
    <br>
    <div class="form-control border bg-light">{{ $data->title }}</div>
    <input name="title" type="hidden" value="{{ $data->title }}">
    @endif
</div>

<div class="form-row">
    @if(!isset($data))
    <div class="form-group col">
        <label for="state_id">Estado</label>
        <select name="state_id" id="state_id" class="form-control border">
            <option value="">Selecione</option>
            @foreach (\App\State::get(['uf', 'id']) as $item)
            <option value="{{ $item->id }}">{{ $item->uf }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col">        
        <label for="city_id">Cidade</label>
        <select name="city_id" id="city_id" class="form-control border">
            <option value="">Selecione</option>
        </select>
    </div>
    @else
        <div class="form-group col">
            <label for="city_id">Cidade</label><br>
            <div class="form-control border bg-light">{{ $data->city->name }}</div>
            <input name="city_id" type="hidden" value="{{ $data->city_id }}">
        </div>
    @endif

    <div class="form-group col">
        <label for="amount">Valor</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">R$</span>
            </div>
            <input name="amount" id="amount" type="text" class="form-control border money" value="{{ isset($data) ? $data->amount : '' }}">
        </div>
    </div>
</div>

<div class="form-row">
    <div class="form-group col">
        <label for="phones[0]">Telefone 1</label>
        <input name="phones[0]" id="phones[0]" type="text" class="form-control border phone" value="{{ isset($data) ? @$data->phones[0] : '' }}">
    </div>

    <div class="form-group col">
        <label for="phones[1]">Telefone 2</label>
        <input name="phones[1]" id="phones[1]" type="text" class="form-control border phone" value="{{ isset($data) ? @$data->phones[1] : '' }}">
    </div>
</div>

<div class="form-group">
    <label for="body">Descrição</label>
    <textarea name="body" id="body" rows="6" class="form-control border">{{ isset($data) ? $data->body : '' }}</textarea>
</div>

@if(!isset($data))
<div class="form-group">
    <label for="images[]">Imagens</label>
    <div class="input-group">
        <div class="custom-file">
            <input name="images[]" multiple accept="image/*" type="file" class="custom-file-input" id="images">
            <label class="custom-file-label border" for="images[]">Selecione uma imagem no seu computador</label>
        </div>
    </div>
    <small class="form-text text-muted">
        É permitido o envio de até 3 imagens com tamanho máximo de 1MB cada uma.
    </small>
</div>
@endif