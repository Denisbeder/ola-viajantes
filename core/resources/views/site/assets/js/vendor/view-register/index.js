function viewRegister(token) {
    if (typeof VIEW_REGISTER !== "undefined") {
        let tokenCSRF = typeof token === "undefined" ? $('meta[name="csrf-token"]').attr("content") : token;

        $.post("/support/view-register", {_token: tokenCSRF, data: VIEW_REGISTER}).fail(function(event) {
            if (event.status === 419) {
                $.get("/support/getcsrftoken", function(res) {
                    viewRegister(res);
                });
            }
        });
    }
}

viewRegister();
