<div class="bgc-white p-20 bd bdrs-3">
    {!! Form::hidden('page_id', optional($page)->id) !!}
    {!! Form::hidden('m', request()->query('m')) !!}

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
        {!! Form::cInput('text', 'url', 'Vídeo URL') !!}
    </div>

    @php
    $categoriesList = App\Category::ofPage(optional($page)->id)->orderby('title')->get(['page_id', 'id', 'title', 'slug'])->pluck('title', 'id');
    @endphp
    @if($categoriesList->isNotEmpty())
    <div class="form-group">
        {!! Form::cSelect('category_id', 'Categoria', $categoriesList->prepend('Sem categoria', ''), null) !!}
    </div>
    @endif

    @if(isset($record) || request()->query('m'))
    <div class="form-group">
        {!! Form::cInput('text', 'title', 'Título') !!}
    </div>

    <div class="form-group">
        {!! Form::cTextarea('description', 'Descrição') !!}
    </div>

    <div class="form-group">
        {!! Form::cFile('image', 'Imagem', ['accept' => 'image/*']) !!}
    </div>

    @if(isset($record) && (bool) strlen($img = $record->present()->imgFirst('image', ['width' => 100, 'height' => 75, 'fit' => 'crop', 'class' => 'bdrs-3'])))
    <div class="form-group">
        <div id="video-image-preview-alt" class="form-group">
            {!! $img !!}
        </div>
    </div>
    @endif

    <div class="form-group mb-0">
        {!! Form::cTextarea('script', 'Script') !!}
    </div>
    @endif
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