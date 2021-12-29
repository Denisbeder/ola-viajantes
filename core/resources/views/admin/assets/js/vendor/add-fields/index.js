//import * as $ from "jquery";

$(".container-fields")
    .find("> .form-group:first-child")
    .css({ borderTop: "none", paddingTop: "0px" });

function adjustFields(containerFields, prefixUses, prefixKey) {
    containerFields
        .find("> .form-group:first-child")
        .css({ borderTop: "none", paddingTop: "0px" });

    containerFields.find("> .form-group").each(function(i, e) {
        var $this = $(e);
        i = Boolean(prefixUses) ? prefixKey : i;
        $this.find(".clone-fields").attr("data-prefix-key", i);
        $this.find("input, textarea, select").each(function(id, el) {
            var attrName = $(el)
                .attr("name")
                .replace(/\[[0-9]\]/, "[" + i + "]");

            $(el)
                .attr("name", attrName)
                .attr("id", attrName)
                .removeClass('disabled')
                .attr("disabled", false);

            $(el)
                .closest(".form-group")
                .find("label")
                .attr("for", attrName);
        });
    });

    containerFields.find(".clone-fields").find('input, textarea, select').each(function(id, el) {
        $(el).addClass('disabled').prop('disabled', true);
    });
}

$(document).on("click", ".add-fields", function(e) {
    var $this = $(this);
    var containerFields = $this.find("~ .container-fields");
    var cloneFields = $this.find("+.clone-fields");
    var cloneFieldsPrefixUses = cloneFields.attr("data-prefix-uses");
    var cloneFieldsPrefixKey = cloneFields.attr("data-prefix-key");
    var formGroup = cloneFields.find("> .form-group");

    formGroup
        .css({ borderTop: "dashed 1px #CCC", paddingTop: "1rem" })
        .clone()
        .appendTo(containerFields);

    adjustFields(containerFields, cloneFieldsPrefixUses, cloneFieldsPrefixKey);
});

$(document).on("click", ".remove-fields", function(e) {
    var $this = $(this);
    var containerFields = $this.closest(".container-fields");
    $this.closest(".form-group").remove();
    adjustFields(containerFields);
});
