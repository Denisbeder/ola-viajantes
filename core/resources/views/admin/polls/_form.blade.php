<div class="bgc-white p-20 bd bdrs-3">
    <div class="form-group">
        {!! Form::hidden('publish', 0) !!}
        {!! Form::cCheckbox('publish', 'Publicar', 1, !isset($record) ? true : null) !!}
    </div>

    <div class="form-group mb-0">
        {!! Form::cInput('text', 'title', 'Título (Pergunta)') !!}
    </div>   
</div>

<div class="bgc-white mT-30 pT-20 pL-20 pR-20 pB-5 bd bdrs-3">
    <h5 class="c-grey-900 mb-0">Opções <button class="btn btn-link btn-sm text-secondary text-decoration-none" type="button" data-toggle="collapse" data-target="#options-body"><i class="ti-arrow-circle-down"></i></button></h5>
    <div class="collapse show mT-30" id="options-body">
        <div class="container-fields">
            <div class="form-group mb-0">
                <button type="button" class="btn btn-success btn-sm mb-3 add-fields"><i class="ti-plus"></i> Add opções</button>
    
                <div class="clone-fields" style="display: none;">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                                {!! Form::text('options[0][title]', '', ['class' => 'form-control', 'disabled']) !!}
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger remove-fields"><i class="ti-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fields">
                    @php
                    $optionsCollection = $record->options ?? [];
                    @endphp
                    @forelse ($optionsCollection as $k => $item)
                    <div class="form-group" style="border-top: 1px dashed #CCC; padding-top: 25px;">
                        <div class="form-row">
                            <div class="col">
                                {!! Form::text('options['.$k.'][title]', $item->title, ['class' => 'form-control']) !!}
                                {!! Form::hidden('options['.$k.'][id]', $item->id) !!}
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
        </div>
    </div>
</div> 

<div class="bgc-white mT-30 p-20 bd bdrs-3">
    <h5 class="c-grey-900 mb-0">Agendar <button class="btn btn-link btn-sm text-secondary text-decoration-none" type="button" data-toggle="collapse" data-target="#body"><i class="ti-arrow-circle-down"></i></button></h5>
    <div class="collapse mT-30" id="body">
        <div class="form-row">
            <div class="col">
                {!! Form::cInput('text', 'published_at', 'Data da postagem', ['class' => 'form-control bg-transparent datetime', 'placeholder' => 'Selecione uma data', 'helpIcon' => 'Para agendar sua publicação selecione uma data futura.'], !isset($record) ? null : optional($record->published_at)->format('Y-m-d H:i') ?? null) !!}
            </div>
            <div class="col">
                {!! Form::cInput('text', 'unpublished_at', 'Postagem expira em', ['class' => 'form-control bg-transparent datetime', 'placeholder' => 'Selecione uma data', 'helpIcon' => 'Selecione uma data para a postagem não ficar mais visível no site.'], !isset($record) ? null : optional($record->unpublished_at)->format('Y-m-d H:i') ?? null) !!}
            </div>
        </div>
    </div>
</div> 
