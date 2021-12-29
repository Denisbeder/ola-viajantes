let speech = new SpeechSynthesisUtterance();
speech.lang = "pt-br";
speech.volume = 1;
speech.rate = 1.5;
speech.pitch = 1;
speech.text = $("#speechText").val();

// Ao carregar a página sempre cancela o que tiver por segurança
window.speechSynthesis.cancel();

let voices = [];
window.speechSynthesis.onvoiceschanged = function () {
    voices = window.speechSynthesis
        .getVoices()
        .filter(voice => voice.lang === "pt-BR");

    speech.voice = voices[0];
};

/* speech.onstart = function (e) {
    console.log("START");
}; */

speech.onend = function (e) {
    $(this).attr("data-action", "play");
    $("#speechPlay").show();
    $("#speechStop").hide();
};

speech.onerror = function (e) {
    console.log("Error SpeechSynthesisUtterance.");
};

$("#speechStart").click(function () {
    if ($(this).attr("data-action") === "play") {        
        window.speechSynthesis.speak(speech);
        $(this).attr("data-action", "stop");
        $("#speechPlay").hide();
        $("#speechStop").show();
    } else {
        window.speechSynthesis.cancel();
        $(this).attr("data-action", "play");
        $("#speechPlay").show();
        $("#speechStop").hide();
    }
});