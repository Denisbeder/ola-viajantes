//import * as $ from "jquery";
import bootbox from "bootbox";
import "bootbox/dist/bootbox.locales.min.js";
import "jquery-ui/themes/base/core.css";
import "jquery-ui/themes/base/theme.css";
import "jquery-ui/themes/base/sortable.css";
import "jquery-ui/ui/core";
import "jquery-ui/ui/widgets/sortable";

export default (function() {
    $(".medias-sortable").sortable({
        placeholder: "ui-state-highlight",
        tolerance: "pointer",
        cursor: "move",
        delay: 150,
        distance: 0,
        items: ".medias-item",
        update: function(event, ui) {
            const $this = $(this);
            const datas = $(event.target).sortable("toArray", {
                attribute: "data-index"
            });
            const url = "/admin/medias/" + datas.join(",");

            $.ajax({
                url: url,
                type: "PUT",
                cache: false,
                data: { sortable: true },
                success: function(response) {
                    const id = response.shift();
                    const mediasItems = $this.find(".medias-item");
                    const mediaItemFirst = $this.find('[data-index="' + id + '"]').find("a:not(.medias-item-caption)");
                    const elemCoverText = $("<div>")
                        .addClass("medias-item-cover")
                        .html("CAPA");

                    mediasItems.find(".medias-item-cover").remove();
                    mediaItemFirst.prepend(elemCoverText);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    });

    $("body").on("click", ".medias-item-trash", function(e) {
        e.preventDefault();
        const $this = $(this);
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
                    label: "Cancelar",
                    className: "bg-white border"
                }
            },
            callback: function(response) {
                if (response === true) {
                    const itemTrash = $this.parent();
                    const indexRemove = itemTrash.data("index");
                    console.log(indexRemove);

                    $.ajax({
                        url: "/admin/medias/" + indexRemove,
                        type: "DELETE",
                        cache: false,
                        success: function(response) {
                            itemTrash.remove();
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            }
        });
    });

    $("body").on("submit", "#medias-form", function(e) {
        e.preventDefault();

        const $this = $(this);
        const data = $this.serialize();
        const url = $this.attr("action");

        $.ajax({
            url: url,
            type: "PUT",
            cache: false,
            data: data,
            success: function(response) {
                console.log(response);
                $.each(response, function(i, item) {
                    var img = $("#inputfile-preview").find(
                        '[data-index="' + item.id + '"]'
                    );
                    img.attr("data-caption", item.custom_properties.caption);
                    img.find(">a").attr("title", item.custom_properties.caption);
                });

                var msg = "Dados salvos com sucesso.";
                $("#medias-alert")
                    .removeClass("bg-danger")
                    .addClass("bg-success")
                    .html(msg)
                    .show()
                    .delay(3000)
                    .fadeOut();
            },
            error: function(error) {
                console.log(error);
                $("#medias-alert")
                    .removeClass("bg-success")
                    .addClass("bg-danger")
                    .html("Não foi possível salvar a legenda.")
                    .show()
                    .delay(3000)
                    .fadeOut();
            }
        });
    });
})();
