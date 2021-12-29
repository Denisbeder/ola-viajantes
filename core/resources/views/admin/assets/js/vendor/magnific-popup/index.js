//import * as $ from "jquery";
import "magnific-popup/dist/jquery.magnific-popup.js";
import "magnific-popup/dist/magnific-popup.css";

$(".ajax-popup-link").magnificPopup({
    type: "ajax",
    alignTop: false,
    overflowY: "scroll",
    closeBtnInside: false,
    showCloseBtn: false,
    ajax: {
        tError: '<a href="%url%">Esse conteúdo</a> não pôde ser carregado.'
    }
});

$(".popup-gallery").magnificPopup({
    type: "image",
    tLoading: "Carregando imagem #%curr%...",
    mainClass: "mfp-img-mobile",
    gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
    },
});

// Filter
$("#filter-btn").magnificPopup({
    type: "inline",
    preloader: false,
    focus: "#name"
});

$(".popup-modal").magnificPopup({
    type: "inline",
    preloader: false,
    modal: true
});

$(".popup-modal-link").magnificPopup({
    type: "ajax",
    alignTop: false,
    overflowY: "scroll",
    showCloseBtn: false,
});

$(document).on("click", ".popup-modal-dismiss", function(e) {
    e.preventDefault();
    $.magnificPopup.close();
});

$.extend(true, $.magnificPopup.defaults, {
    tClose: "Fechar", // Alt text on close button
    tLoading: "Carregando...", // Text that is displayed during loading. Can contain %curr% and %total% keys
    gallery: {
        tPrev: "Anterior", // Alt text on left arrow
        tNext: "Próximo", // Alt text on right arrow
        tCounter: "%curr% de %total%" // Markup for "1 of 7" counter
    },
    image: {
        tError: '<a href="%url%">A imagem</a> não pôde ser carregada.' // Error message when image could not be loaded
    },
    ajax: {
        tError: '<a href="%url%">Esse conteúdo</a> não pôde ser carregado.' // Error message when ajax request failed
    }
});