<div class="row">
    <div class="col-8">
        <h4 class="c-grey-900 mB-30">
            {{ $pageSelected }} <small>&ndash; {{ $pageName }} {{ $pageSubName }}</small>
        </h4>

        <div class="bgc-white p-20 bd bdrs-3">
            {!! Form::hidden('page_id', optional($page)->id) !!}

            <div class="form-group">
                {!! Form::cInput('text', 'title', 'Título') !!}
            </div>

            <div class="form-group">
                {!! Form::cInput('text', 'title_short', 'Título de chamada', ['class' => 'form-control form-control-sm', 'helpIcon' => 'Mude o título apenas nas chamadas das postagens. Isso é útil para não quebrar o layout do site quando um título principal for muito grande.']) !!}
            </div>

            <div class="form-group">
                {!! Form::cInput('text', 'description', 'Descrição') !!}
            </div>

            <div class="form-group mb-0">
                {!! Form::label('body', 'Texto', ['class' => 'font-weight-bold']) !!}
                {!! Form::hidden('body', isset($record) ? $record->body : null) !!}
                <div id="editor" data-input="[name='body']" class="form-control h-auto pr-0 pt-0 pb-0 pl-2"></div>
            </div>
        </div>

        <div class="bgc-white mT-30 pT-20 pL-20 pR-20 pB-15 bd bdrs-3 clearfix">
            <h5 class="c-grey-900 mB-30">
                Imagens
            </h5>
            <div class="form-group mb-0">
                {!! Form::cCheckbox('cover_inside', 'Mostrar imagem de capa dentro da postagem', 1, !isset($record) ? true : null) !!}
            </div>
            {!! Form::cFileS('images[]', ' ', ['multiple', 'accept' => 'image/*'], $record ?? null) !!}            
        </div>

        @include('admin.seo._form-include')
    </div>
    <div class="col-4 ">
        <div class="sticky-aside">
            <div class="btn-group btn-block mB-25">
                <button type="submit" name="draft" class="btn bg-white border" title="Salva um rascunho e gera uma pré-visualização (Verifique o bloqueio de Pop-up do navegador)">Prévia</button>
                <button type="submit" class="btn btn-light border" title="Salva e volta para listagem de registros">Salvar</button>
                <button type="submit" name="submit_continue" class="btn btn-primary" title="Salva e continua nesse formulário (Útil para após salvar poder editar na sequência as fotos)">Salvar e continuar</button>
                <a href="{{ session()->get('url.intended') ?? route('posts.index') }}" class="btn bg-white border" title="Volta para listagem de registros ou página anterior a essa">Cancelar</a>
            </div>
            <div class="bgc-white mB-30 p-20 bd bdrs-3">
                <div class="form-group">
                    @include('admin.highlights.button')
                </div>

                @can('related')
                <div class="form-group">
                    @include('admin.related.button')
                </div>
                @endcan

                <div class="form-group">
                    {!! Form::cInput('text', 'published_at', 'Data da postagem', ['class' => 'form-control bg-transparent datetime', 'helpIcon' => 'Para agendar sua publicação selecione uma data futura.'], !isset($record) ? Carbon\Carbon::now()->format('Y-m-d H:i') : optional($record->published_at)->format('Y-m-d H:i') ?? null) !!}
                    <button class="btn btn-link pl-0 pr-0" type="button" data-toggle="collapse" data-target="#collapse-unpublished-at">Programar expiração do post</button>
                </div>    
                
                <div class="collapse {{ is_null(old('unpublished_at')) ? null : 'show' }}" id="collapse-unpublished-at">
                    <div class="form-group">
                        {!! Form::cInput('text', 'unpublished_at', 'Postagem expira em', ['class' => 'form-control bg-transparent datetime', 'placeholder' => 'Selecione uma data', 'helpIcon' => 'Selecione uma data para a postagem não ficar mais visível no site.'], !isset($record) ? null : optional($record->unpublished_at)->format('Y-m-d H:i') ?? null) !!}
                    </div>     
                </div>     

                @php
                    $categoriesList = App\Category::ofPage(optional($page)->id)->orderby('title')->get(['page_id', 'id', 'title', 'slug'])->pluck('title', 'id');
                @endphp
                @if($categoriesList->isNotEmpty())
                <div class="form-group">
                    {!! Form::cSelect('category_id', 'Categoria', $categoriesList->prepend('Sem categoria', ''), null) !!}
                </div>
                @endif

                <div class="form-group">
                    {!! Form::cInput('text', 'hat', 'Chapéu', ['helpIcon' => 'Chapéu é uma pequeno texto que fica acima do título. Quando esse campo estiver vazio poderá aparecer a categoria selecionada caso alguma for selecionada.']) !!}
                </div>

                @include('supports._author-input')

                <div class="form-group">
                    {!! Form::cInput('text', 'source', 'Fonte') !!}
                </div>

                <div class="form-group">
                    {!! Form::cCheckbox('publish', 'Publicar', 1, null) !!}
                </div>

                <div class="form-group mb-0">
                    {!! Form::cCheckbox('commentable', 'Permitir comentários', 1, !isset($record) ? true : null) !!}
                </div>

                @php $destinationsList = App\Destination::get(['id', 'title'])->pluck('title', 'id'); @endphp
                @if($destinationsList->isNotEmpty())
                <div class="mb-0 form-group">
                    {!! Form::cSelect('destination_id', 'Atribuir destino', $destinationsList, isset($record) && isset($record->destinations) ? $record->destinations : null, ['class' => 'form-control select']) !!}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>