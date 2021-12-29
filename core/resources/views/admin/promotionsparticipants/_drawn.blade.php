<div class="bgc-white p-0 pB-10 bd bdrs-3 mB-30">
    <h4 class="pT-20 pL-20 pR-20">Sorteados</h4>
    <div class="pX-20"><strong>Total: {{ $promotion->participants->whereNotNull('drawn')->count() }}</strong></div>
    <ul class="list-group list-group-flush">
        @foreach ($promotion->participants->whereNotNull('drawn')->sortBy('drawn') as $item)
        <li class="list-group-item">
            <p class="mb-0">{{ $item->name }}</p>
            <small>
                <i class="ti-email"></i> {{ $item->email }}<br>
                <i class="ti-mobile"></i> {{ $item->phone }}<br>
                <em>Sorteado em {{ $item->drawn->format('d/m/Y H:i:s') }}</em>
            </small>
        </li>
        @endforeach
    </ul>
</div>