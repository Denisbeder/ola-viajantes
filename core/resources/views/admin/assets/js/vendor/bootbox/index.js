import bootbox from "bootbox";
import "bootbox/dist/bootbox.locales.min.js";

const token = $('meta[name="csrf-token"]').attr("content");
const urlDefault = window.location.origin + window.location.pathname;
const confirmAlert = $(".confirm-alert, [confirm-alert]");

confirmAlert.each(function(i, e) {
    var elem = $(e);
    var id = elem.attr("data-confirm-id");
    var title = elem.attr("data-confirm-title");
    var body = elem.attr("data-confirm-body");
    var btnCancelLabel = elem.attr("data-confirm-btn-cancel-label");
    var btnCancelClass = elem.attr("data-confirm-btn-cancel-class");
    var btnConfirmLabel = elem.attr("data-confirm-btn-confirm-label");
    var btnConfirmClass = elem.attr("data-confirm-btn-confirm-class");
    var method = elem.attr("data-confirm-method");
    var extraParams = elem.attr("data-confirm-params");
    var redirectTo = elem.attr("data-confirm-redirect-to");
    var url = typeof elem.attr("data-confirm-url") !== 'undefined' ? elem.attr("data-confirm-url") : urlDefault;

    extraParams =
        typeof extraParams !== "undefined"
            ? JSON.parse(extraParams.replace(/'/g, '"'))
            : {};
    var params = { _method: method, _token: token, ...extraParams };

    elem.on("click", function(e) {
        e.preventDefault();
        bootbox.confirm({
            locale: "pt",
            centerVertical: true,
            title: title || "Atenção!",
            message: body || "Você tem certeza que deseja fazer isso?",
            buttons: {
                confirm: {
                    label: btnConfirmLabel || "Ok",
                    className: btnConfirmClass || "btn-primary"
                },
                cancel: {
                    label: btnCancelLabel || "Cancelar",
                    className: btnCancelClass || "bg-white border"
                }
            },
            callback: function(response) {
                if (response === true) {
                    $.post(url + "/" + id, params, function(response) {
                        if (typeof redirectTo !== "undefined") {
                            if (redirectTo !== "") {
                                window.location.href = redirectTo;
                                console.log('Redirecionando para ' + redirectTo);
                            }
                        } else {
                            location.reload();
                        }
                    }).fail(function(jqxhr, error, statusText) {
                        console.log(
                            "Ocorreu um erro inesperado com a requisição no servidor.",
                            jqxhr,
                            error,
                            statusText
                        );
                    });
                }
            }
        });
    });
});

if (typeof FORCE_PAGE_SELECTED !== "undefined" && FORCE_PAGE_SELECTED) {
    const inputOptions = [
        {
            text: "Selecione",
            value: ""
        }
    ];
    Object.keys(FORCE_PAGE_SELECTED_OPTIONS).map(function(id) {
        inputOptions.push({ text: FORCE_PAGE_SELECTED_OPTIONS[id], value: id });
    });

    if (!jQuery.isEmptyObject(FORCE_PAGE_SELECTED_OPTIONS)) {
        bootbox.prompt({
            title: "Selecione uma página para continuar",
            locale: "pt",
            centerVertical: true,
            closeButton: false,
            inputType: "select",
            onEscape: false,
            buttons: {
                cancel: {
                    className: "bg-white border"
                }
            },
            inputOptions,
            callback: function(result) {
                if (result === null) {
                    window.location.href = "/admin/pages";
                    return;
                }

                if (result !== "") {
                    var url = new URL(window.location.href);
                    if (result != "" && typeof result !== "undefined") {
                        url.searchParams.set("ps", result);
                    } else {
                        url.searchParams.delete("ps");
                    }
                    window.location.href = url.href;
                }
                return false;
            }
        });
    } else {
        bootbox.alert({
            title: "Selecione uma página para continuar",
            message:
                "Não existe nenhuma página sendo gerenciada por esse recurso. Você será redirecionado para Páginas.",
            locale: "pt",
            centerVertical: true,
            closeButton: false,
            inputType: "select",
            onEscape: false,
            callback: function() {
                window.location.href = "/admin/pages";
                return;
            }
        });
    }
}
