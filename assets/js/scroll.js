document.addEventListener('DOMContentLoaded', function () {

    // =========================
    // HERO SCROLL BUTTON
    // =========================
    const scrollBtn = document.getElementById('btn-scroll');
    if (scrollBtn) {
        scrollBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.getElementById('section-1');
            if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    }

    // =========================
    // SCROLL DOWN BUTTONS
    // =========================
    // Each .scroll-next scrolls to the section right after its parent section.
    document.querySelectorAll('.scroll-next').forEach(btn => {
        function scrollToNext() {
            const section = btn.closest('section');
            let next = section ? section.nextElementSibling : null;
            while (next && next.tagName !== 'SECTION') next = next.nextElementSibling;
            if (next) next.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        btn.addEventListener('click', scrollToNext);
        btn.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                scrollToNext();
            }
        });
    });

    // =========================
    // FLOATING MENU SCROLL
    // =========================
    const navButtons = document.querySelectorAll('[id^="to-sec-"]');
    if (!navButtons.length) return;

    navButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            // Update active state
            navButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Scroll to target
            const targetId = this.id.replace('to-sec-', 'section-');
            const target   = document.getElementById(targetId);
            if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {

    // =========================
    // HEADER COLOR PER SECTION
    // =========================
    // Section id => header variant ('light' = white, 'dark' = black).
    const headerThemes = {
        intro:      'light',
        about:      'dark',
        experience: 'light',
        book:       'light',
        footer:     'light',
    };

    const header   = document.querySelector('.header-wrapper');
    const sections = Object.keys(headerThemes)
        .map(id => document.getElementById(id))
        .filter(Boolean);
    if (!header || !sections.length) return;

    let current = null;
    let ticking = false;

    function updateHeaderTheme() {
        ticking = false;

        // Use the vertical center of the header as the probe line.
        const headerRect = header.getBoundingClientRect();
        const probe      = headerRect.top + headerRect.height / 2;

        const active = sections.find(section => {
            const rect = section.getBoundingClientRect();
            return rect.top <= probe && rect.bottom > probe;
        });
        const theme = active ? headerThemes[active.id] : 'light';
        if (theme === current) return;

        header.classList.remove('header-' + current);
        header.classList.add('header-' + theme);
        current = theme;
    }

    function onScroll() {
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(updateHeaderTheme);
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll);
    updateHeaderTheme();
});