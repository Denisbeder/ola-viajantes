//import * as $ from "jquery";
import bootbox from "bootbox";
import "bootbox/dist/bootbox.locales.min.js";
import { debounce } from "throttle-debounce";
import slug from "slug";

var input = $("#slug");
var inputBtnEdit = input.find("+button");
var slugFrom = $(input.data("slug-from"));
var slugPreview = $(input.data("slug-preview"));

// Libera ediçao manual após confirmação quando o usuário clica duas vezes
inputBtnEdit.on("click", function(e) {
    e.preventDefault();
    var $this = $(this);
    if (input.prop("readonly")) {
        bootbox.confirm({
            locale: "pt",
            centerVertical: true,
            title: "Atenção!",
            message:
                "Só edite esse campo se realmente for necessário.<br>Clique em OK para habilitar a edição ou CANCELAR para deixar como está.",
            buttons: {
                confirm: {
                    label: "Ok"
                },
                cancel: {
                    className: "bg-white border"
                }
            },
            callback: function(response) {
                if (response) {
                    input.attr("readonly", false).attr("disabled", false);

                    $this.attr("disabled", true);
                }
            }
        });
    }
});


if (input.length > 0) {
    slugPreview.html('/' + input.val());
} else {
    var inputEntry = null;
    const inputTitle = $("#title");
    const inputName = $("#name");
    if (inputTitle.length > 0) {
        inputEntry = $("#title");
    } else if(inputName.length > 0) {
        inputEntry = $("#title");
    }

    if (inputEntry !== null) {
        inputEntry.on(
            "keyup blur focus",
            debounce(250, function(e) {
                const $this = $(this);
                const slugPreview = $($this.data('slug-preview'));

                slugPreview.html('/' + sluggable($this.val()));
            })
        );
    }    
}

// Quando editar rota manualmente
input.on(
    "keyup blur focus",
    debounce(250, function(e) {
        if (e.type == "keyup") {
            $(this).addClass("dirty");
        }
        var result = sluggable($(this).val());

        $(this).val(result);

        slugPreview.html('/' + result);
    })
);

// Gera slug automaticamente a partir do input definido em data-slug-from
slugFrom.on(
    "keyup",
    debounce(250, function(e) {
        // Caso o campo "var input" foi editado manualmente não será gerado a slug a partir desse campo
        // ou se estiver desabilitado
        if (input.hasClass("dirty") || input.is(":disabled")) {
            return null;
        }

        var value = $(this).val();
        var result = sluggable(value);

        input.val(result);
        slugPreview.html(result);
    })
);

function sluggable(str) {
    if (str.length > 0) {
        return slugger(str);
    }
    return '';
}

function slugger(str) {
    return slug(String(str), { lower: true });
}
