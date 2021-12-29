import autocomplete from "autocompleter";
import bootbox from "bootbox";

const inputRelated = document.getElementById("autocompleter");

if (inputRelated !== null) {
    const containerRelated = $("#container-related");

    $(document).on("click", ".related-remove", (e) => {
        $(e.target).closest('.form-row').remove();

        if (containerRelated.find('.form-row').length == 0) {
            $('#empty-related').show();
        }
    });


    autocomplete({
        input: inputRelated,
        debounceWaitMs: 300,
        fetch: function(text, update) {
            text = text.toLowerCase();

            $.get("/support/related/", {query: text}, function(response) {
                const datas = response.data;

                const suggestions = datas.map((item) => {
                    return {
                        value: item.id,
                        label: item.title,
                        url: item.url,
                        id: item.id,
                    };
                });

                update(suggestions);
            }).fail(
                function(event) {
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
            );

            
        },
        onSelect: function(item) {
            inputRelated.value = "";

            $('#empty-related').hide();
            const countRelatedRow = containerRelated.find('.form-row');
            const formGroup = $('<div>').addClass('form-row border-top border-white pt-3 mb-3 mx-n3 px-3').attr('style', 'border-width: 8px !important');
            const containerColLeft = $('<div>').addClass('col-auto flex-fill');
            const containerColRight = $('<div>').addClass('col-auto');
            const containerRelatedInputTitle = $(`<input name="related[${countRelatedRow.length}][title]" type="text">`).addClass('form-control mb-1').val(item.label);
            const containerRelatedInputUrl = $(`<input name="related[${countRelatedRow.length}][url]" type="text">`).addClass('form-control form-control-sm bg-light').val(item.url);
            const containerRelatedBtnRemove = $('<button>').addClass('btn btn-danger btn-sm mt-1 related-remove').attr('title', 'Remover').html('<i class="ti-trash"></i>');

            const colLeft = containerColLeft.append(containerRelatedInputTitle).append(containerRelatedInputUrl);
            const colRight = containerColRight.append(containerRelatedBtnRemove);
            
            const html = formGroup.append(colLeft).append(colRight);
            containerRelated.append(html);
       
        }
    });
}
