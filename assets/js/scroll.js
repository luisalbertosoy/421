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
document.addEventListener('DOMContentLoaded', function () {

    // =========================
    // HEADER NAV ACTIVE STATE
    // =========================
    // Marks the header link (desktop menu, desktop CTA, mobile menu) whose #hash matches the
    // section under the header. When several links share a section, the last clicked one wins.
    const header   = document.querySelector('.header-wrapper');
    const allLinks = Array.from(document.querySelectorAll(
        '.header-nav .menu-list > li > a.txt-btn, .header-nav > a.txt-btn'
    ));
    const sectionOf = link => (link.hash ? document.getElementById(link.hash.slice(1)) : null);
    const links     = allLinks.filter(sectionOf);
    if (!header || !allLinks.length) return;

    // Unique sections referenced by the nav, in document order.
    const sections = [...new Set(links.map(sectionOf))]
        .sort((a, b) => (a.compareDocumentPosition(b) & Node.DOCUMENT_POSITION_FOLLOWING) ? -1 : 1);

    // Desktop and mobile menus each keep their own active link.
    const groupOf = link => (link.closest('#mobile-menu') ? 'mobile' : 'desktop');

    let lastClicked = null;
    let locked      = false; // Ignore scroll updates while a clicked link is smooth-scrolling.
    let unlockTimer;

    function applyActive(activeLinks) {
        allLinks.forEach(link => {
            const isActive = activeLinks.includes(link);
            link.classList.toggle('active', isActive);
            if (isActive) link.setAttribute('aria-current', 'location');
            else link.removeAttribute('aria-current');
        });
    }

    function setActive(id) {
        const active = [];
        ['desktop', 'mobile'].forEach(group => {
            const candidates = links.filter(link => groupOf(link) === group && link.hash === '#' + id);
            if (!candidates.length) return;
            active.push(candidates.includes(lastClicked) ? lastClicked : candidates[0]);
        });
        applyActive(active);
    }

    function updateActive() {
        if (locked) return;

        // Same probe line as the header theme: the vertical center of the header.
        const headerRect = header.getBoundingClientRect();
        const probe      = headerRect.top + headerRect.height / 2;

        // Last nav section whose top has passed the probe; defaults to the first one.
        if (!sections.length) return;
        let active = sections[0];
        sections.forEach(section => {
            if (section.getBoundingClientRect().top <= probe) active = section;
        });
        setActive(active.id);
    }

    function unlock() {
        clearTimeout(unlockTimer);
        locked = false;
        updateActive();
    }

    allLinks.forEach(link => {
        link.addEventListener('click', function () {
            lastClicked = this;
            applyActive([this]);
            if (!sectionOf(this)) return;
            locked = true;
            // Release once scrolling settles ('scrollend' where supported, timeout as fallback).
            clearTimeout(unlockTimer);
            unlockTimer = setTimeout(unlock, 1200);
        });
    });

    let ticking = false;
    window.addEventListener('scroll', function () {
        if (locked) {
            // Keep extending the lock while the smooth scroll is still moving.
            clearTimeout(unlockTimer);
            unlockTimer = setTimeout(unlock, 150);
            return;
        }
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(() => { ticking = false; updateActive(); });
    }, { passive: true });
    window.addEventListener('scrollend', () => { if (locked) unlock(); });
    window.addEventListener('resize', updateActive);

    updateActive();
});
