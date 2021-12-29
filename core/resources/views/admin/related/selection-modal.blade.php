<div id="selection-related-modal" class="mfp-hide" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Relacionados</h5>
                <button type="button" class="close popup-modal-dismiss" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label(null, 'Onde mostrar os relacionamentos', ['class' => 'font-weight-bold']) !!}
                    @php
                        $relatedShowOn = isset($record) ? $record->related->pluck('show_on')->collapse()->unique() : collect(['in_home', 'in_text']);
                    @endphp
                    <div class="form-group mt-0 mb-0 d-flex">
                    {!! Form::cCheckbox('related_show_on[]', 'Dentro o texto (Leia Também)', 'in_text', $relatedShowOn->contains('in_text')) !!}
                    {{-- {!! Form::cCheckbox('related_show_on[]', 'Na Home', 'in_home', $relatedShowOn->contains('in_home'), ['class' => 'ml-3']) !!} --}}
                </div>
                </div>
                <div class="form-group">
                    {!! Form::text('search', '', ['id' => 'autocompleter', 'class' => 'rounded-pill w-100 form-control form-control-lg', 'placeholder' => 'Digite partes do título que deseja encontrar', 'autocomplete' => 'off', 'data-model' => 'post', 'data-field' => 'title']) !!}
                    <small class="form-text text-muted">Somente os registros que estão publicados serão
                        buscados.</small>
                </div>

                <div id="container-related" class="bg-light mb-n3 mx-n3 px-3 pb-3">
                    @forelse (old('related', $record->related ?? []) as $k => $item)                    
                        <div class="form-row border-top border-white pt-3 mb-3 mx-n3 px-3" style="border-width: 8px !important">
                            <div class="col-auto flex-fill">
                                <input name="related[{{ $k }}][title]" value="{{ $item['title'] }}" type="text" class="form-control mb-1">
                                <input name="related[{{ $k }}][url]" value="{{ $item['url'] }}" type="text" class="form-control form-control-sm bg-light">
                            </div>
                            <div class="col-auto"><button class="btn btn-danger btn-sm mt-1 related-remove" title="Remover"><i class="ti-trash"></i></button>
                            </div>
                        </div>
                    @empty                        
                    @endforelse
                    <div class="pt-3" id="empty-related" style="{{ count(old('related', $record->related ?? [])) > 0 ? 'display:none' : 'display:block' }}"><small>Sem relacionamentos</small></div>  
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-white border popup-modal-dismiss">Finalizar</button>
            </div>
        </div>
    </div>
</div>
