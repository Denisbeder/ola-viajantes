@foreach ([
['key' => 'header', 'label' => 'Menu do topo <small>Principal</small>'],
['key' => 'footer', 'label' => 'Menu do rodapé'],
//['key' => 'sidebar', 'label' => 'Menu barra lateral'],
] as $item)
<div class="bgc-white mT-30 p-20 bd bdrs-3">
    <h5 class="c-grey-900 mb-0">
        {!! $item['label'] !!}
        <button class="btn btn-link btn-sm text-secondary text-decoration-none" type="button" data-toggle="collapse" data-target="#{!! $item['key'] !!}"><i class="ti-arrow-circle-down"></i></button>
    </h5>
    <div class="container-fields collapse mT-30" id="{!! $item['key'] !!}">
        <div class="form-group mb-0">
            <button type="button" class="btn btn-success btn-sm mb-3 add-fields"><i class="ti-plus"></i> Add opções</button>

            <div class="clone-fields" style="display: none;">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <div class="form-row">
                                <div class="col">
                                    {!! Form::text($item['key'].'[0][title]', '', ['class' => 'form-control', 'disabled', 'placeholder' => 'Título']) !!}
                                </div>
                                <div class="col">
                                    {!! Form::text($item['key'].'[0][icon]', '', ['class' => 'form-control', 'disabled', 'placeholder' => 'Ícone']) !!}
                                </div>
                                <div class="col">
                                    {!! Form::select($item['key'].'[0][type]', ['static' => 'Tipo estático', 'dinamic' => 'Tipo dinâmico'], '', ['class' => 'form-control menu-type-select', 'disabled']) !!}
                                </div>
                            </div>

                            <div class="static-option mt-2">
                                {!! Form::text($item['key'].'[0][url]', '', ['class' => 'form-control', 'disabled', 'placeholder' => 'URL']) !!}
                            </div>

                            <div class="form-row dinamic-option mt-2" style="display: none;">
                                <div class="col">
                                    {!! Form::select($item['key'].'[0][page]', ['' => 'Selecione uma página'] + App\Page::orderby('title')->get()->pluck('title', 'id')->toArray(), '', ['class' => 'form-control', 'disabled']) !!}
                                </div>
                                <div class="col">
                                    {!! Form::select($item['key'].'[0][submenu]', ['' => 'Não mostrar submenu para este item', 'page_childrens' => 'Submenu com páginas filhas', 'page_categories' => 'Submenu com categorias da página'], '', ['class' => 'form-control', 'disabled']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger remove-fields"><i class="ti-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fields">
                @php
                    $collection = $record->{$item['key']} ?? [];
                @endphp
                @forelse ($collection as $k => $it)
                <div class="form-group" style="border-top: 1px dashed #CCC; padding-top: 25px;">
                    <div class="form-row">
                        <div class="col">
                            <div class="form-row">
                                <div class="col">
                                    {!! Form::text($item['key'].'['.$k.'][title]', @$it['title'], ['class' => 'form-control', 'placeholder' => 'Título']) !!}
                                </div>
                                <div class="col">
                                    {!! Form::text($item['key'].'['.$k.'][icon]', @$it['icon'], ['class' => 'form-control', 'placeholder' => 'Ícone']) !!}
                                </div>
                                <div class="col">
                                    {!! Form::select($item['key'].'['.$k.'][type]', ['static' => 'Tipo estático', 'dinamic' => 'Tipo dinâmico'], @$it['type'], ['class' => 'form-control menu-type-select']) !!}
                                </div>
                            </div>

                            <div class="mt-2 static-option" style="display: {{ $it['type'] == 'static' ? 'flex' : 'none' }};">
                                {!! Form::text($item['key'].'['.$k.'][url]', @$it['url'], ['class' => 'form-control', 'placeholder' => 'URL']) !!}
                            </div>

                            <div class="form-row dinamic-option mt-2" style="display: {{ $it['type'] == 'dinamic' ? 'flex' : 'none' }};">
                                <div class="col">
                                    {!! Form::select($item['key'].'['.$k.'][page]', ['' => 'Selecione uma página'] + App\Page::orderby('title')->get()->pluck('title', 'id')->toArray(), @$it['page'], ['class' => 'form-control']) !!}
                                </div>
                                <div class="col">
                                    {!! Form::select($item['key'].'['.$k.'][submenu]', ['' => 'Não mostrar submenu para este item', 'page_childrens' => 'Submenu com páginas filhas', 'page_categories' => 'Submenu com categorias da página'], @$it['page_childrens'], ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger remove-fields"><i class="ti-trash"></i></button>
                        </div>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach ([
['key' => 'social_header', 'label' => 'Menu redes sociais no topo'],
['key' => 'social_footer', 'label' => 'Menu redes sociais no rodapé'],
] as $item)
<div class="bgc-white mT-30 p-20 bd bdrs-3">
    <h5 class="c-grey-900 mb-0">
        {!! $item['label'] !!}
        <button class="btn btn-link btn-sm text-secondary text-decoration-none" type="button" data-toggle="collapse" data-target="#{!! $item['key'] !!}"><i class="ti-arrow-circle-down"></i></button>
    </h5>
    <div class="container-fields collapse mT-30" id="{!! $item['key'] !!}">
        <div class="form-group mb-0">
            <button type="button" class="btn btn-success btn-sm mb-3 add-fields"><i class="ti-plus"></i> Add opções</button>

            <div class="clone-fields" style="display: none;">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <div class="form-row">
                                <div class="col">
                                    {!! Form::text($item['key'].'[0][title]', '', ['class' => 'form-control', 'disabled', 'placeholder' => 'Título']) !!}
                                </div>
                                <div class="col">
                                    {!! Form::text($item['key'].'[0][icon]', '', ['class' => 'form-control', 'disabled', 'placeholder' => 'Ícone']) !!}
                                </div>
                            </div>

                            <div class="mt-2 static-option">
                                {!! Form::text($item['key'].'[0][url]', '', ['class' => 'form-control', 'disabled', 'placeholder' => 'URL']) !!}
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger remove-fields"><i class="ti-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fields">
                @php
                    $collection = $record->{$item['key']} ?? [];
                @endphp
                @forelse ($collection as $k => $it)
                <div class="form-group" style="border-top: 1px dashed #CCC; padding-top: 25px;">
                    <div class="form-row">
                        <div class="col">
                            <div class="form-row">
                                <div class="col">
                                    {!! Form::text($item['key'].'['.$k.'][title]', @$it['title'], ['class' => 'form-control', 'placeholder' => 'Título']) !!}
                                </div>
                                <div class="col">
                                    {!! Form::text($item['key'].'['.$k.'][icon]', @$it['icon'], ['class' => 'form-control', 'placeholder' => 'Ícone']) !!}
                                </div>
                            </div>

                            <div class="mt-2">
                                {!! Form::text($item['key'].'['.$k.'][url]', @$it['url'], ['class' => 'form-control', 'placeholder' => 'URL']) !!}
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger remove-fields"><i class="ti-trash"></i></button>
                        </div>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
</div>
@endforeach