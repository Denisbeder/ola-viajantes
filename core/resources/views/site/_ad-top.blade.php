@if((bool) strlen($banner = app('bannerService', [1, true, false])->toJson()))
<div class="container mb-5 {{ $class ?? '' }}">
    <div class="ad" data-pos="1" data-ads="{{ $banner }}"></div>
</div>
@endif