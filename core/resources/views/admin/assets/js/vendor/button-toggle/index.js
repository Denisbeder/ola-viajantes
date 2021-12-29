//import * as $ from "jquery";

$("[data-toggle='buttons']").each(function() {
    var $this = $(this);

    $this.find('input').map(function () {
        var $label = $(this).parent();
        $(this).is(':checked') ? $label.addClass('active') : $label.removeClass('active');
    });
});
