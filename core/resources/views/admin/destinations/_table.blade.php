@php
$nodes = $records->toTree();

$tree = function ($datas, $prefix = false) use (&$tree) {
    $template = '';
    foreach ($datas as $data) {
    $img = $data->hasMedia('images') ? $data->present()->imgFirst('images', ['width' => 25, 'height' => 25, 'fit' => 'crop', 'class' => 'rounded-pill']) : null;
    $template .= '<div class="card mt-4 card-listings">';
        //$template .= $prefix ? '<div style="width: 20px; height: 20px;"></div>' : null;
        $template .= '<div class="card-header bg-light border-bottom-0 d-flex align-items-center justify-content-between">';
            $template .= '<div>';
                $template .= '#' . $data->id . ' ';
                $template .= '<strong>' . $data->title . '</strong> ' . $img;
            $template .= '</div>';
            $template .= view('admin._actions-btn')->with([
                'bgColor' => 'bg-white',
                'record' => $data, 
                'view' => false, 
                'comments' => false, 
                'duplicate' => false, 
                'edit' => '
                    <a href="'. route('destinations.edit', ['id' => $data->id]) .'" class="btn bg-white btn-sm border">Editar</a>  
                    <a href="'. route('destinations.create', ['lc' => $data->id]) .'" class="btn bg-white btn-sm border"><i class="ti-plus"></i> Add Parente</a>  
                ',
                'delete' => '
                <button type="button" class="dropdown-item confirm-alert" data-confirm-body="Você tem certeza que deseja deletar o registro <strong>#'.$data->id.'-'.$data->title.'</strong>?<br>Isso irá deletar também todas listas filhas.<br>Esta ação é irreversível!" data-confirm-btn-confirm-label="Deletar" data-confirm-btn-confirm-class="btn-danger" data-confirm-id="'.$data->id.'" data-confirm-method="delete" title="Deletar">
                    Deletar
                </button>
                ',
            ]);
        $template .= '</div>';

        if ($data->children->isNotempty()) {
            $template .= '<div class="card-body pt-0">';
            $template .= $tree($data->children, true);
            $template .= '</div>';
        }

        $template .= '</div>';
    }
    return $template;
};

echo $tree($nodes);
@endphp