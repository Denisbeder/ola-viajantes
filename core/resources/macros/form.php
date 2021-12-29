<?php

Form::macro('cInput', function ($type = 'text', $name, $label = null, $options = [], $default = null) {
    $label = is_null($label) ? null : Form::label($name, $label, ['class' => 'font-weight-bold']);
    $helpText = isset($options['helpText']) ? '<small class="form-text text-muted">' . $options['helpText'] . '</small>' : null;
    $helpIcon = isset($options['helpIcon']) ? '<i class="ti-help-alt ml-2" data-toggle="tooltip" data-placement="top" title="'.$options['helpIcon'].'"></i>' : null;
    $html = $label;
    $html .= $helpIcon;
    $html .= Form::input($type, $name, $default, array_merge(['class' => 'form-control'], $options));
    $html .= $helpText;
    return $html;
});

Form::macro('cSelect', function ($name, $label = null, $values = [], $selected = null, $options = [], $optionsAttr = []) {
    $label = is_null($label) ? null : Form::label($name, $label, ['class' => 'font-weight-bold']);
    $helpText = isset($options['helpText']) ? '<small class="form-text text-muted">' . $options['helpText'] . '</small>' : null;
    $helpIcon = isset($options['helpIcon']) ? '<i class="ti-help-alt ml-2" data-toggle="tooltip" data-placement="top" title="'.$options['helpIcon'].'"></i>' : null;
    
    $html = $label;
    $html .= $helpIcon;
    $html .= Form::select($name, $values, $selected, array_merge(['class' => 'form-control'], $options), $optionsAttr);
    $html .= $helpText;
    return $html;
});

Form::macro('cFile', function ($name, $label = null, $options = []) {
    $labelName = $label;
    $label = is_null($label) ? null : Form::label(Str::slug($name), $label, ['class' => 'font-weight-bold']);
    $multipleOptions = in_array('multiple', $options) ? ['data-multiple-caption' => '{count} arquivos selecionados'] : [];
    $helpText = isset($options['helpText']) ? '<small class="form-text text-muted">' . $options['helpText'] . '</small>' : null;
    $helpIcon = isset($options['helpIcon']) ? '<i class="ti-help-alt ml-2" data-toggle="tooltip" data-placement="top" title="'.$options['helpIcon'].'"></i>' : null;

    $html = $label;
    $html .= $helpIcon;
    $html .= Form::file($name, array_merge(['id' => Str::slug($name), 'class' => 'inputfile'], $options, $multipleOptions));
    $html .= '<label class="bg-light" for="' . Str::slug($name) . '">';
    $html .= '<i class="ti-image"></i> ';
    $html .= '<span>' . $labelName . '&hellip;</span>';
    $html .= '</label>';
    $html .= $helpText;
    return $html;
});

Form::macro('cFileS', function ($name, $label = null, $options = [], $record = null) {
    $label = is_null($label) ? null : Form::label(Str::slug($name), $label, ['class' => 'font-weight-bold w-100']);
    $multipleOptions = in_array('multiple', $options) ? ['data-multiple-caption' => '{count} arquivos selecionados'] : [];
    $helpText = isset($options['helpText']) ? '<small class="form-text text-muted">' . $options['helpText'] . '</small>' : null;
    $helpIcon = isset($options['helpIcon']) ? '<i class="ti-help-alt ml-2" data-toggle="tooltip" data-placement="top" title="'.$options['helpIcon'].'"></i>' : null;

    $html = $label;
    $html .= $helpIcon;
    $html .= '<div id="inputfile-preview" class="inputfile-preview medias-sortable">';
    $html .=  Form::file($name, array_merge(['id' => Str::slug($name), 'class' => 'inputfile square preview'], $options, $multipleOptions));
    $html .= '<label class="bg-light" for="' . Str::slug($name) . '">';
    $html .= '<i class="ti-image"></i>';
    $html .= '<span>Selecione</span>';
    $html .= '</label>';
    $html .= !is_null($record) ? $record->present()->imgsEditable(['width' => 100, 'height' => 100, 'fit' => 'crop']) : null;
    $html .= '</div>';
    $html .= $helpText;
    $html .= is_null($record) 
        ? '<small class="form-text text-muted d-block"><i class="ti-alert text-warning"></i> Atenção: As imagens somente ficarão disponíveis para legendar ou ordenar após o registro ter sido salvo e passar a existir no banco de dados.</small>'
        : '<small class="form-text text-muted d-block"><i class="ti-info-alt text-info"></i> Passe o mouse por cima da imagem que deseja colocar uma legenda e clique no icone de lápis; Clique no icone de lixeira para deletar a imagem selecionada; Clique e arraste sobre a imagem para troca-lá de posição; A imgem de capa será sempre a primeira da esqueda para direita.</small>';
    return $html;
});

Form::macro('cTextarea', function ($name, $label = null, $options = [], $default = null) {
    $label = is_null($label) ? null : Form::label($name, $label, ['class' => 'font-weight-bold']);
    $helpText = isset($options['helpText']) ? '<small class="form-text text-muted">' . $options['helpText'] . '</small>' : null;
    $helpIcon = isset($options['helpIcon']) ? '<i class="ti-help-alt ml-2" data-toggle="tooltip" data-placement="top" title="'.$options['helpIcon'].'"></i>' : null;

    $html = $label;
    $html .= $helpIcon;
    $html .= Form::textarea($name, $default, array_merge(['class' => 'form-control', 'rows' => 3], $options));
    $html .= $helpText;
    return $html;
});

Form::macro('cCheckbox', function ($name, $label = null, $value = '', $checked = null, $options = []) {
    $checkboxId = Str::contains($name, '[') ? preg_replace('/\[.*\]/', '', $name) . '_' . Str::random(5) . '_' . $value : $name;
    $helpText = isset($options['helpText']) ? '<small class="form-text text-muted">' . $options['helpText'] . '</small>' : null;
    $classWrap = isset($options['classWrap']) ? $options['classWrap'] : null;

    $html = '<div class="checkbox checkbox-circle checkbox-info peers ai-c '.$classWrap.'">';
    $html .= Form::checkbox($name, $value, $checked, ['id' => $checkboxId] + $options);
    $html .= '<label for="' . $checkboxId . '" class="peers peer-greed js-sb ai-c">';
    $html .= '<span class="peer peer-greed">' . $label . '</span>';
    $html .= '</label>';
    $html .= '</div>';
    $html .= $helpText;
    return $html;
});

Form::macro('cRadio', function ($name, $label = null, $value = '', $checked = null, $options = []) {
    $radioId = $name . '_' . Str::random(5) . '_' . $value;
    $helpText = isset($options['helpText']) ? '<small class="form-text text-muted">' . $options['helpText'] . '</small>' : null;
    $classWrap = isset($options['classWrap']) ? $options['classWrap'] : null;

    $html = '<div class="radio radio-circle radio-info peers ai-c '.$classWrap.'">';
    $html .= Form::radio($name, $value, $checked, ['id' => $radioId] + $options);
    $html .= '<label for="' . $radioId . '" class="peers peer-greed js-sb ai-c">';
    $html .= '<span class="peer peer-greed">' . $label . '</span>';
    $html .= '</label>';
    $html .= '</div>';
    $html .= $helpText;
    return $html;
});

Form::macro('cRange', function ($name, $start, $end, $selected = '', $options = []) {
    $helpText = isset($options['helpText']) ? '<small class="form-text text-muted">' . $options['helpText'] . '</small>' : null;
    return Form::selectRange($name, $start, $end, $selected, array_merge(['class' => 'form-control'], $options))  . $helpText;
});

Form::macro('cInputSlug', function ($name, $label = null, $options = [], $default = null) {
    $idModal = is_null($label) ? 'slug-modal' : strtolower($label);
    $label = is_null($label) ? null : Form::label($name, $label, ['class' => 'font-weight-bold']);
    $helpText = isset($options['helpText']) ? '<small class="form-text text-muted">' . Arr::pull($options, 'helpText') . '</small>' : null;
    $helpIcon = isset($options['helpIcon']) ? '<i class="ti-help-alt ml-2" data-toggle="tooltip" data-placement="top" title="'.Arr::pull($options, 'helpIcon').'"></i>' : null;
    $prependText = isset($options['prependText']) ? Arr::pull($options, 'prependText') : config('app.url');

    $html = $label;
    $html .= $helpIcon;    
    $html .= '<div class="input-group">';
    $html .= '<div class="input-group-prepend">';
    $html .= '<span class="input-group-text">' . $prependText . '</span>';
    $html .= '</div>';
    $html .= Form::input('text', $name, $default, array_merge(['class' => 'form-control', 'data-slug-from' => '#title', 'data-slug-preview' => '#slug-preview', 'readonly', 'title' => 'Clique duas vezes para editar'], $options));
    $html .= '<button type="button" class="btn bg-light border bdrsL-0 border-left-0"><i class="ti-pencil-alt"></i></button>';
    $html .= $helpText;
    $html .= '</div>';
    return $html;
});