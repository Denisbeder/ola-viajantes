@if(!facebook_access_token())
<a href="{{ app('facebookSDKService')->loginUrl() }}" class="btn btn-primary">
    <i class="ti-facebook"></i> Facebook
</a>
@else
<a href="/support/facebook/settings" class="bg-white border btn ajax-popup-link">
    <i class="ti-facebook"></i> Configurar Facebook 
</a>
@endif

