<div class="bgc-white p-20 bd bdrs-3">
    {!! Form::hidden('page_id', optional($page)->id) !!}
    
    <div class="form-row">
        <div class="col">
            <div class="form-group">
                {!! Form::cCheckbox('publish', 'Publicar', 1, !isset($record) ? true : null) !!}
            </div>
        </div>
        <div class="col-auto">
            <div class="form-group">
                @include('admin.highlights.button')
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::cInput('text', 'title', 'Título') !!}
    </div>

    <div class="form-group">
        {!! Form::cTextarea('description', 'Descrição') !!}
    </div>
</div>

<div class="bgc-white mT-30 pT-20 pL-20 pR-20 pB-15 bd bdrs-3 clearfix">
    {!! Form::cFileS('images[]', 'Imagens', ['multiple', 'accept' => 'image/*'], $record ?? null) !!}
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

<div class="bgc-white mT-30 p-20 bd bdrs-3">
    <h5 class="c-grey-900 mb-0">Otimização SEO <button class="btn btn-link btn-sm text-secondary text-decoration-none" type="button" data-toggle="collapse" data-target="#seo"><i class="ti-arrow-circle-down"></i></button></h5>
    <div class="collapse show mT-30" id="seo">
        <div class="form-group">
            {!! Form::cInput('text', 'seo_title', 'Título da página') !!}
        </div>
        <div class="form-group">
            {!! Form::cInput('text', 'seo_keywords', 'Palavras-chaves', ['helpText' => 'Separe por vírgula as palavras-chaves']) !!}
        </div>
        <div class="form-group mb-0">
            {!! Form::cTextarea('seo_description', 'Descrição da página') !!}
        </div>

        @isset($record)            
        <div class="form-group mb-0 mt-3">
            {!! Form::cInputSlug('slug', 'URL', ['prependText' => config('app.url') . $page->present()->url . '/', 'disabled']) !!}
        </div>
        @endisset
    </div>
</div>