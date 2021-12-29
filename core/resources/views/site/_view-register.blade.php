@if(isset($viewRegister) && !empty(json_decode($viewRegister)))
<script>
    const VIEW_REGISTER = "{!! base64_encode(encrypt($viewRegister)) !!}"
</script>
@endif