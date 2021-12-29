$(document).ready(function() {
    $("#navbar-toggler").on("click", function(e) {
        e.preventDefault();
        const header = $(".header");
        const navbarMenu = $(this).closest(".navbar-menu-wrapper");
        const navbarMenuCollapse = $(this).closest(".navbar-collapse");

        if (navbarMenu.hasClass("show")) {
            navbarMenu.removeClass("show");
            header.removeClass("show");
            navbarMenuCollapse.removeClass("show");
            $("body").removeClass("show");
        } else {
            navbarMenu.addClass("show");
            header.addClass("show");
            navbarMenuCollapse.addClass("show");
            $("body").addClass("show");
        }
    });

    $(document).mouseup(function(e) {
        if ($(e.target).parents(".navbar-menu-wrapper").length !== 1) {
            $(".navbar-menu-wrapper").removeClass("show");
            $(".header").removeClass("show");
            $(".navbar-collapse").removeClass("show");
            $("body").removeClass("show");
        }
    });
});
