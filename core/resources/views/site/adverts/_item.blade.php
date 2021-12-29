<a href="{{ $item->present()->url }}" class="card card-post {{ $class ?? '' }}">
    {!! $item->present()->imgFirst('images', ['width' => '200', 'height' => '200', 'fit' => 'crop', 'class' => 'card-img-top img-fluid border'], null, isset($lazy) ? $lazy : false) !!}
    <div class="p-3 border card-body d-flex flex-column align-items-start justify-content-start border-top-0 rounded-bottom">
        @if((bool) strlen($category = optional($item->category)->title))
        <h5 class="card-text card-subject">{{ $category }}</h5>
        @endif
        <h2 class="card-title text-break" style="font-size: 18px">{{ $item->title }}</h2>
        @if((bool) strlen($where = $item->where))
        <p class="card-text text-break" style="font-size: 14px">Em {{ $where }}</p>
        @endif
        <p class="mt-auto card-text" style="font-size: 12px">
            @if((bool) strlen($amount = $item->amount))
                <strong>R$ {{ $amount }}</strong>
            @else
            <em>Preço não informado</em>
            @endif
            <br />
            {{ $item->present()->forHumans }}
        </p>
    </div>
</a>