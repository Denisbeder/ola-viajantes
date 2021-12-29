<div class="bgc-white p-20 bd bdrs-3">
    <div class="form-group">
        {!! Form::cInput('text', 'title', 'Título') !!}
    </div>

    <div class="form-group">
        {!! Form::cSelect('page_id', 'Pertence a página', ['' => 'Selecione'] + App\Page::where('manager->type', '<>', 'App\Form')->where('manager->type', '<>', 'App\Promotion')->orderby('title')->get()->pluck('title', 'id')->toArray()) !!}
    </div>

    <div class="form-group mb-0">
        {!! Form::hidden('publish', 0) !!}
        {!! Form::cCheckbox('publish', 'Publicar', 1, !isset($record) ? true : null) !!}
    </div>
</div>