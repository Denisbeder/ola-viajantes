<div class="row">
    <div class="col">
        <div class="bgc-white p-20 bd bdrs-3">
            <div class="form-group">
                {!! Form::cCheckbox('publish', 'Ativado', 1, isset($record) ? null : true) !!}
            </div>

            @if(isset($record))
            <div class="form-group">
                {!! Form::cCheckbox('uses_writer', 'Mostrar dados de escritor nas postagens desse usuário', 1, null) !!}
            </div>
            @endif

            <div class="form-group">
                {!! Form::cInput('text', 'name', 'Nome') !!}
            </div>

            <div class="form-group">
                {!! Form::cInput('username', 'username', 'Usuário', ['helpText' => 'Digite um nome curto por exemplo, o primeiro nome ou um apelido', 'helpIcon' => 'Com esse esse campo o usuário poderá fazer login apenas com o seu nome ao invés do e-mail.']) !!}
            </div>

            <div class="form-group">
                {!! Form::cInput('email', 'email', 'E-mail') !!}
            </div>

            <div class="form-group">
                {!! Form::cInput('password', 'password', 'Senha') !!}
            </div>

            <div class="form-group mb-0">
                {!! Form::cInput('password', 'password_confirmation', 'Repita a senha') !!}
            </div>
        </div>
    </div>

    <div class="col">
        @can('userspermissions')
        <div class="bgc-white p-20 bd bdrs-3">
            {{-- <div class="form-group">
                {!! Form::cCheckbox('admin', 'Admin', 1) !!}
            </div> --}}

            <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        {!! Form::label('Permissões', null, ['class' => 'font-weight-bold']) !!}
                        @foreach (collect(config('app.admin.permissions')) as $item)
                            <div class="form-group mb-2">                
                            {!! Form::cCheckbox('permissions[routes][]', $item['label'], $item['route']) !!}                  
                            </div>         
                        @endforeach
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        {!! Form::label('Permissões para páginas', null, ['class' => 'font-weight-bold']) !!}
                        @foreach (App\Page::withDepth()->orderby('_lft')->get() as $page)
                            <div class="form-group mb-2 mL-{{ $page->depth * 10 }}">      
                            {!! Form::cCheckbox('permissions[pages][]', 'Página: ' . $page->title, 'page_' . Str::slug(@$page->manager['type']) . '_' . $page->id) !!}  
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>
</div>

<div class="bgc-white mT-30 p-20 bd bdrs-3">
    <h5 class="c-grey-900 mb-0">Dados escritor para divulgar nas postagems <button class="btn btn-link btn-sm text-secondary text-decoration-none" type="button" data-toggle="collapse" data-target="#writer-box"><i class="ti-arrow-circle-down"></i></button></h5>
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