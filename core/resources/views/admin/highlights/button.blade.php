<a href="#selection-highlight-modal" class="btn bg-white border btn-block popup-modal">
    {!! (isset($record) && $position = optional($record->highlight)->position) 
    ? '<strong class="text-muted">Em destaque na posição ' . $position . ' [Editar]</strong>' 
    : 'Destacar <span>na página inicial</span>' !!}
</a>
@include('admin.highlights.selection-modal')