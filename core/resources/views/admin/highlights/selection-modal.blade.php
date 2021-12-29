<div id="selection-highlight-modal" class="mfp-hide" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Selecione uma posição</h5>
                <button type="button" class="close popup-modal-dismiss" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="flex-row flex-wrap highlight-positions d-flex justify-content-start" data-toggle="buttons">
                    @for ($i = 0; $i < 18; $i++)         
                        @php
                            $value = isset($record) && !is_null($record->highlight) ? $record->highlight->position : null;
                            $old = old('highlight', $value);
                            $checked = $old == $i ? 'checked' : null;
                        @endphp                  
                        <label class="border btn highlight-positions-item h-100">
                            @if ($i == 0)
                                <input type="radio" name="highlight", value="{{ $i }}" {{ $old == $i ? 'checked' : true }}>
                                Nenhum
                            @else                                
                                <input type="radio" name="highlight", value="{{ $i }}" {{ $old == $i ? 'checked' : '' }}>
                                Posição {{ $i }}
                                <div class="mb-2 d-flex ml-n1 align-items-stretch" style="height: 22px">
                                    <div class="w-50 mr-1 flex-fill d-flex {{ $i == 1 ? 'bg-warning border-warning' : 'bg-light border' }}"></div>
                                    <div class="w-50 flex-fill d-flex {{ $i == 2 ? 'bg-warning border-warning' : 'bg-light border' }}"></div>
                                </div>

                                <div class="mb-2 d-flex ml-n1 align-items-stretch" style="height: 15px">
                                    <div class="w-30 mr-1 flex-fill d-flex {{ $i == 3 ? 'bg-warning border-warning' : 'bg-light border' }}"></div>
                                    <div class="w-30 mr-1 flex-fill d-flex {{ $i == 4 ? 'bg-warning border-warning' : 'bg-light border' }}"></div>
                                    <div class="w-30 flex-fill d-flex {{ $i == 5 ? 'bg-warning border-warning' : 'bg-light border' }}"></div>
                                </div>

                                <div class="mb-2 d-flex ml-n1 align-items-stretch">
                                    <div class="mr-1 d-flex flex-column" style="width: 30%">
                                        <div class="w-100 d-flex {{ $i == 6 ? 'bg-warning border-warning' : 'bg-light border' }} mb-1" style="height: 15px"></div>
                                        
                                        <div class="d-flex" >
                                            <div class="w-50 mr-1 flex-filld-flex {{ $i == 7 ? 'bg-warning border-warning' : 'bg-light border' }}" style="height: 15px"></div>
                                            <div class="w-50 flex-fill d-flex {{ $i == 8 ? 'bg-warning border-warning' : 'bg-light border' }}" style="height: 15px"></div>
                                        </div>
                                    </div>
                                    <div class="mr-1 d-flex flex-column" style="width: 30%">
                                        <div class="w-100 d-flex {{ $i == 9 ? 'bg-warning border-warning' : 'bg-light border' }}" style="height: 35px"></div>
                                    </div>
                                    <div class="d-flex flex-column" style="width: 30%">
                                        <div class="w-100 d-flex {{ $i == 10 ? 'bg-warning border-warning' : 'bg-light border' }} mb-1" style="height: 15px"></div>

                                        <div class="d-flex" >
                                            <div class="w-50 mr-1 flex-fill d-flex {{ $i == 11 ? 'bg-warning border-warning' : 'bg-light border' }}" style="height: 15px"></div>
                                            <div class="w-50 flex-fill d-flex {{ $i == 12 ? 'bg-warning border-warning' : 'bg-light border' }}" style="height: 15px"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-2 d-flex ml-n1 align-items-stretch">
                                    <div class="w-30 mr-1 flex-fill d-flex {{ $i == 13 ? 'bg-warning border-warning' : 'bg-light border' }}" style="height: 15px"></div>
                                    <div class="w-30 mr-1 flex-fill d-flex {{ $i == 14 ? 'bg-warning border-warning' : 'bg-light border' }}" style="height: 15px"></div>
                                    <div class="w-30 mr-1 flex-fill d-flex {{ $i == 15 ? 'bg-warning border-warning' : 'bg-light border' }}" style="height: 15px"></div>
                                    <div class="w-30 flex-fill d-flex {{ $i == 16 ? 'bg-warning border-warning' : 'bg-light border' }}" style="height: 15px"></div>
                                </div>                                   

                                <div class="mb-2 d-flex ml-n1 align-items-stretch">
                                    <div class="mr-1 d-flex flex-column" style="width: 70%">    
                                        <div class="d-flex w-100 mb-1">
                                            <div class="w-30 mr-1 flex-fill d-flex {{ $i == 17 ? 'bg-warning border-warning' : 'bg-light border' }}" style="height: 15px"></div>
                                            <div class="w-30 mr-1 flex-fill d-flex {{ $i == 17 ? 'bg-warning border-warning' : 'bg-light border' }}" style="height: 15px"></div>
                                            <div class="w-30 flex-fill d-flex {{ $i == 17 ? 'bg-warning border-warning' : 'bg-light border' }}" style="height: 15px"></div>
                                        </div>                                    
                                        <div class="d-flex w-100">
                                            <div class="w-30 mr-1 flex-fill d-flex bg-light border align-items-end justify-content-center text-muted" style="height: 15px">x</div>
                                            <div class="w-30 mr-1 flex-fill d-flex bg-light border align-items-end justify-content-center text-muted" style="height: 15px">x</div>
                                            <div class="w-30 flex-fill d-flex bg-light border align-items-end justify-content-center text-muted" style="height: 15px">x</div>
                                        </div>                                          
                                    </div>
                                
                                    <div class="d-flex flex-column" style="width: 30%">
                                        <div class="w-100 flex-fill d-flex bg-light border align-items-center justify-content-center text-muted" style="height: 15px">x</div>
                                    </div>
                                </div>
                                @endif
                            </label>          
                    @endfor
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="bg-white border btn popup-modal-dismiss">Finalizar</button>
            </div>
        </div>
    </div>
</div>