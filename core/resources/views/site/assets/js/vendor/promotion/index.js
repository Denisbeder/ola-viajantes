import alerter from '../alerter';

$(document).ready(function() {
    $("#promotions-form").on("submit", function(e) {
        e.preventDefault();
        const $this = $(this);
        const url = $this.attr("action");
        const inputs = $this.serialize();

        $.post(url, inputs, function(response) {
            console.log(response);
            if (response.success === true) {
                alerter("#promotion-alert", "success", response.text);
                // coloca o coomentario na lista OU nao                
            } else {
                alerter("#promotion-alert", "error", response.text);
            }
            scrollToTop();
        }).fail(function(event) {            
            if (event.status === 422) {
                const response = JSON.parse(event.responseText);
                const errors = response.errors;
                let html = '';
                $.each(errors, function (i,e) {
                    html += e[0] + '<br>';
                });
                alerter("#promotion-alert", "warning", html);
                scrollToTop();
            } else if (event.status === 419) {
                $.get('/support/getcsrftoken', function (res) {
                    $("#promotions-form").prepend($('<input>').attr('type', 'hidden').attr('name', '_token').attr('value', res));
                    //alerter("#promotion-alert", "warning", 'Tente novamente.');
                    $this.trigger('submit');
                });
            } else {
                console.log(event);
                bootbox.dialog({
                    message:
                        '<p class="text-center mb-0"><i class="fa fa-warning"></i> Infelizmente aconteceu um erro inesperado. <br> Tente novamente mais tarde. <br> Caso persista a falha contate o administrador do site.</p>',
                    closeButton: true,
                    onEscape: true,
                    backdrop: true,
                    centerVertical: true
                });
            }  
        });
    });

    function scrollToTop() {
        $("html, body")
            .delay(1300)
            .animate({ scrollTop: $("#promotions-form").offset().top - 150 }, 1000);
    }
});
