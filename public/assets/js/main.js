/* Expo Cyprus — Main JS v1.0 */
(function () {
    'use strict';

    // ── Header scroll effect ──────────────────────────────────────
    const header = document.getElementById('site-header');
    if (header) {
        const onScroll = () => header.classList.toggle('scrolled', window.scrollY > 10);
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    // ── Mobile menu ───────────────────────────────────────────────
    const menuBtn     = document.getElementById('mobileMenuBtn');
    const menuOverlay = document.getElementById('mobileMenuOverlay');

    function openMenu() {
        menuOverlay?.classList.add('open');
        menuBtn?.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }
    function closeMenu() {
        menuOverlay?.classList.remove('open');
        menuBtn?.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    menuBtn?.addEventListener('click', () =>
        menuOverlay?.classList.contains('open') ? closeMenu() : openMenu()
    );

    // Close on overlay background click
    menuOverlay?.addEventListener('click', (e) => {
        if (!e.target.closest('.mobile-nav')) closeMenu();
    });

    // Close on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeMenu();
    });

    // ── Stats counter animation (Intersection Observer) ───────────
    const statItems = document.querySelectorAll('[data-animate="counter"]');
    if (statItems.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const numEl = entry.target.querySelector('.stat-num');
                if (!numEl || numEl.dataset.animated) return;
                numEl.dataset.animated = '1';

                const raw    = numEl.textContent.trim();
                const suffix = raw.match(/[^\d]+$/)?.[0] ?? '';
                const prefix = raw.match(/^[^\d]*/)?.[0] ?? '';
                const target = parseInt(raw.replace(/\D/g, ''), 10) || 0;
                const duration = 1800;
                const start    = performance.now();

                const step = (now) => {
                    const progress = Math.min((now - start) / duration, 1);
                    const eased    = 1 - Math.pow(1 - progress, 3);
                    numEl.textContent = prefix + Math.round(target * eased) + suffix;
                    if (progress < 1) requestAnimationFrame(step);
                };
                requestAnimationFrame(step);
                observer.unobserve(entry.target);
            });
        }, { threshold: 0.4 });

        statItems.forEach(el => observer.observe(el));
    }

    // ── Fade-in on scroll ─────────────────────────────────────────
    const fadeEls = document.querySelectorAll(
        '.service-card, .fair-card, .blog-card, .why-item, .stat-item'
    );
    if (fadeEls.length > 0 && 'IntersectionObserver' in window) {
        const fadeObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (!entry.isIntersecting) return;
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, i * 60);
                fadeObserver.unobserve(entry.target);
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        fadeEls.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            fadeObserver.observe(el);
        });
    }

    // ── Cookie Banner ─────────────────────────────────────────────
    const cookieBanner  = document.getElementById('cookieBanner');
    const cookieAccept  = document.getElementById('cookieAccept');
    const cookieDecline = document.getElementById('cookieDecline');
    const COOKIE_KEY    = 'ec_cookie_consent';

    function getCookie(name) {
        return document.cookie.split('; ').find(r => r.startsWith(name + '='))?.split('=')[1];
    }
    function setCookie(name, value, days) {
        const d = new Date();
        d.setTime(d.getTime() + days * 86400000);
        document.cookie = `${name}=${value}; expires=${d.toUTCString()}; path=/; SameSite=Lax`;
    }

    if (cookieBanner && !getCookie(COOKIE_KEY)) {
        setTimeout(() => { cookieBanner.style.display = 'block'; }, 1500);
    }
    cookieAccept?.addEventListener('click', () => {
        setCookie(COOKIE_KEY, 'accepted', 365);
        cookieBanner.style.display = 'none';
    });
    cookieDecline?.addEventListener('click', () => {
        setCookie(COOKIE_KEY, 'declined', 30);
        cookieBanner.style.display = 'none';
    });

    // ── Dropdown keyboard accessibility ───────────────────────────
    document.querySelectorAll('.nav-dropdown-trigger').forEach(trigger => {
        trigger.addEventListener('click', function () {
            const expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', String(!expanded));
        });
    });

    document.addEventListener('click', (e) => {
        if (!e.target.closest('.has-dropdown')) {
            document.querySelectorAll('.nav-dropdown-trigger').forEach(t =>
                t.setAttribute('aria-expanded', 'false')
            );
        }
    });

})();
