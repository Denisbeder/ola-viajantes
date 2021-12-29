@php
    isset($delete) && !$delete ? null : $massOptions['delete'] = 'Deletar';
    isset($publish) && !$publish ? null : $massOptions['publish'] = 'Publicar';
    isset($unpublish) && !$unpublish ? null : $massOptions['unpublish'] = 'Não publicar';
    isset($duplicate) && !$duplicate ? null : $massOptions['duplicate'] = 'Duplicar';
@endphp
{!!
Form::cSelect('mass-action', null, ['Ação em massa'] + $massOptions, null, [
    'class' => 'form-control bg-white',
    'data-target' => '.check-single',
    'style' => 'display: none;'
])
!!}