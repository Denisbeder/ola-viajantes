@php
$closeButton = '<button type="button" class="close text-white" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>';
@endphp
<div class="alert-messages">
    @if (Session::has('errors'))
    <div class="alert alert-danger bg-danger text-white" role="alert">
        {!! $closeButton !!}
        <ul class="list-unstyled">
            @foreach (Session::get('errors')->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (Session::has('warning'))
    <div class="alert alert-warning bg-warning text-black-50" role="alert">
        <button type="button" class="close text-black-50" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        {{Session::get('warning')}}
    </div>
    @endif

    @if (Session::has('info'))
    <div class="alert alert-info bg-info text-white" role="alert">
        {!! $closeButton !!}
        {{Session::get('info')}}
    </div>
    @endif

    @if (Session::has('success'))
    <div class="alert alert-success bg-success text-white" role="alert">
        {!! $closeButton !!}
        {{Session::get('success')}}
    </div>
    @endif
</div>