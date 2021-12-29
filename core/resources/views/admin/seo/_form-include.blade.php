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
            {!! Form::cInputSlug('slug', 'URL', ['prependText' => config('app.url') . str_replace($record->slug, '', $record->present()->url), 'disabled']) !!}
        </div>
        @endisset
    </div>
</div>