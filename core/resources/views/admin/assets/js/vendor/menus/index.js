$(document.body).on('change', ".menu-type-select", function (e) {
    var $this = $(this);

    toggleMenuType($this);
});

function toggleMenuType(selectType) {
    var selectTypeRow = selectType.closest('.form-group:not(.form-row)');
    var staticOption = selectTypeRow.find(".static-option");
    var dinamicOption = selectTypeRow.find(".dinamic-option");

    if (dinamicOption.css("display") == "none") {
        dinamicOption.show().find('input, select, textarea').attr('disabled', false);
        staticOption.hide().find('input, select, textarea').attr('disabled', true);
    } else {
        dinamicOption.hide().find('input, select, textarea').attr('disabled', true);
        staticOption.show().find('input, select, textarea').attr('disabled', false);
    }
}