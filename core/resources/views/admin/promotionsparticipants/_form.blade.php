<div class="bgc-white p-20 bd bdrs-3">
    {!! Form::open([
        'route' => 'promotionsparticipants.store',
        'files' => false,
    ]) !!}

    {!! Form::hidden('promotion_id', $promotion->id) !!}

    <div class="form-group">
        {!! Form::cInput('number', 'qtd', 'Quantidade de participantes a serem sorteados', [], 1) !!}
    </div>

    <div class="form-group btn-block mb-0">
        <button type="submit" class="btn btn-primary btn-lg btn-block pY-20">INICIAR O SORTEIO</button>
    </div>
    {!! Form::close() !!}
</div>

