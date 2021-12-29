$(document).ready(function() {
    const fieldCity = $('#city_id');
    $('#state_id').on('change', function (e) {
        $.get('/support/cities?state=' + e.target.value, function (response) {
            if (response.success) {
                fieldCity.empty();
                $.each(response.data, function (i, e) {
                    fieldCity.append($('<option>').attr('value', e.id).text(e.name));
                });
            }
        }).fail(function(event) {            
            console.log(event);
        });
    }); 
});