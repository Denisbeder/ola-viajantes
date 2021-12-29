@if(request()->hasAny(['category', 'order', 'amount', 'place']))
<strong class="mb-3 d-block" style="font-size: 18px;">
    Filtros selecionados
</strong>

@if(count(request()->except('page')) > 1)
<a href="{{ request()->url() }}" class="p-2 my-1 bg-white border badge badge-light" title="Clique para remover todos os filtros">
    Remover todos os filtros <i class="lni lni-trash"></i>
</a>
@endif

<div class="mb-5">
    @if(request()->has('category') && strlen($queryCategory = optional(optional($page->categories)->firstWhere('slug', request()->get('category')))->title))
    <a href="{{ removeUrlFilter('category') }}" class="p-2 my-1 bg-white border badge badge-light" title="Clique para remover esse filtro">
        {{ $queryCategory }} <i class="lni lni-trash"></i>
    </a>
    @endif

    @if(request()->has('order'))
    <a href="{{ removeUrlFilter('order') }}" class="p-2 my-1 bg-white border badge badge-light" title="Clique para remover esse filtro">
        Organizar: {{ request()->get('order') == 'desc' ? 'Mais recentes' : 'Mais antigos' }} <i class="lni lni-trash"></i>
    </a>
    @endif

    @if(request()->has('amount'))
    <a href="{{ removeUrlFilter('amount') }}" class="p-2 my-1 bg-white border badge badge-light" title="Clique para remover esse filtro">
        Preços: {{ request()->get('amount') == 'asc' ? 'Mais barato primeiro' : 'Mais caro primeiro' }} <i class="lni lni-trash"></i>
    </a>
    @endif

    @if(request()->has('place'))
    <a href="{{ removeUrlFilter('place') }}" class="p-2 my-1 bg-white border badge badge-light" title="Clique para remover esse filtro">
        {{ request()->get('place') }} <i class="lni lni-trash"></i>
    </a>
    @endif
</div>
@endif

<strong class="mb-3 d-block" style="font-size: 18px;">
    Buscar
</strong>
<div class="mb-5">
    <form method="get" onsubmit="javascript: window.location.href = '?filter=' + this.elements[0].value; return false;" class="input-group">
        <input type="text" class="border form-control" placeholder="Buscar" value="{{ request()->query('filter') }}">
        <div class="input-group-append">
            <button class="border btn btn-sm btn-outline-secondary border-left-0 rounded-right" type="submit"><i class="lni lni-search-alt"></i></button>
        </div>
    </form>
</div>

@if(optional($page->categories)->isNotEmpty())
<strong class="mb-3 d-block" style="font-size: 18px;">
    Categoria
</strong>
<div class="mb-5">
    <select name="category" id="category-filter-advert" class="border form-control" onchange="javascript: window.location.href = this.value;">
        <option value="">Selecione</option>
        @foreach ($page->categories->sortBy('title') as $item)
        <option value="{{ makeUrlFilter(['category' => $item->slug]) }}">{{ $item->title }}</option>
        @endforeach
    </select>
</div>
@endif

<strong class="mb-3 d-block" style="font-size: 18px;">
    Organizar
</strong>
<ul class="mb-5 list-group list-group-flush-">
    <a href="{{ makeUrlFilter(['order' => 'desc']) }}" class="list-group-item list-group-item-action">Mais recentes</a>
    <a href="{{ makeUrlFilter(['order' => 'asc']) }}" class="list-group-item list-group-item-action">Mais antigos</a>
</ul>

<strong class="mb-3 d-block" style="font-size: 18px;">
    Preços
</strong>
<ul class="mb-5 list-group list-group-flush-">
    <a href="{{ makeUrlFilter(['amount' => 'asc']) }}" class="list-group-item list-group-item-action">Mais barato primeiro</a>
    <a href="{{ makeUrlFilter(['amount' => 'desc']) }}" class="list-group-item list-group-item-action">Mais caro primeiro</a>
</ul>

@if(count($wheres) > 0)
<strong class="mb-3 d-block" style="font-size: 18px;">
    Localização
</strong>
<ul class="list-group list-group-flush-">
    @foreach ($wheres as $item)
    <a href="{{ makeUrlFilter(['place' => $item]) }}" class="list-group-item list-group-item-action">{{ $item }}</a>
    @endforeach
</ul>
@endif