@extends('admin.__admin')

@php
$action = request()->route()->getActionMethod();
$pageName = 'Posts';
$pageSelected = $page->title ?? '';
$pageSubName = $action === 'edit' ? 'Editar' : 'Criar';
@endphp

@section('page_title')
{{ $pageSelected }} {!! !$pageSelected ? null : '&ndash;' !!} {{ $pageName }} {{ $pageSubName }} | {{ config('app.admin.name') }}
@endsection

@empty(!$page)
@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        @if($action === 'edit')
            {!! Form::model($record, [
                'route' => ['posts.update', $record->id],
                'method' => 'put',
                'files' => true,
            ])
            !!}
        @else
            {!! Form::open([
                'route' => 'posts.store',
                'files' => true,
            ])
        !!}
        @endif

        @include('admin.posts._form')

        {!! Form::close() !!}
    </div>
</div>

@if(session()->has('preview'))
<script>
    window.open('/preview/post/{{ $record->id }}', '_blank')</script>
</script>
@endif

@endsection
@endempty