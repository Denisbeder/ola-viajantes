<div class="bgc-white p-20 bd bdrs-3">
    <div class="form-group">
        <div class="form-row d-flex align-items-center">
            <div class="col-auto mr-md-3">
                {!! Form::cCheckbox('publish', 'Publicar', 1, !isset($record) ? true : null) !!}
            </div>

            <div class="col-auto border rounded bg-light d-flex justify-content-center align-items-center px-3 py-1">
                <div class="row ">
                    <div class="col-auto mr-md-3">
                        {!! Form::cRadio('device', 'Visível só Mobile', 'mobile') !!}
                    </div>

                    <div class="col-auto mr-md-3">
                        {!! Form::cRadio('device', 'Visível só Desktop', 'desktop') !!}
                    </div>

                    <div class="col-auto">
                        {!! Form::cRadio('device', 'Visível Mobile e Desktop', 'mobile_desktop', true) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group mb-0">
        {!! Form::cInput('text', 'title', 'Título') !!}
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

<div class="bgc-white mT-30 p-20 bd bdrs-3">
    <div class="form-group">
        {!! Form::cInput('text', 'url', 'URL para clique') !!}
    </div>

    <div class="form-group">
        <div class="form-row">
            <div class="col-6">
                {!!
                Form::cSelect(
                'position',
                'Posição',
                ['' => 'Selecione'] + collect(config('app.banners.positions'))->pluck('label', 'key')->toArray(),
                null,
                ['class' => 'form-control'],
                collect(config('app.banners.positions'))->mapWithKeys(function ($item) {
                return [$item['key'] => ['data-size-keys' => json_encode($item['formats']), 'data-size-keys-original' => json_encode($item['formats'])]];
                })->toArray()
                )
                !!}
            </div>
            <div class="col-6">
                {!! Form::cSelect('size', 'Tamanho', ['' => 'Selecione'] + collect(config('app.banners.formats'))->map(function ($value) {
                $value['label'] = sprintf('%s (%sx%s)', $value['label'], $value['w'], $value['h']);
                return $value;
                })->pluck('label', 'key')->toArray()) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::cFile('file', 'Arquivo', ['accept' => 'image/*,.zip,.mp4', 'helpIcon' => 'É possível usar banner nos formatos GIF animados, JPG, PNG, HTML e Vídeo MP4.', 'helpText' => 'Arquivos para Mobile tem o tamanho padronizado em 320x100px']) !!}
        @isset($record)
        {!! $record->present()->render(['style' => 'max-width: 100%']) !!}
        @endisset
    </div>

    <div class="form-group mb-0">
        {!! Form::cTextarea('script', 'Script', ['helpIcon' => 'Use esse campo para banners do Google Adsense ou similares.']) !!}
    </div>
</div>