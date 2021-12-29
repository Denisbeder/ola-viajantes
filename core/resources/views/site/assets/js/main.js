// Basic
//import 'bootstrap';
import 'bootstrap/js/dist/dropdown.js';
import 'bootstrap/js/dist/modal.js';
import 'bootstrap/js/dist/collapse';
import './vendor/configs';
import './vendor/lazy';
import './vendor/search'; 
import './vendor/banners'; 
import './vendor/poll';
import './vendor/carousels';

// Addons
import './vendor/mask';
import '../../../supports/assets/js/vendor/combo-box-city';

function scriptLoad(url) {
    var s = document.createElement('script');
    s.type = 'text/javascript';
    s.async = true;
    s.src = url;
    var x = document.getElementById('script-main');
    x.insertAdjacentElement('afterend', s);
}

// Home
if (document.location.pathname === '/') {
    scriptLoad("/assets/site/js/home.js");
}

// Internals
if (document.location.pathname !== '/') {
    scriptLoad("/assets/site/js/internals.js"); 
}

