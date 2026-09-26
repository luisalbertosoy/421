(function () {
    var BASE_FONT_SIZE = 16;

    function fitText(el) {
        var container = el.parentElement;
        if (!container) return;

        var containerWidth = container.clientWidth;
        if (!containerWidth) return;

        el.style.fontSize = BASE_FONT_SIZE + 'px';
        var textWidth = el.scrollWidth;
        if (!textWidth) return;

        var newFontSize = (containerWidth / textWidth) * BASE_FONT_SIZE;
        el.style.fontSize = newFontSize + 'px';
    }

    function fitAll() {
        document.querySelectorAll('.js-fit-text').forEach(fitText);
    }

    document.addEventListener('DOMContentLoaded', fitAll);
    window.addEventListener('resize', fitAll);

    if (document.fonts && document.fonts.ready) {
        document.fonts.ready.then(fitAll);
    }
})();