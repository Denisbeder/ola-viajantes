<div class="row">
    <div class="col-4">
        <div class="bgc-white pT-20 pL-20 pR-20 bd bdrs-3 mT-30">
            <h5 class="c-grey-900 mB-30">Geral</h5>

            <div class="form-group">
                {!! Form::cInput('text', 'data[name]', 'Nome do site', [], @$record->data['name']) !!}
            </div>

            <div class="form-group">
                {!! Form::cInput('text', 'data[slogan]', 'Slogan', [], @$record->data['slogan']) !!}
            </div>
        </div>

        <div class="bgc-white pT-20 pL-20 pR-20 bd bdrs-3 mT-30">
            <h5 class="c-grey-900 mB-30">Estatísticas</h5>
          
            <div class="form-group">
                {!! Form::cInput('text', 'data[analytics_id]', 'ID da vista da propriedade', [], @$record->data['analytics_id']) !!}
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="bgc-white pT-20 pL-20 pR-20 bd bdrs-3 mT-30">
            <h5 class="c-grey-900 mB-30">SEO Página inicial</h5>

            <div class="form-group">
                {!! Form::cTextarea('data[seo][description]', 'Descrição', ['rows' => 7, 'style' => 'min-height: 161px'], @$record->data['seo']['description']) !!}
            </div>

            <div class="form-group">
                {!! Form::cTextarea('data[seo][keywords]', 'Palavras-chaves', ['rows' => 3, 'helpText' => 'Separe por vírgula as palavras-chaves', 'style' => 'min-height: 78px'], @$record->data['seo']['keywords']) !!}
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="bgc-white pT-20 pL-20 pR-20 bd bdrs-3 mT-30">
            <h5 class="c-grey-900 mB-30">Ações</h5>

            <div class="form-group">
                <button type="button" class="btn btn-warning confirm-alert" data-confirm-body="Você tem certeza que deseja fazer isso?" data-confirm-redirect-to="/admin/settings" data-confirm-id="2" data-confirm-method="put">
                    <i class="ti-trash"></i> Limpar cache do site
                </button>
            </div>

            <div class="form-group">               
                <button type="submit" form="sitemap_generate" class="btn btn-info">
                    <i class="ti-file"></i> Gerar Sitemap
                </button>                
            </div>

            @if(auth()->user()->isSuperAdmin)
            <div class="form-group">
                <button type="button" class="btn btn-danger confirm-alert" data-confirm-body="Você tem certeza que deseja fazer isso?" data-confirm-redirect-to="/admin/settings" data-confirm-id="1" data-confirm-method="put">
                    <i class="ti-alert"></i> Entrar/Sair manutenção do site
                </button>
            </div>
            @endif
        </div>

        @can('facebookconnect')
        <div class="bgc-white pT-20 pL-20 pR-20 bd bdrs-3 mT-30">
            <h5 class="c-grey-900 mB-30">Conectar</h5>

            <div class="form-group">
                @include('supports.facebookconnect.button-login')
            </div>
        </div>
        @endcan
    </div>
</div>

<div class="bgc-white pT-20 pL-20 pR-20 bd bdrs-3 mT-30">
    <h5 class="c-grey-900 mB-30">Scripts</h5>
    <div class="row">
        <div class="col-4">
            <div class="form-group">
                {!! Form::cTextarea('data[scripts][head]', 'Scripts para antes da tag </head>', ['rows' => 25], @$record->data['scripts']['head']) !!}
            </div>
        </div>

        <div class="col-4">
            <div class="form-group">
                {!! Form::cTextarea('data[scripts][footer]', 'Scripts para antes da tag </body>', ['rows' => 25], @$record->data['scripts']['body']) !!}
            </div>
        </div>

        <div class="col-4">
            <div class="form-group">
                {!! Form::cTextarea('ads', 'Aqruivo ads.txt', ['rows' => 25], $ads) !!}
            </div>
        </div>
    </div>
</div>