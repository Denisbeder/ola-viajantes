@if(auth()->user()->isSuperAdmin)
<div class="bgc-white p-20 bd bdrs-3">
    <div class="form-group">
        {!! Form::cInput('text', 'title', 'Título') !!}
    </div>

    <div class="form-group mb-md-0">
        {!! Form::cCheckbox('publish', 'Publicar', 1, !isset($record) ? true : null) !!}
    </div>
</div>

<div class="bgc-white mT-30 p-20 bd bdrs-3">
    <h5 class="c-grey-900 mb-0">Configurações <button class="btn btn-link btn-sm text-secondary text-decoration-none" type="button" data-toggle="collapse" data-target="#settings"><i class="ti-arrow-circle-down"></i></button></h5>
    <div class="collapse show mT-30" id="settings">
        <div class="form-row">
            <div class="col-5">
                <div class="form-group">
                    {!! Form::cSelect('parent_id', 'É um sub-destino de...', ['' => 'Ninguém'] + App\Page::except($record->id ?? null)->orderby('title')->get(['id', 'title'])->pluck('title', 'id')->toArray()) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="bgc-white p-20 bd bdrs-3">
    <div class="form-group mb-0">
        <label class="font-weight-bold">Título</label>
        <div class="form-control bg-light">{{ $record->title }}</div>
    </div>
    {!! Form::hidden('publish') !!}
</div>
@endif

<div class="bgc-white mT-30 p-20 bd bdrs-3">
    <h5 class="c-grey-900 mb-0">Imagens <button class="btn btn-link btn-sm text-secondary text-decoration-none" type="button" data-toggle="collapse" data-target="#image-files"><i class="ti-arrow-circle-down"></i></button></h5>
    <div class="collapse mT-30" id="image-files">
        {!! Form::cFileS('images[]', 'Imagens', ['multiple', 'accept' => 'image/*'], $record ?? null) !!}
    </div>
</div>