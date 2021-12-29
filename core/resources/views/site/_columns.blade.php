@php $currentPageSelect = app('getPageService', ['colunas', 10]); @endphp
@if(!is_null($currentPageSelect->getCollection()) && $currentPageSelect->getCollection()->isNotEmpty() && !request()->is('/'))
<section class="mb-5">
    <div class="mb-4">{{ $currentPageSelect->getPage()->title }}</div>
    <ul class="mb-3 list-group list-group-flush box-list">
        @foreach ($currentPageSelect->getCollection() as $item)
        <li class="px-0 pt-3 pb-3 list-group-item box-list-item d-flex align-items-center">
            {!! $item->page->present()->writerAvatar(['width' => '60', 'height' => '60', 'fit' => 'crop', 'class' => 'img-fluid rounded-pill p-0 flex-shrink-0 flex-grow-1 mr-3']) !!}
            <div class="flex-shrink-1 flex-grow-1 w-100">
                <p class="mb-0 text-muted">{{ $item->page->title }}</p>
                <h2 class="font-title">
                    <a href="{{ $item->present()->url }}">{{ $item->title }}</a>
                </h2>
            </div>
        </li>
        @endforeach
    </ul>
</section>
@endif