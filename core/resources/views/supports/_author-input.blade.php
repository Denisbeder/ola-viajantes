@php
    $userId = auth()->user()->isSuperAdmin ? null : auth()->user()->id;
    $authorList = app('writerForSelectService')->list($page->id, $userId);
    $authorName = old('author_name', @$record->author['name']);
@endphp
@if($authorList->isNotEmpty())
<div class="form-group">
    {!! 
        Form::cSelect(
            'author', 
            'Autor', 
            $authorList->prepend('Escrever um nome', 'static')->prepend('Automático', ''), 
            isset($record) ? ((bool) strlen($authorName) ? 'static' : collect($record->author)->sort()->toJson()) : null, 
            ['helpIcon' => 'Selecione um autor disponível. Só quando for definido um nome para escritor ao criar uma página ou um usuário será mostrado aqui. Em usuários é preciso selecionar a opção: Mostrar dados de escritor nas postagens desse usuário".']
        ) 
    !!}
    
    {!!
        Form::text(
            'author_name', 
            (bool) strlen($authorName) ? $authorName : null, 
            [
                'placeholder' => 'Escreva o nome do autor aqui', 
                'class' => 'form-control mt-1', (bool) !strlen($authorName) ? 'disabled' : '', 
            ]
        ) 
    !!}
</div>
@else
<div class="form-group">
    {!! Form::cInput('text', 'author_name', 'Autor nome', ['helpIcon' => 'Digite o nome escritor da postagem para dar os créditos.'], $authorName) !!}
</div>
@endif