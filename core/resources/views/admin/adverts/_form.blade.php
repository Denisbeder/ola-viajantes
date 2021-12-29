<div class="p-20 bgc-white bd bdrs-3">
    {!! Form::hidden('page_id', optional($page)->id) !!}
    
    <div class="form-group">
        {!! Form::cCheckbox('publish', 'Publicar', 1, !isset($record) ? true : null) !!}
    </div>

    <div class="form-group">
        {!! Form::cInput('text', 'title', 'Título') !!}
    </div>

    <div class="form-row">
        <div class="col">
            <div class="form-group">
                {!! Form::cSelect('state_id', 'Estado', App\State::all()->pluck('uf', 'id')->prepend('Selecione', ''), isset($record) ? $record->city->state->id : null) !!}
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                {!! Form::cSelect('city_id', 'Onde está o item anunciado', isset($record) ? App\City::where('state_id', $record->city->state->id)->get()->pluck('name', 'id') : [], null) !!}
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                {!! Form::cInput('text', 'amount', 'Valor', ['class' => 'form-control money']) !!}
            </div>
        </div>
        {{-- @php
        $categoriesList = App\Category::ofPage(optional($page)->id)->orderby('title')->get(['page_id', 'id', 'title', 'slug'])->pluck('title', 'id');
        @endphp
        @if($categoriesList->isNotEmpty())
        <div class="col">
            <div class="form-group">
                {!! Form::cSelect('category_id', 'Categoria', $categoriesList->prepend('Sem categoria', ''), null) !!}
            </div>
        </div>
        @endif --}}
    </div>

    <div class="form-group">
        {!! Form::cTextarea('body', 'Descrição') !!}
    </div>

    <div class="form-row">
        <div class="col">
            <div class="form-group">
                <label class="font-weight-bold">Opções</label>
                <div class="container-fields">
                    <div class="mb-0 form-group">
                        <button type="button" class="mb-3 btn btn-success btn-sm add-fields"><i class="ti-plus"></i> Add opções</button>
            
                        <div class="clone-fields" style="display: none;">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col">
                                        {!! Form::text('optional[0][title]', '', ['class' => 'form-control', 'placeholder' => 'Título', 'disabled']) !!}
                                    </div>
                                    <div class="col-auto">
                                        {!! Form::select('optional[0][icon]', ['' => 'Ícone (Nenhum)'] + collect(config('app.admin.icons'))->pluck('label', 'key')->toArray(), null, ['class' => 'form-control', 'disabled']) !!}
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-danger remove-fields"><i class="ti-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fields">
                            @php
                            $optionalCollection = $record->optional ?? [];
                            @endphp
                            @forelse ($optionalCollection as $k => $item)
                            <div class="form-group" style="border-top: 1px dashed #CCC; padding-top: 25px;">
                                <div class="form-row">
                                    <div class="col">
                                        {!! Form::text('optional['.$k.'][title]', $item['title'], ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-auto">
                                        {!! Form::select('optional['.$k.'][icon]', ['' => 'Ícone (Nenhum)'] + collect(config('app.admin.icons'))->pluck('label', 'key')->toArray(), $item['icon'], ['class' => 'form-control']) !!}
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
        <div class="col">
            <div class="form-group">
                <label class="font-weight-bold">Telefones</label>
                <div class="container-fields">
                    <div class="mb-0 form-group">
                        <button type="button" class="mb-3 btn btn-success btn-sm add-fields"><i class="ti-plus"></i> Add telefones</button>
            
                        <div class="clone-fields" style="display: none;">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col">
                                        {!! Form::text('phones[]', '', ['class' => 'form-control phone', 'placeholder' => '(XX) 99999-0000', 'disabled']) !!}
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-danger remove-fields"><i class="ti-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fields">
                            @php
                            $phonesCollection = $record->phones ?? [];
                            @endphp
                            @forelse ($phonesCollection as $k => $item)
                            <div class="form-group" style="border-top: 1px dashed #CCC; padding-top: 25px;">
                                <div class="form-row">
                                    <div class="col-11">
                                        {!! Form::text('phones['.$k.']', $item, ['class' => 'form-control phone']) !!}
                                    </div>
                                    <div class="col-1">
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
    </div>
</div>

<div class="clearfix bgc-white mT-30 pT-20 pL-20 pR-20 pB-15 bd bdrs-3">
    {!! Form::cFileS('images[]', 'Imagens', ['multiple', 'accept' => 'image/*'], $record ?? null) !!}
</div>

<div class="p-20 bgc-white mT-30 bd bdrs-3">
    <h5 class="mb-0 c-grey-900">Agendar <button class="btn btn-link btn-sm text-secondary text-decoration-none" type="button" data-toggle="collapse" data-target="#body"><i class="ti-arrow-circle-down"></i></button></h5>
    <div class="collapse show mT-30" id="body">
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
    <h5 class="mb-0 c-grey-900">Otimização SEO <button class="btn btn-link btn-sm text-secondary text-decoration-none" type="button" data-toggle="collapse" data-target="#seo"><i class="ti-arrow-circle-down"></i></button></h5>
    <div class="collapse show mT-30" id="seo">
        <div class="form-group">
            {!! Form::cInput('text', 'seo_title', 'Título da página') !!}
        </div>
        <div class="form-group">
            {!! Form::cInput('text', 'seo_keywords', 'Palavras-chaves', ['helpText' => 'Separe por vírgula as palavras-chaves']) !!}
        </div>
        <div class="mb-0 form-group">
            {!! Form::cTextarea('seo_description', 'Descrição da página') !!}
        </div>

        @isset($record)            
        <div class="mt-3 mb-0 form-group">
            {!! Form::cInputSlug('slug', 'URL', ['prependText' => config('app.url') . $page->present()->url . '/', 'disabled']) !!}
        </div>
        @endisset
    </div>
</div>