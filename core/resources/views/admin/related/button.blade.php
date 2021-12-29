<a href="#selection-related-modal" class="btn bg-white border btn-block popup-modal">    
    {!! (isset($record) && $record->related->count() > 0)
    ? '<strong class="text-muted">' . $record->related->count() . ' Relacionados [Editar]</strong>' 
    : '<span>Adicionar</span> Relacionados' !!}
</a>
@include('admin.related.selection-modal')