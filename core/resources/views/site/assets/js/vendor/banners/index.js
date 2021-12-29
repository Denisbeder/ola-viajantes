import isMobile from "../isMobile";

function showAd($this, datasJson, queueName) {
    let current = datasJson.shift();
    datasJson.push(current);
    $this.html(current.content);

    updateAdQueue(queueName);

    if (datasJson.length > 1) {
        setInterval(function() {
            current = datasJson.shift();
            datasJson.push(current);
            $this.html(current.content);

            updateAdQueue(queueName);
        }, 20000);
    }
}

function updateAdQueue(queueName) {
    const storeDatas = JSON.parse(localStorage.getItem(queueName));
    const first = storeDatas.shift();
    storeDatas.push(first);

    localStorage.removeItem(queueName);
    localStorage.setItem(queueName, JSON.stringify(storeDatas));
}

function resetAdsWhenTimeout() {
    const adsTimeout = new Date(localStorage.getItem("_ads__timeout_")).getTime() / 1000;
    const adsTimeoutNow = new Date().getTime() / 1000;
    const adsTimeoutDiff = adsTimeoutNow - adsTimeout;

    if (adsTimeoutDiff > 60) { // Maior que 1 minuto reseta o cache no local storage
        localStorage.removeItem("_ads__timeout_");
        Object.keys(localStorage).map((key) => {
            if (key.includes("_ads")) {
                localStorage.removeItem(key);
            }
        });
    }
}

function setAdTimeout() {
    localStorage.setItem("_ads__timeout_", new Date());
}

$(document).ready(function() {
    resetAdsWhenTimeout();

    $("[data-ads]").each(function(i) {
        const $this = $(this);
        const position = $this.attr("data-pos");
        const datas = atob($this.attr("data-ads"));
        const queueNameMobile = `_ads__mobile__${position}_`;
        const queueNameDesktop = `_ads__desktop__${position}_`;
        const storeDatasMobile = localStorage.getItem(queueNameMobile);
        const storeDatasDesktop = localStorage.getItem(queueNameDesktop);

        if (isMobile() && storeDatasMobile) {
            showAd($this, JSON.parse(storeDatasMobile), queueNameMobile);
        } else if (!isMobile() && storeDatasDesktop) {
            showAd($this, JSON.parse(storeDatasDesktop), queueNameDesktop);
        } else {
            const datasJson = JSON.parse(datas);

            if (datasJson.length <= 0) {
                return false;
            }
            
            const datasJsonMobile = datasJson.filter((e) => e.device.includes('mobile'));
            const datasJsonMobileRand = datasJsonMobile.sort(() => 0.5 - Math.random());
            const datasJsonDesktop = datasJson.filter((e) => e.device.includes('desktop'));
            const datasJsonDesktopRand = datasJsonDesktop.sort(() => 0.5 - Math.random());

            if (isMobile() && datasJsonMobile.length > 0) {
                localStorage.setItem(queueNameMobile, JSON.stringify(datasJsonMobileRand));
                showAd($this, datasJsonMobile, queueNameMobile);
                setAdTimeout();
            } else if (datasJsonDesktop.length > 0) {
                localStorage.setItem(queueNameDesktop, JSON.stringify(datasJsonDesktopRand));
                showAd($this, datasJsonDesktop, queueNameDesktop);
                setAdTimeout();
            }
        }
    });
});
