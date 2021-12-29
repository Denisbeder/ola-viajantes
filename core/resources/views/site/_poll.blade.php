@php $pollCurrent = app('pollService'); @endphp
@if(!is_null($pollCurrent))

<form class="px-4 mb-5 overflow-hidden border rounded border-primary" action="/support/poll/{{ '1' }}/save" method="POST" id="poll-form">
    <div class="mb-4 box-title" style="margin-top: -1px;">Enquete</div>
    <div id="poll-alert" class="mb-4 border-0 rounded-sm mx-n4 alert rounded-0" style="display: none;"></div>
    
    <strong class="mb-4 d-block">{{ $pollCurrent->title }}</strong>
    
    {{-- Options --}}
    <div id="poll-options">            
        @foreach ($pollCurrent->options as $k => $option)
        <label class="px-3 py-2 mb-0 border-bottom border-top w-100" style="margin-top: -1px">
            <input type="radio" name="option" class="mr-2" value="{{ $option->id }}"> {{ $option->title }}
        </label>
        @endforeach
       
        <div class="mt-4 d-flex flex-column mx-n4">
            <button type="button" class="mx-auto mb-3 border rounded btn btn-sm btn-light font-weight-light poll-btn-toggle" style="font-size: 12px;">RESULTADOS</button>
            <button type="submit" class="btn btn-lg btn-primary flex-fill rounded-0">VOTAR</button>
        </div>
    </div>
    
    {{-- Results --}}
    <div id="poll-result" style="display: none;">
        <div id="poll-result-items">                               
            @foreach ($pollCurrent->options as $k => $option)
            <div class="mb-3 overflow-hidden border-top border-bottom w-100 poll-result-item" id="poll-option-key-{{ $option->id }}" data-percent="{{ $option->percent }}">
                <div class="px-3 mt-2">
                    {{ $option->title }} 
                    
                </div>
                <div class="px-3 mb-1 poll-option-total-votes">
                    <strong class="text-primary">{{ $option->percent }}%</strong> 
                    <small class="text-muted"><em>(<span>{{ $option->votes_count }}</span> votos)</em></small>
                </div>
                <div class="overflow-hidden w-100" style="height: 6px;">
                    <div class="bg-primary" style="width: {{ $option->percent }}%; height: 6px;"></div>
                </div>
            </div>
            @endforeach
        </div>
        
        <small id="poll-total-votes" class="mb-0 text-muted"><em>Total de votos: <span>{{ $pollCurrent->votes_count }}</span></em></small> 
       
        <div class="mt-4 d-flex mx-n4">
            <button type="button" class="btn btn-lg btn-light font-weight-light border-top poll-btn-toggle btn-block rounded-0" style="font-size: 12px;">VOLTAR</button>
        </div>
    </div>
</form>
@endif