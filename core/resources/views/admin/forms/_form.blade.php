<div class="bgc-white p-20 bd bdrs-3">
    {!! Form::hidden('page_id', optional($page)->id) !!}

    <div class="form-group mb-0">
        {!! Form::cInput('text', 'email', 'E-mail que recebará esse formulário') !!}
    </div>
</div>

<div class="bgc-white pT-20 pL-20 pR-20 bd bdrs-3 mT-30">
    <h5 class="c-grey-900 mB-30">Campos do formulário</h5>
    <div class="container-fields">
        <div class="form-group mb-0">
            <button type="button" class="btn btn-success btn-sm mb-3 add-fields"><i class="ti-plus"></i> Add campo</button>

            <div class="clone-fields" style="display: none;">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-5">
                            {!! Form::text('fields[0][name]', '', ['class' => 'form-control disabled', 'placeholder' => 'Nome do campo', 'disabled']) !!}
                        </div>
                        <div class="col">
                            {!! Form::select('fields[0][type]', ['text' => 'Tipo Texto', 'textarea' => 'Caixa de Texto', 'email' => 'Tipo E-mail', 'select' => 'Caixa de Seleção'], 'text', ['class' => 'form-control disabled forms-type', 'disabled']) !!}
                        </div>
                        <div class="col-auto">
                            {!! Form::select('fields[0][width]', ['25' => 'Largura 25%', '50' => 'Largura 50%', '75' => 'Largura 75%', '100' => 'Largura 100%'], 100, ['class' => 'form-control disabled', 'disabled']) !!}
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger remove-fields"><i class="ti-trash"></i></button>
                        </div>
                    </div>
                    <div class="form-row mt-3 forms-type-options" style="display: none;">
                        <div class="col offset-5">
                            @include('admin.forms._form-options')
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fields">
                @php
                $fieldsCollection = $record->fields ?? [];
                @endphp
                @forelse ($fieldsCollection as $k => $item)
                <div class="form-group" style="border-top: 1px dashed #CCC; padding-top: 25px;">
                    <div class="form-row">
                        <div class="col-5">
                            {!! Form::text('fields['.$k.'][name]', @$item['name'], ['class' => 'form-control']) !!}
                        </div>
                        <div class="col">
                            {!! Form::select('fields['.$k.'][type]', ['text' => 'Tipo Texto', 'textarea' => 'Caixa de Texto', 'email' => 'Tipo E-mail', 'select' => 'Caixa de Seleção'], @$item['type'], ['class' => 'form-control forms-type']) !!}
                        </div>
                        <div class="col-auto">
                            {!! Form::select('fields['.$k.'][width]', ['25' => 'Largura 25%', '50' => 'Largura 50%', '75' => 'Largura 75%', '100' => 'Largura 100%'], @$item['width'], ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger remove-fields"><i class="ti-trash"></i></button>
                        </div>
                    </div>
                    <div class="form-row mt-3 forms-type-options" style="display: {{ isset($item['options']) ? '' : 'none' }};">
                        <div class="col offset-5">
                            @include('admin.forms._form-options', ['prefixKey' => $k, 'options' => @$item['options']])
                        </div>
                    </div>
                </div>               
                @empty
                @endforelse
            </div>
        </div>
    </div>
</div>