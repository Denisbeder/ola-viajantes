//import * as $ from 'jquery';

import "flatpickr/dist/flatpickr.css";
import "flatpickr/dist/flatpickr.min.js";
import "flatpickr/dist/l10n/pt.js";

$(".datetime").flatpickr({
    time_24hr: true,
    enableTime: true,
    enableSeconds: false,
    dateFormat: "Y-m-d H:i:ss",
    altFormat: "d/m/Y H:i",
    altInput: true,
    locale: "pt",
    onChange: function(selectedDates, dateStr, instance) {
        if (dateStr === "") {
            instance.close();
        }
    }
});
