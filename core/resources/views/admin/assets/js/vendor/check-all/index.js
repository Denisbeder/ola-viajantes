var checkAll = $("#check-all");

if (checkAll.length > 0) {
    var targetId = checkAll.data("target");
    var targetElem = $(targetId);

    checkAll.on("change", function() {
        targetElem.prop("checked", this.checked);
    });

    targetElem.on("change", function() {
        if ($(targetId + ":checked").length == targetElem.length) {
            checkAll.prop("checked", true);
        } else {
            checkAll.prop("checked", false);
        }
    });
}
