<div class="p-20 bgc-white bd bdrs-3">
    {!! Form::hidden('page_id', optional($page)->id) !!}

    <div class="form-group">
        {!! Form::cCheckbox('publish', 'Publicar', 1, !isset($record) ? true : null) !!}
    </div>

    <div class="form-group">
        {!! Form::cInput('text', 'title', 'Título') !!}
    </div>

    <div class="form-group">
        {!! Form::label('body', 'Texto', ['class' => 'font-weight-bold']) !!}
        {!! Form::hidden('body', isset($record) ? e($record->body) : null) !!}
        <div id="editor-basic" data-input="[name='body']" class="h-auto pt-0 pb-0 pl-2 pr-0 form-control"></div>
    </div>    

    <div class="mb-0 form-group">
        {!! Form::cSelect('mode', 'Modo de participação', ['' => 'Sem participação pelo site', 'form_default' => 'Formulário padrão', /* 'form_datas' => 'Formulário com envio de dados' */]) !!}
    </div>
</div>

<div class="p-20 bgc-white mT-30 bd bdrs-3">
    <h5 class="mb-0 c-grey-900">Agendar <button class="btn btn-link btn-sm text-secondary text-decoration-none" type="button" data-toggle="collapse" data-target="#body"><i class="ti-arrow-circle-down"></i></button></h5>
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

<div class="p-20 bgc-white mT-30 bd bdrs-3">
    <div class="form-group">
        {!! Form::cFile('image', 'Imagem', ['accept' => 'image/*']) !!}
    </div>

    @if(isset($record) && (bool) strlen($img = $record->present()->imgFirst('image', ['width' => 100, 'height' => 75, 'fit' => 'crop', 'class' => 'bdrs-3'])))
    <div class="mb-0 form-group">
        <div id="video-image-preview-alt" class="form-group">
            {!! $img !!}
        </div>
    </div>
    @endif
</div>
