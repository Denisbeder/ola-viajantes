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
                    {!! Form::cSelect('parent_id', 'É uma subpágina de...', ['' => 'Ninguém'] + App\Page::except($record->id ?? null)->orderby('title')->get(['id', 'title'])->pluck('title', 'id')->toArray()) !!}
                </div>
            </div>
            <div class="col">
                @if(!isset($record))
                <div class="form-group">
                    {!! Form::cSelect('manager[type]', 'Usa recurso de gerenciamento de página', collect(config('app.admin.managers'))->sortBy('label')->pluck('label', 'model')->prepend('Nenhum', '')) !!}
                </div>
                @else
                <div class="form-group">
                    <label class="font-weight-bold">Usa recurso de gerenciamento de página</label>
                    <div class="form-control bg-light">{{ $record->manager['type'] ?? 'Nenhum' }}</div>
                </div>
                @endif
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
    <h5 class="c-grey-900 mb-0">Corpo da página <button class="btn btn-link btn-sm text-secondary text-decoration-none" type="button" data-toggle="collapse" data-target="#body"><i class="ti-arrow-circle-down"></i></button></h5>
    <div class="collapse show mT-30" id="body">
        {!! Form::hidden('body', isset($record) ? e($record->body) : null) !!}
        <div id="editor" data-input="[name='body']" class="form-control h-auto pr-0 pt-0 pb-0 pl-2"></div>
    </div>
</div>

<div class="bgc-white mT-30 p-20 bd bdrs-3">
    <h5 class="c-grey-900 mb-0">Imagens da página <button class="btn btn-link btn-sm text-secondary text-decoration-none" type="button" data-toggle="collapse" data-target="#image-files"><i class="ti-arrow-circle-down"></i></button></h5>
    <div class="collapse mT-30" id="image-files">
        {!! Form::cFileS('images[]', 'Imagens', ['multiple', 'accept' => 'image/*'], $record ?? null) !!}
    </div>
</div>

<div class="bgc-white mT-30 p-20 bd bdrs-3">
    <h5 class="c-grey-900 mb-0">Dados escritor padrão<button class="btn btn-link btn-sm text-secondary text-decoration-none" type="button" data-toggle="collapse" data-target="#writer-box"><i class="ti-arrow-circle-down"></i></button></h5>
    <div class="collapse mT-30" id="writer-box">
        <div class="form-row">
            <div class="col-3">
                {!! Form::cFile('avatar', 'Avatar', ['accept' => 'image/*'], $record ?? null) !!}
                @if(isset($record) && !is_null($avatar = $record->getFirstMedia('avatar')))
                {!! $avatar->img(['class' => 'rounded mt-3', 'style' => 'width: 150px; height: 150px; object-fit: cover;']) !!}

                <button type="button" class="btn btn-sm btn-white border confirm-alert mt-3" data-confirm-body="Você tem certeza que deseja fazer isso?" data-confirm-url="/admin/medias" data-confirm-id="{{ $avatar->id }}" data-confirm-method="delete">
                    <i class="ti-trash"></i> Deletar imagem
                </button>
                @endif
            </div>
            <div class="col">
                <div class="form-group">
                    {!! Form::cInput('text', 'writer[name]', 'Nome') !!}
                </div>
                <div class="form-group">
                    {!! Form::cTextarea('writer[description]', 'Descrição') !!}
                </div>
                <div class="form-group">
                    {!! Form::cInput('text', 'writer[email]', 'E-mail') !!}
                </div>
                <div class="form-group">
                    {!! Form::cInput('text', 'writer[url]', 'URL/Site/Rede Social') !!}
                </div>
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

        @if(auth()->user()->isSuperAdmin)
            @isset($record)
            <div class="form-group mb-0 mt-3">
                @php
                $prependText = config('app.url') . '/' . $record->ancestors()->defaultOrder()->get()->pluck('slug')->implode('/') . '/';
                @endphp
                {!! Form::cInputSlug('slug', 'URL', ['disabled', 'prependText' => rtrim($prependText, '/') . '/']) !!}
            </div>
            @endisset
        @endif
    </div>
</div>