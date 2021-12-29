@php
    $routePrefix = !isset($route_prefix) ? request()->segment(2) : $route_prefix;
@endphp
<div class="btn-group">
    {{-- Btn Edit --}}
    @if (!isset($edit) || $edit === true)
        <a href="{{ route($routePrefix . '.edit', ['id' => $record->id]) }}" class="btn {{ $bgColor ?? 'bg-light' }} btn-sm border">Editar</a>  
    @elseif(isset($edit) && $edit !== false) 
        {!! $edit !!}
    @endif

    <button type="button" class="btn {{ $bgColor ?? 'bg-light' }} btn-sm border dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
    <div class="dropdown-menu dropdown-menu-right">
        {{-- Btn Show --}}
        @if (!isset($show) || $show === true)
            <a href="{{ route($routePrefix . '.show', ['id' => $record->id]) }}" title="Detalhes" class="dropdown-item popup-modal-link">Detalhes</a>
        @elseif(isset($show) && $show !== false) 
            {!! $show !!}
        @endif
        
        {{-- Btn View --}}
        @if (!isset($view) || $view === true)
            <a href="{{ config('app.url') . $record->present()->url }}" target="_blank" title="Visualizar no site" class="dropdown-item">Visualizar</a>
        @elseif(isset($view) && $view !== false) 
            {!! $view !!}
        @endif
        
        {{-- Btn Share Instagram --}}
        @can('instagramposts')
        @if (isset($shareInstagram) && optional(app('settingService')->get('facebook'))->has('ig_account'))
            {!! Form::open(['url' => '/support/facebook/share/instagram', 'method' => 'POST']) !!}
            {!! Form::hidden('caption', @$shareInstagram['caption'] . '
            
            Veja matéria completa, pelo link na bio!') !!}
            {!! Form::hidden('media_url', @$shareInstagram['media_url']) !!}
            {!! Form::hidden('title', @$shareInstagram['title']) !!}
            {!! Form::hidden('url', @$shareInstagram['url']) !!}
                <button class="dropdown-item" title="Compartilhar Instagram">Compartilhar Instagram</button>
            {!! Form::close() !!}
        @endif
        @endcan

        {{-- Btn Comments --}}
        @if (!isset($comments) || $comments === true)
            <a href="/admin/comments?ctype={{ class_basename($record) }}&cid={{ $record->id }}" title="Comentário" class="dropdown-item">Comentários</a>
        @elseif(isset($comments) && $comments !== false) 
            {!! $comments !!}
        @endif

        {{-- Btn Duplicate --}}
        @if (!isset($duplicate) || $duplicate === true)
            {!! Form::open(['url' => route($routePrefix . '.update', ['id' => $record->id]), 'method' => 'PUT']) !!}
            {!! Form::hidden('duplicate', 1) !!}
                <button class="dropdown-item" title="Duplicar">Duplicar</button>
            {!! Form::close() !!}
        @elseif(isset($duplicate) && $duplicate !== false) 
            {!! $duplicate !!}
        @endif        

        {{-- Btn Publish --}}
        @if (!isset($publish) || $publish === true)
            {!! Form::open(['url' => route($routePrefix . '.update', ['id' => $record->id]), 'method' => 'PUT']) !!}
            {!! Form::hidden('publish', $record->publish ? 0 : 1) !!}
                <button class="dropdown-item" title="{{ $record->present()->buttonPublishLabel }}">{{ $record->present()->buttonPublishLabel }}</button>
            {!! Form::close() !!}
        @elseif(isset($publish) && $publish !== false) 
            {!! $publish !!}
        @endif
        
        {{-- Btn Delete --}}
        @if (!isset($delete) || $delete === true)
            <button type="button" class="dropdown-item confirm-alert" data-confirm-body="Você tem certeza que deseja deletar o registro <strong>#{{ $record->id.'-'.$record->title }}</strong>?<br>Esta ação é irreversível!" data-confirm-btn-confirm-label="Deletar" data-confirm-btn-confirm-class="btn-danger" data-confirm-id="{{ $record->id }}" data-confirm-method="delete" title="Deletar">
                Deletar
            </button>
        @elseif(isset($delete) && $delete !== false) 
            {!! $delete !!}
        @endif        
    </div>
</div>