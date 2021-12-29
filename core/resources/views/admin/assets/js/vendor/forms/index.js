import bootbox from "bootbox";

$(document).on("change", ".forms-type", function(e) {
    const $this = $(e.target);
    const containerOptions = $this
        .closest(".form-group")
        .find(".forms-type-options");
    if ($this.val() === "select") {
        containerOptions.show();
        containerOptions.find("input").attr("disabled", false);
    } else {
        containerOptions.hide();
        containerOptions.find("input").attr("disabled", true);
    }
});

$(document).on("submit", "#social-form-popup", function(e) {
    e.preventDefault();
    const $this = $(this);
    const url = $this.attr("action");
    const datas = $this.serialize();

    $.post(url, datas, function(response) {
        console.log(response);
        if (!response.error) {
            $this.find("#status").prepend(
                $("<div>")
                    .addClass("alert alert-success")
                    .html(response.msg)
                    .delay(5000)
                    .fadeOut()
            );
        } else {
            $this.find("#status").prepend(
                $("<div>")
                    .addClass("alert alert-danger")
                    .html(response.msg)
                    .delay(5000)
                    .fadeOut()
            );
        }
    }).fail(function(event) {
        console.log(event);
        bootbox.dialog({
            message:
                '<p class="text-center mb-0"><i class="fa fa-warning"></i> Infelizmente aconteceu um erro inesperado. <br> Tente novamente mais tarde. <br> Caso persista a falha contate o administrador do site.</p>',
            closeButton: true,
            onEscape: true,
            backdrop: true,
            centerVertical: true
        });
    });
});
