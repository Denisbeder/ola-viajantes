const postionSelect = $('[name="position"]');
const sizeSelect = $('[name="size"]');
const deviceSelect = $('[name="device"]');

selectKeysFromDevice($('[name="device"]:checked'));
selectKeysFromPosition(postionSelect);

function selectKeysFromDevice(target) {
    postionSelect.children("option[data-size-keys]").each(function(i, e) {
        const sizeKeys = JSON.parse($(e).attr("data-size-keys-original"));

        if (target.val() === "mobile") {
            const newSizeKeys = sizeKeys.filter(function(v) {
                return v === 20 || v === 3;
            });

            $(e).attr("data-size-keys", JSON.stringify(...[newSizeKeys]));
        }

        if (target.val() === "desktop" || target.val() === "mobile_desktop") {
            const newSizeKeys = sizeKeys.filter(function(v) {
                return v !== 20;
            });

            $(e).attr("data-size-keys", JSON.stringify(...[newSizeKeys]));
        }
    });
    postionSelect.trigger('change');
}

function selectKeysFromPosition(target) {
    const sizeKeysAttr = target
    .children("option:selected")
    .attr("data-size-keys");

    if (typeof sizeKeysAttr !== typeof undefined && sizeKeysAttr !== false) {
        const sizeKeys = JSON.parse(sizeKeysAttr);

        sizeSelect.children("option").map(function(i, e) {
            var elem = $(e);
            var elemValue = Number(elem.val());

            if (sizeKeys.includes(elemValue)) {
                elem.attr("disabled", false).css("color", "unset");
            } else {
                elem.attr("disabled", true).css("color", "#F1F1F1");
            }
        });
    }
}

deviceSelect.on("change", function(e) {
    selectKeysFromDevice($(e.target));
});

postionSelect.on("change", function(e) {
    selectKeysFromPosition($(e.target));
});
