
<div class="sticky-top">
    @if((bool) strlen($banner = app('bannerService', [2, true, false])->toJson()))
    <div class="mb-5 ad" data-pos="2" data-ads="{!! $banner !!}"></div>
    @endif

    @php
        $othersPosts = $page->posts
                            ->sortByDesc('published_at')                        
                            ->filter(function ($item) {
                                return $item->published_at <= now() && ($item->unpublished_at >= now() || $item->unpublished_at === null);
                            });
        if (isset($data)) {
            $othersPosts = $othersPosts->where('id', '<>', $data->id)->take(5);
        } else {
            $othersPosts = $othersPosts->take(5);
        }
    @endphp
    @if($othersPosts->isNotEmpty())
    <div class="mt-5 card">
        <div class="card-header">
            <strong>Veja também</strong>
        </div>
        <div class="py-2 card-body">
            <ul class="list-group list-group-flush">
                @foreach ($othersPosts as $item)
                <li class="px-0 list-group-item">
                    <article class="card card-post horizontal">
                        @if(!is_null($avatar = $item->page->present()->writerAvatar(['width' => '80', 'height' => '80', 'fit' => 'crop', 'class' => 'rounded-pill card-img-gray'])))
                        <a href="{{ $item->present()->url }}" title="{{ $item->title }}" class="flex-grow-0 d-flex align-items-center card-img flex-shrink-1" style="max-width: 80px; min-width: 80px;">
                            {!! $avatar !!}
                        </a>
                        @endif
                        <div class="card-body flex-grow-1 justify-content-center d-flex flex-column">
                            <a href="{{ $item->page->present()->url }}" title="{{ $item->page->title }}" class="d-block" style="font-size: 14px; line-height: 1">{{ $item->page->title }}</a>
                            <h3 class="mt-1 card-title title-14">
                                <a href="{{ $item->present()->url }}" title="{{ $item->title }}">
                                    {{ $item->title_short ?? $item->title }}
                                </a>
                            </h3>
                        </div>
                    </article>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="card-footer">
            <a href="{{ $page->present()->url }}"><small class="font-weight-bold">VER TODOS <i class="ml-1 lni lni-arrow-right"></i></small></a>
        </div>
    </div>  
    @endif
</div>