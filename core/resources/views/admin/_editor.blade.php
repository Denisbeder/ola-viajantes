@php
$baseToolbar = [
'bold' => true,
'italic' => true,
'strike' => true,
'link' => true,
'heading1' => true,
'quote' => true,
'bullet' => true,
'number' => true,
'code' => false,
'decreaseNestingLevel' => true,
'increaseNestingLevel' => true,
'attachFiles' => false,
'history' => true,
];
$toolbar = array_merge($baseToolbar, $toolbar ?? []);
$field = $name ?? 'body';
@endphp
<div class="form-group">
    {!! Form::label($field, $label ?? 'Texto', ['class' => 'font-weight-bold']) !!}
    {!! Form::hidden($field, isset($record) ? e($record->$field) : null, ['id' => 'editor']) !!}

    <trix-toolbar id="editor_toolbar">
        <div class="trix-button-row">
            <span class="trix-button-group trix-button-group--text-tools" data-trix-button-group="text-tools">
                @if($toolbar['bold'])
                    <button type="button" class="trix-button trix-button--icon trix-button--icon-bold" data-trix-attribute="bold" data-trix-key="b" title="Negrito" tabindex="-1">Negrito</button>
                @endif

                @if($toolbar['italic'])
                <button type="button" class="trix-button trix-button--icon trix-button--icon-italic" data-trix-attribute="italic" data-trix-key="i" title="Itálico" tabindex="-1">Itálico</button>
                @endif

                @if($toolbar['strike'])
                <button type="button" class="trix-button trix-button--icon trix-button--icon-strike" data-trix-attribute="strike" title="Tachado" tabindex="-1">Tachado</button>
                @endif

                @if($toolbar['link'])
                <button type="button" class="trix-button trix-button--icon trix-button--icon-link" data-trix-attribute="href" data-trix-action="link" data-trix-key="k" title="Link" tabindex="-1">Link</button>
                @endif
            </span>
            <span class="trix-button-group trix-button-group--block-tools" data-trix-button-group="block-tools">
                @if($toolbar['heading1'])
                <button type="button" class="trix-button trix-button--icon trix-button--icon-heading-1" data-trix-attribute="heading1" title="Título" tabindex="-1">Título</button>
                @endif

                @if($toolbar['quote'])
                <button type="button" class="trix-button trix-button--icon trix-button--icon-quote" data-trix-attribute="quote" title="Citação" tabindex="-1">Citação</button>
                @endif

                @if($toolbar['bullet'])
                <button type="button" class="trix-button trix-button--icon trix-button--icon-bullet-list" data-trix-attribute="bullet" title="Marcadores" tabindex="-1">Marcadores</button>
                @endif

                @if($toolbar['number'])
                <button type="button" class="trix-button trix-button--icon trix-button--icon-number-list" data-trix-attribute="number" title="Numeração" tabindex="-1">Numeração</button>
                @endif

                @if($toolbar['code'])
                <button type="button" class="trix-button trix-button--icon trix-button--icon-code" data-trix-attribute="code" title="Código" tabindex="-1">Código</button>
                @endif

                @if($toolbar['decreaseNestingLevel'])
                <button type="button" class="trix-button trix-button--icon trix-button--icon-decrease-nesting-level" data-trix-action="decreaseNestingLevel" title="Diminuir Recuo" tabindex="-1">Diminuir Recuo</button>
                @endif

                @if($toolbar['increaseNestingLevel'])
                <button type="button" class="trix-button trix-button--icon trix-button--icon-increase-nesting-level" data-trix-action="increaseNestingLevel" title="Aumentar Recuo" tabindex="-1">Aumentar Recuo</button>
                @endif
            </span>
            @if($toolbar['attachFiles'])
            <span class="trix-button-group trix-button-group--file-tools" data-trix-button-group="file-tools">
                <button type="button" class="trix-button trix-button--icon trix-button--icon-attach" data-trix-action="attachFiles" title="Anexar arquivos" tabindex="-1">Anexar arquivos</button>
            </span>
            @endif
            @if($toolbar['history'])
            <span class="trix-button-group-spacer"></span>
            <span class="trix-button-group trix-button-group--history-tools" data-trix-button-group="history-tools">
                <button type="button" class="trix-button trix-button--icon trix-button--icon-undo" data-trix-action="undo" data-trix-key="z" title="Desfazer" tabindex="-1">Desfazer</button>
                <button type="button" class="trix-button trix-button--icon trix-button--icon-redo" data-trix-action="redo" data-trix-key="shift+z" title="Refazer" tabindex="-1">Refazer</button>
            </span>
            @endif
        </div>
        <div class="trix-dialogs" data-trix-dialogs>
            @if($toolbar['link'])
            <div class="trix-dialog trix-dialog--link" data-trix-dialog="href" data-trix-dialog-attribute="href">
                <div class="trix-dialog__link-fields">
                    <input type="url" name="href" class="trix-input trix-input--dialog" placeholder="Digite sua URL" aria-label="url" required data-trix-input>
                    <div class="trix-button-group">
                        <input type="button" class="trix-button trix-button--dialog" value="Criar" data-trix-method="setAttribute">
                        <input type="button" class="trix-button trix-button--dialog" value="Remover" data-trix-method="removeAttribute">
                    </div>
                </div>
            </div>
            @endif
        </div>
    </trix-toolbar>
    <trix-editor class="trix-content" toolbar="editor_toolbar" input="editor"></trix-editor>
</div>