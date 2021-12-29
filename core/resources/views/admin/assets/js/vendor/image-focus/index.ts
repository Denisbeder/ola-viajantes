import { FocusedImage, FocusPicker, Focus } from "image-focus";
import * as $ from "jquery";

$(document).on("click", ".image-focus-edit", function(e) {
    setTimeout(function() {
        // Get our references to elements
        const focusPickerEl = document.getElementById("focus-picker-img") as HTMLImageElement;
        const coordinates = document.getElementById("coordinates") as HTMLInputElement;
        const focusedImageElements = document.querySelectorAll(".focused-image") as NodeListOf<HTMLImageElement>;

        const coordinatesDefault = !!coordinates.value.trim() && !coordinates.value.includes("NaN")
            ? JSON.parse(coordinates.value.replace(/(\s*?{\s*?|\s*?,\s*?)(['"])?([a-zA-Z0-9_]+)(['"])?:/g, '$1"$3":'))
            : { x: 0, y: 0 };

        // Set our starting focus
        const focus: Focus = coordinatesDefault;

        // Iterate over images and instantiate FocusedImage from each
        // pushing into an array for updates later
        const focusedImages: FocusedImage[] = [];
        Array.prototype.forEach.call(
            focusedImageElements,
            (imageEl: HTMLImageElement) => {
                focusedImages.push(
                    new FocusedImage(imageEl, {
                        focus,
                        debounceTime: 17,
                        updateOnWindowResize: true
                    })
                );
            }
        );

        // Instantiate our FocusPicker providing starting focus
        // and onChange callback
        new FocusPicker(focusPickerEl, {
            focus,
            onChange: (newFocus: Focus) => {
                const w = focusPickerEl.clientWidth;
                const h = focusPickerEl.clientHeight;    

                if (Number(newFocus.x) < 1 && Number(newFocus.y) < 1) {
                    const x = newFocus.x.toFixed(2);
                    const y = newFocus.y.toFixed(2);
                   
                    var offsetX = w * (-Number(x) / 2 + 0.5);
                    var resultX = ((w - offsetX) / w) * 100;
    
                    var offsetY = h * (Number(y) / 2 + 0.5);
                    var resultY = ((h - offsetY) / h) * 100;
                    
                    coordinates.value = `{x: ${Math.ceil(resultX)}, y: ${Math.ceil(resultY)}}`;
                } else {
                    coordinates.value = `{x: ${newFocus.x}, y: ${newFocus.y}}`;
                }                

                focusedImages.forEach(focusedImage =>
                    focusedImage.setFocus(newFocus)
                );
            }
        });
    }, 1000);
});
