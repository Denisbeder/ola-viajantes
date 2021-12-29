import "owl.carousel";

const navIcons = [
    '<i class="lni lni-arrow-left-circle"></i>',
    '<i class="lni lni-arrow-right-circle"></i>'
];

$("#medias-carousel").owlCarousel({
    margin: 15,
    dots: true,
    items: 1,
    loop: true,
    autoplay: false,
    autoplayTimeout: 4000,
    autoplayHoverPause: true,
    smartSpeed: 1000
});

$("#hightlights-carousel").owlCarousel({
    margin: 0,
    nav: false,
    dots: true,
    items: 1,
    loop: false,
    autoplay: false,
    //autoplayTimeout: 3000,
    autoplayHoverPause: true,
    lazyLoad: true
});

$(".advert-gallery-carousel").owlCarousel({
    margin: 15,
    nav: false,
    navText: navIcons,
    dots: true,
    items: 1,
    loop: true
    /* autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true */
});

$("#advert-carousel").owlCarousel({
    margin: 15,
    nav: false,
    navText: navIcons,
    dots: true,

    loop: false,
    lazyLoad: false,
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true,
    responsive: {
        0: {
            items: 2
        },
        768: {
            items: 5
        }
    }
});
