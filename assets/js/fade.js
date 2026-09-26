document.addEventListener('DOMContentLoaded', function () {
    const preloader = document.getElementById('preloader');
    const body = document.body;

    // Fade out preloader on load
    setTimeout(() => {
        preloader.classList.add('fade-out');
        body.classList.add('loaded');
    }, 500);

    // Fade out on navigation
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function (e) {
            const href = this.href;
            const isBlank    = this.target === '_blank';
            const isHash     = href.includes('#');
            const isExternal = !href.startsWith(window.location.origin);
            const isEmpty    = !href || href === 'javascript:void(0)';

            if (isBlank || isHash || isExternal || isEmpty) return;

            e.preventDefault();
            body.style.opacity = 0;

            setTimeout(() => {
                window.location.href = href;
            }, 600);
        });
    });
});