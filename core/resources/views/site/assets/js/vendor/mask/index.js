import "jquery-mask-plugin";

const maskPhoneBr = function(val) {
    return val.replace(/\D/g, "").length === 11
        ? "(00) 00000-0000"
        : "(00) 0000-00009";
};
const maskPhoneBrOptions = {
    onKeyPress: function(val, e, field, options) {
        field.mask(maskPhoneBr.apply({}, arguments), options);
    }
};

$(".phone").mask(maskPhoneBr, maskPhoneBrOptions);

$('.money').mask('000.000.000.000.000,00', {reverse: true});