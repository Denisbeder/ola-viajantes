import isMobile from "../isMobile";

$(document).ready(function() {
    $('.search button[type="submit"]').on("click", function(e) {
        e.preventDefault();
        const wrapper = $(this).parents(".search");
        const input = wrapper.find("input");
        const header = $(".header");
        const widthInputMobile = header.find('[class*="container"]').width();

        if (wrapper.hasClass("show")) {
            console.log("envinado")
            wrapper.submit();
        } else {
            wrapper.addClass("show");
            input.focus();

            if (isMobile()) {
                input.css("width", widthInputMobile);
            } else {
                input.removeAttr("style");
            }
        }
    });

    $('.search button[type="button"]').on("click", function(e) {
        e.preventDefault();
        $(this)
            .parents(".search")
            .removeClass("show");
    });

    $(document).mouseup(function(e) {
        if ($(e.target).parents(".search").length !== 1) {
            $(".search").removeClass("show");
            $(".search").find("input").removeAttr("style");
        }
    });
});
