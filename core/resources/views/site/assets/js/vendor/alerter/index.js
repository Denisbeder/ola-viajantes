export default function alerts(target, type, text) {
    const tgt = target.length > 0 ? target : ".alert";
    if (type === "success") {
        $(tgt)
            .removeClass("alert-danger")
            .removeClass("alert-info")
            .removeClass("alert-warning")
            .addClass("alert-success")
            .html(text)
            .fadeIn()
            .delay(5000)
            .fadeOut();
    } else if (type === "error") {
        $(tgt)
            .removeClass("alert-success")
            .removeClass("alert-info")
            .removeClass("alert-warning")
            .addClass("alert-danger")
            .html(text)
            .fadeIn()
            .delay(5000)
            .fadeOut();
    } else if (type === "warning") {
        $(tgt)
            .removeClass("alert-success")
            .removeClass("alert-info")
            .removeClass("alert-dange")
            .addClass("alert-warning")
            .html(text)
            .fadeIn()
            .delay(5000)
            .fadeOut();
    } else {
        $(tgt)
            .removeClass("alert-success")
            .removeClass("alert-danger")
            .removeClass("alert-warning")
            .addClass("alert-info")
            .html(text)
            .fadeIn()
            .delay(5000)
            .fadeOut();
    }
}
