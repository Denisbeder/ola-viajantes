import FingerprintJS from "@fingerprintjs/fingerprintjs";
import bootbox from "bootbox";
import alerter from "../alerter";

// Initialize an agent at application startup.
FingerprintJS.load().then(res => {
    res.get().then(r => {
        const visitorId = r.visitorId;
        const inputVisitorId = $("<input>")
            .attr("name", "visitor_id")
            .attr("type", "hidden")
            .attr("readonly", "readonly")
            .val(visitorId);
        $("#poll-form").append(inputVisitorId);
    });
});

$(document).ready(function() {
    $("#poll-form").submit(function(e) {
        e.preventDefault();
        const $this = $(this);
        const url = $this.attr("action");
        const input = $this.serialize();

        if (input == "") {
            return alerter("#poll-alert", "warning", "Selecione uma opção.");
        }

        $.post(url, input, function(response) {
            if (response.success === true) {
                alerter("#poll-alert", "success", response.text);
                console.log(response.data);
                response.data.options.map(function(e, i) {
                    $this
                        .find("#poll-result")
                        .find("#poll-option-key-" + e.id)
                        .find(".poll-option-percent")
                        .find("span")
                        .html(e.percent + "%");                        

                    $this
                        .find("#poll-result")
                        .find("#poll-option-key-" + e.id)
                        .attr("data-percent", e.percent);

                    $this
                        .find("#poll-result")
                        .find("#poll-option-key-" + e.id)
                        .find(".poll-option-total-votes")
                        .find("span")
                        .html(e.votes_count);
                });

                $this
                    .find("#poll-result")
                    .find("#poll-total-votes span")
                    .html(response.data.votes_total);
            } else {
                alerter("#poll-alert", "error", response.text);
            }
            setTimeout(() => {
                toggleScreens();
            }, 500);
        }).fail(function(event) {
            if (event.status === 419) {
                $.get("/support/getcsrftoken", function(res) {
                    $("#poll-form").prepend(
                        $("<input>")
                            .attr("type", "hidden")
                            .attr("name", "_token")
                            .attr("value", res)
                    );
                    //alerter("#poll-alert", "warning", 'Tente novamente.');
                    $this.trigger("submit");
                });
            } else {
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
        });

        //scrollToTop();
    });

    $(".poll-btn-toggle").on("click", function(e) {
        e.preventDefault();
        toggleScreens();
        //scrollToTop();
    });

    /* function scrollToTop() {
        $("html, body")
            .delay(1300)
            .animate({ scrollTop: $("#poll-form").offset().top - 180 }, 1000);
    } */

    function toggleScreens() {
        if (
            $("#poll-form")
                .find("#poll-options")
                .is(":visible")
        ) {
            orderResults();
            $("#poll-options").fadeOut(300, function() {
                $("#poll-result").fadeIn();
            });
        }

        if (
            $("#poll-form")
                .find("#poll-result")
                .is(":visible")
        ) {
            $("#poll-result").fadeOut(300, function() {
                $("#poll-options").fadeIn();
            });
        }
    }

    function getSorted(selector, attrName) {
        return $(
            $(selector)
                .toArray()
                .sort(function(a, b) {
                    var aVal = parseInt(a.getAttribute(attrName)),
                        bVal = parseInt(b.getAttribute(attrName));
                    return bVal - aVal;
                })
        );
    }

    function orderResults() {
        let container = $("#poll-form")
            .find("#poll-result-items");

        let selector = container.find(".poll-result-item"); 

        let result = getSorted(selector, "data-percent");

        container.empty().append(result);
    }
});
