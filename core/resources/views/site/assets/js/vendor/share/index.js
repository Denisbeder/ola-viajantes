$(document).ready(function() {
    $(".show-share a").click(function(e) {
        var target = $(this).attr("target");
        if (target != "_blank") {
            e.preventDefault();
            var url = $(this).attr("href");
            var w = 600;
            var h = 400;
            var l = (screen.width - w) / 2;
            var t = (screen.height - h) / 2;
            window.open(
                url,
                "_blank",
                "height=" +
                    h +
                    ",width=" +
                    w +
                    ",status=no,toolbar=no,menubar=no,location=no,left=" +
                    l +
                    ",top=" +
                    t +
                    ""
            );
        }
    });
});
