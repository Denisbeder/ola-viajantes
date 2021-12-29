<div class="sticky-top">
    @if((bool) strlen($banner = app('bannerService', [2, true, false])->toJson()))
    <div class="mb-5 ad" data-pos="2" data-ads="{!! $banner !!}"></div>
    @endif

    @include('site._poll')

    @include('site._most-views')
</div>
