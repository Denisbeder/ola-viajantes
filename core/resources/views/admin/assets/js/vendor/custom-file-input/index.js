//import * as $ from "jquery";

$(".inputfile").each(function() {
    var $input = $(this),
        $label = $input.next("label"),
        labelVal = $label.html(),
        inputfilePreview = $("#inputfile-preview");

    $input.on("change", function(e) {
        if ($input.hasClass("preview")) {
            var files = this.files;

            if (!files && !files[0]) {
                return null;
            }

            inputfilePreview.find(".inputfile-preview-item").remove();

            $.each(files, function(i, f) {
                var src = window.URL.createObjectURL(f);
                var fileItem = $("<div>").addClass("inputfile-preview-item");
                inputfilePreview.append(
                    fileItem.attr(
                        "style",
                        "background-image: url(" + src + ");"
                    )
                );
            });
            if (inputfilePreview.find(">*").length > 0) {
                $label.find(">span").text("Mudar");
                inputfilePreview.find('+img').hide();
            }
        } else {
            var fileName = "";

            if (this.files && this.files.length > 1) {
                fileName = (
                    this.getAttribute("data-multiple-caption") || ""
                ).replace("{count}", this.files.length);
            } else if (e.target.value) {
                fileName = e.target.value.split("\\").pop();
            }

            if (fileName) {
                $label.find("span").html(fileName);
            } else {
                $label.html(labelVal);
            }
        }
    });

    // Firefox bug fix
    $input
        .on("focus", function() {
            $input.addClass("has-focus");
        })
        .on("blur", function() {
            $input.removeClass("has-focus");
        });
});
