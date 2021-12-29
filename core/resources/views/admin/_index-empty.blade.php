<div class="bgc-white pT-100 pB-100 pL-20 pR-20 bd bdrs-3 d-flex align-items-center justify-content-center flex-column">
    @if (!isset($icon) || $icon === true)
        <i class="ti-info-alt icon-4x mb-3"></i>
    @elseif(isset($icon) && $icon !== false) 
        {!! $icon !!}
    @endif

    <h2 class="font-weight-light">
    @if (!isset($message) || $message === true)
        Nenhum registro foi criado ainda.
    @elseif(isset($message) && $message !== false) 
        {!! $message !!}
    @endif
    </h2>

    @if (!isset($button) || $button === true)
        <a href="/{{ request()->route()->uri }}/create" class="btn btn-lg btn-primary mt-3">Novo</a> 
    @elseif(isset($button) && $button !== false) 
        {!! $button !!}
    @endif
</div>