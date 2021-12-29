@php
$nodes = $records;

$tree = function ($datas, $prefix = false) use (&$tree) {
    $template = '';
    foreach ($datas as $data) {
        //$classWhenPrefix = $prefix ? 'class="ml-5"' : null;

        $template .= '<tr>'; 

        $template .= '<td width="1%">'; 
        $template .= Form::cCheckbox('record[' . $data->id . ']', null, $data->id, null, ['classWrap' => 'ml-3', 'class' => 'check-single']); 
        $template .= '</td>'; 

        $template .= '<td class="align-middle" width="1%">'; 
        $template .= $data->id; 
        $template .= '</td>'; 

        $template .= '<td class="align-middle" width="18%">'; 
        $template .= '<a href="' . route('pages.edit', ['id' => $data->id]) . '">' . $data->title . '</a>'; 
        $template .= '</td>';  

        $template .= '<td class="align-middle" width="40%">'; 
        $template .= $data->present()->url; 
        $template .= '</td>'; 

        $template .= '<td class="align-middle" width="20%">'; 
        $template .= $data->present()->managerTypeLabelWithHref; 
        $template .= '</td>'; 

        $template .= '<td class="align-middle" width="10%">'; 
        $template .= $data->present()->publishLabel; 
        $template .= '</td>';         

        $template .= '<td class="align-middle text-right" width="10%">'; 
        $template .= view('admin._actions-btn')->with([
            'edit' => $data->present()->managerButton . '<a href="'. route('pages.edit', ['id' => $data->id]) .'" class="btn btn-light btn-sm border">Editar</a>',
            'record' => $data, 
            'comments' => false,
            'publish' => auth()->user()->isSuperAdmin,
            'delete' => auth()->user()->isSuperAdmin,
            'duplicate' => auth()->user()->isSuperAdmin,
        ]);
        $template .= '</td>';       

        if ($data->children->isNotempty()) {
            $template .= '<tr class="bg-transparent">';
            $template .= '<td class="pt-0 pb-0 pr-0 pl-5" colspan="7">'; 
                $template .= '<table class="table my-0" style="top:-1px; position:relative;">'; 

                $template .= $tree($data->children, true);
                
                $template .= '</table>';
            $template .= '</td>';
            $template .= '</tr>';
        }

        $template .= '</tr>';
    }
    return $template;
};
@endphp

<table id="dataTable" class="table table-hover border-bottom mb-0" cellspacing="0" width="100%" {{ ($touched = session()->get('touched')) ? 'data-touched='.$touched  : null }}>
    <thead>
        <tr>
            <th class="border-top-0" width="1%">{!! Form::cCheckbox('check-all', null, null, null, ['classWrap' => 'ml-3 mb-2', 'data-target' => '.check-single']) !!}</th>
            <th class="border-top-0" width="1%">#</th>
            <th class="border-top-0" width="18%">Título</th>
            <th class="border-top-0" width="40%">URL</th>
            <th class="border-top-0" width="20%">Recurso de gerenciamento</th>
            <th class="border-top-0" width="10%">Publicado</th>
            <th class="border-top-0" width="10%"></th>
        </tr>
    </thead>

    <tbody>
        {!! $tree($nodes) !!}
    </tbody>
</table>
