$(document).ready(function() {
    $("[data-goto]").on("click", function(e) {
        e.preventDefault();
        const target = $(this).data('goto');
        $("html, body").animate(
            { scrollTop: $(target).offset().top - 150 },
            1000
        );
    });
});
