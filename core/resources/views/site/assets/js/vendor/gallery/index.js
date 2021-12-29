import "lightgallery";
//import "lg-thumbnail";

$(document).ready(function() {
    const gallery = $("#gallery");
    const galleryConfig = {
        selector: '.gallery-item',
    };
    
    gallery.lightGallery(galleryConfig);

    $("#gallery img").each(function() {
        const $this = $(this);
        const src = $this.attr("src");
        const alt = $this.attr("alt");
        const a = $("<a>")
            .attr("href", src)
            .attr("title", alt)
            .addClass("gallery-item");
        const hasLink = $this.closest("a");

        if (hasLink.length == 0) {
            $this.wrap(a);
            gallery.data("lightGallery").destroy(true);
            gallery.lightGallery(galleryConfig);
        }        
    });
});
