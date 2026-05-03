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

    // ── ab-carousel (PHPagebuilder bloğu) ─────────────────────────
    document.querySelectorAll('[data-ab-carousel]').forEach((root) => {
        const track  = root.querySelector('.ab-carousel-track');
        const slides = root.querySelectorAll('.ab-carousel-slide');
        const prev   = root.querySelector('.ab-carousel-prev');
        const next   = root.querySelector('.ab-carousel-next');
        const dotsEl = root.querySelector('.ab-carousel-dots');
        if (!track || slides.length === 0) return;

        let index = 0;
        const total = slides.length;

        // Dots
        if (dotsEl) {
            dotsEl.innerHTML = '';
            slides.forEach((_, i) => {
                const dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'ab-carousel-dot' + (i === 0 ? ' active' : '');
                dot.setAttribute('aria-label', `Slayt ${i + 1}`);
                dot.addEventListener('click', () => go(i));
                dotsEl.appendChild(dot);
            });
        }

        function go(i) {
            index = ((i % total) + total) % total;
            track.style.transform = `translateX(-${index * 100}%)`;
            if (dotsEl) {
                dotsEl.querySelectorAll('.ab-carousel-dot').forEach((d, j) =>
                    d.classList.toggle('active', j === index)
                );
            }
        }

        prev?.addEventListener('click', () => go(index - 1));
        next?.addEventListener('click', () => go(index + 1));

        // Auto-play (8s)
        let timer = setInterval(() => go(index + 1), 8000);
        root.addEventListener('mouseenter', () => clearInterval(timer));
        root.addEventListener('mouseleave', () => { timer = setInterval(() => go(index + 1), 8000); });

        // Touch swipe
        let startX = 0, deltaX = 0;
        track.addEventListener('touchstart', (e) => { startX = e.touches[0].clientX; }, { passive: true });
        track.addEventListener('touchmove',  (e) => { deltaX = e.touches[0].clientX - startX; }, { passive: true });
        track.addEventListener('touchend',   () => {
            if (Math.abs(deltaX) > 50) go(deltaX < 0 ? index + 1 : index - 1);
            deltaX = 0;
        });
    });

})();
