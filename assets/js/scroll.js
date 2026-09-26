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