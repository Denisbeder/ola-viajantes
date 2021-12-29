import "magnific-popup/dist/jquery.magnific-popup.js";
import "magnific-popup/dist/magnific-popup.css";

$(document).ready(function() {
	$('.popup-video, .popup-gmaps').magnificPopup({
		type: 'iframe',
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: true,
		fixedContentPos: true
	});
});