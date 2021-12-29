import bootbox from "bootbox";
import alerter from "../alerter";

$(document).ready(function() {
    $("#adverts-form").on("submit", function(e) {
        e.preventDefault();
        var $this = $(this);
        var formData = new FormData(this);
        loadingForm($this, true);

        $.ajax({
            url: "/support/adverts",
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                if (Boolean(data.success) === true) {
                    alerter("#advert-alert", "success", data.text);
                    loadingForm($this, false);
                    if($this.data('method') !== "put") {
                        $this.trigger('reset');
                    }
                    return true;
                }
                loadingForm($this, false);
                alerter(
                    "#advert-alert",
                    "error",
                    "Algo deu errado. Tente mais tarde."
                );
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 422) {
                    const response = jqXHR.responseJSON;
                    const errors = response.errors;
                    let html = "";
                    $.each(errors, function(i, e) {
                        html += e[0] + "<br>";
                    });
                    alerter("#advert-alert", "warning", html);
                } else if (jqXHR.status === 419) {
                    $.get('/support/getcsrftoken', function (res) {
                        $("#adverts-form").prepend($('<input>').attr('type', 'hidden').attr('name', '_token').attr('value', res));
                        //alerter("#advert-alert", "warning", 'Tente novamente.');
                        $this.trigger('submit');
                    });
                } else {
                    console.log(jqXHR);
                    bootbox.dialog({
                        message:
                            '<p class="text-center mb-0"><i class="fa fa-warning"></i> Infelizmente aconteceu um erro inesperado. <br> Tente novamente mais tarde. <br> Caso persista a falha contate o administrador do site.</p>',
                        closeButton: true,
                        onEscape: true,
                        backdrop: true,
                        centerVertical: true
                    });
                } 
                loadingForm($this, false);
            }
        });
    });
});

function loadingForm(form, disabled) {
    form.find("input").attr("disabled", disabled);
    form.find("button").attr("disabled", disabled);
    if (disabled) {
        form.find(".form-group > *").css("opacity", ".5");
    } else {
        form.find(".form-group > *").css("opacity", "1");
    }
}
