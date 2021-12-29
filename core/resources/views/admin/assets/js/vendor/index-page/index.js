import bootbox from "bootbox";
import "bootbox/dist/bootbox.locales.min.js";

const touched = $("[data-touched]").data("touched");

if (touched !== null) {
    var ids = String(touched).split(",");
    $.each(ids, function(i, id) {
        var $this = $("#tr_" + id);

        $this
            .find("td")
            .css({
                background: "#ffffd899",
                opacity: 0.0
            })
            .animate(
                {
                    opacity: 1
                },
                500
            )
            .delay(800)
            .animate(
                {
                    opacity: 0.7
                },
                500,
                function() {
                    $(this).css({
                        background: "transparent"
                    });
                }
            )
            .animate(
                {
                    opacity: 1
                },
                200
            );
    });
}

const massAction = $('[name="mass-action"]');
const massActionTargetId = massAction.data("target");
const massActionTargetElem = $(massActionTargetId);
const token = $('meta[name="csrf-token"]').attr("content");
var selecteds = [];

$('#check-all, ' + massActionTargetId).change(function (e) {
    massActionTargetElem.each(function(i, e) {
        const elem = $(e);
        const index = selecteds.indexOf(elem.val());

        if (elem.is(":checked") && index === -1) {
            selecteds.push(elem.val());
        } else if (!elem.is(":checked") && index !== -1) {
            selecteds.splice(index, 1);
        }
    });

    if (selecteds.length > 1) {
        massAction.show();
    } else {
        massAction.hide();
    }
})

massAction.on("change", function(e) {
    e.preventDefault();
    var value = e.target.value;    
    var params = {};

    if (value == 0) {
        return false;
    }    

    if (selecteds.length <= 0) {
        bootbox.dialog({
            message: '<p class="mb-1">Selecione algum item.</p>',
            centerVertical: true
        });
        return false;
    }

    switch (value) {
        case "delete":
            bootbox.confirm({
                locale: "pt",
                centerVertical: true,
                title: "Atenção!",
                message: "Você tem certeza que deseja fazer isso?",
                buttons: {
                    confirm: {
                        label: "Deletar",
                        className: "btn-danger"
                    },
                    cancel: {
                        className: "bg-white border"
                    }
                },
                callback: function(response) {
                    if (response) {
                        params = { _method: "DELETE", _token: token };
                        return sendRequest(params);
                    }
                }
            });
            return;
            break;

        case "publish":
            params = { _method: "PUT", _token: token, publish: 1 };
            break;

        case "unpublish":
            params = { _method: "PUT", _token: token, publish: 0 };
            break;

        case "duplicate":
            params = { _method: "PUT", _token: token, duplicate: 1 };
            break;
    }

    return sendRequest(params);
});

function sendRequest(params) {
    const url = window.location.origin + window.location.pathname;
    
    $('#loader').removeClass('fadeOut');

    $.post(url + "/" + selecteds.join(","), params, function(response) {
        location.reload();
    }).fail(function(jqxhr, error, statusText) {
        console.log('Ocorreu um erro inesperado com a requisição no servidor.', jqxhr, error, statusText);
    });
}
