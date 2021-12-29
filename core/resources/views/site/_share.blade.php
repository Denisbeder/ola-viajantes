@php
$urlShare = config('app.url') . $data->present()->url;
$titleShare = $data->title;
@endphp

<div class="shadow-none list-group show-share show-share-colored-bg">
    <a href="https://api.whatsapp.com/send?text=*{{ $titleShare }}* Confira: {{ $urlShare }}" target="_blank" class="px-0 text-center list-group-item list-group-item-action show-share-item whatsapp">
        <i class="lni lni-whatsapp"></i>
    </a>
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $urlShare }}" class="px-0 text-center list-group-item list-group-item-action show-share-item facebook">
        <i class="lni lni-facebook-oval"></i>
    </a>
    <a href="https://twitter.com/intent/tweet?source={{ $urlShare }}&text={{ $titleShare . ' ' . $urlShare }}" class="px-0 text-center list-group-item list-group-item-action show-share-item twitter">
        <i class="lni lni-twitter-original"></i>
    </a>
    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $urlShare }}" class="px-0 text-center list-group-item list-group-item-action show-share-item linkedin">
        <i class="lni lni-linkedin-original"></i>
    </a>
    @if(isset($showSpeech) && $showSpeech)
    <button id="speechStart" title="Ouvir texto" data-action="play" class="px-0 text-center list-group-item list-group-item-action show-share-item bg-light" style="border-top: 1px solid #e9ecef !important; width: 100%;">
        <i id="speechPlay" class="lni lni-volume-medium"></i>
        <i id="speechStop" class="lni lni-stop" style="display: none;"></i>
    </button>
    <textarea readonly id="speechText" style="display: none; pointer-events: none;">{{ $data->present()->speech }}</textarea>
    @endif
</div>