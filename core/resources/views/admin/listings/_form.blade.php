<div class="bgc-white p-20 bd bdrs-3">
    {!! Form::hidden('page_id', optional($page)->id) !!}
    
    <div class="form-group">
        {!! Form::cCheckbox('publish', 'Publicar', 1, !isset($record) ? true : null) !!}
    </div>

    @empty($lastCreateId = request()->query('lc'))
        <div class="form-row">
            <div class="col-4">
                <div class="form-group">
                    {!! Form::cSelect('parent_id', 'É uma sublista de', ['' => 'Nenhuma'] + App\Listing::orderby('title')->get()->pluck('title', 'id')->toArray()) !!}
                </div>
            </div>
        </div>
    @else
        <div class="form-group border rounded-lg bg-light p-5">
            <h5 class="m-0">Esse registro será adicionado como sublista de <strong>{{ App\Listing::find($lastCreateId)->title }}</strong></h5>
            {!! Form::hidden('parent_id', $lastCreateId) !!}
        </div>
    @endempty


    <div class="form-group">
        {!! Form::cInput('text', 'title', 'Título') !!}
    </div>

    <div class="form-group mb-0">
        {!! Form::label('body', 'Texto', ['class' => 'font-weight-bold']) !!}
        {!! Form::hidden('body', isset($record) ? e($record->body) : null) !!}
        <div id="editor-basic" data-input="[name='body']" class="form-control h-auto pr-0 pt-0 pb-0 pl-2"></div>
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

<div class="bgc-white mT-30 pT-20 pL-20 pR-20 pB-15 bd bdrs-3 clearfix">
    {!! Form::cFileS('images[]', 'Imagens', ['multiple', 'accept' => 'image/*'], $record ?? null) !!}
</div>