<div class="form-group mb-0">
    <button type="button" class="btn btn-success btn-sm mb-3 add-fields"><i class="ti-plus"></i> Add opção para campo Caixa de Seleção</button>

    <div class="clone-fields" data-prefix-key="{{ @$prefixKey }}" data-prefix-uses="true" style="display: none;">
        <div class="form-group">
            <div class="form-row">
                <div class="col">
                    {!! Form::text('fields[0][options][]', '', ['class' => 'form-control disabled', 'placeholder' => 'Nome da opção', 'disabled']) !!}
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger remove-fields"><i class="ti-trash"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fields">
        @php
        $fieldsOptionsCollection = $options ?? [];
        @endphp
        @forelse ($fieldsOptionsCollection as $k => $item)
        <div class="form-group" style="border-top: 1px dashed #CCC; padding-top: 25px;">
            <div class="form-row">
                <div class="col">
                    {!! Form::text('fields['.@$prefixKey.'][options]['.$k.']', $item, ['class' => 'form-control']) !!}
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger remove-fields"><i class="ti-trash"></i></button>
                </div>
            </div>
        </div>
        @empty
        @endforelse
    </div>
</div>