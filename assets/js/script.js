/* =========================================================
   NutrIA — script.js
   - Navbar scroll state
   - Active link highlight
   - Reveal on scroll
   - Counter animation
   - Form validation (client-side)
   - Mobile menu auto-close
   ========================================================= */
(function () {
  'use strict';

  // --- Navbar scrolled state ---
  const navbar = document.querySelector('.nt-navbar');
  const onScroll = () => {
    if (!navbar) return;
    if (window.scrollY > 20) navbar.classList.add('scrolled');
    else navbar.classList.remove('scrolled');
  };
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  // --- Active link highlight ---
  const navLinks = document.querySelectorAll('.nt-nav-link[href^="#"]');
  const sections = [...navLinks]
    .map(a => document.querySelector(a.getAttribute('href')))
    .filter(Boolean);

  const linkObserver = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (e.isIntersecting) {
        const id = '#' + e.target.id;
        navLinks.forEach((a) => {
          a.classList.toggle('active', a.getAttribute('href') === id);
        });
      }
    });
  }, { rootMargin: '-45% 0px -50% 0px', threshold: 0 });
  sections.forEach((s) => linkObserver.observe(s));

  // --- Reveal on scroll ---
  const revealEls = document.querySelectorAll('.reveal');
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (e.isIntersecting) {
        e.target.classList.add('in');
        revealObserver.unobserve(e.target);
      }
    });
  }, { threshold: 0.12 });
  revealEls.forEach((el) => revealObserver.observe(el));

  // --- Counter animation ---
  const counters = document.querySelectorAll('[data-counter]');
  const animateCounter = (el) => {
    const target = parseFloat(el.getAttribute('data-counter'));
    const suffix = el.getAttribute('data-suffix') || '';
    const duration = 1600;
    const start = performance.now();
    const startVal = 0;
    const ease = (t) => 1 - Math.pow(1 - t, 3);

    const tick = (now) => {
      const t = Math.min(1, (now - start) / duration);
      const v = Math.floor(startVal + (target - startVal) * ease(t));
      // Preserve the trailing small/label if it exists as a child
      const small = el.querySelector('small');
      el.childNodes[0].nodeValue = v + suffix;
      if (small) el.appendChild(small); // keep appended
      if (t < 1) requestAnimationFrame(tick);
      else {
        el.childNodes[0].nodeValue = target + suffix;
        if (small) el.appendChild(small);
      }
    };
    requestAnimationFrame(tick);
  };

  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (e.isIntersecting) {
        animateCounter(e.target);
        counterObserver.unobserve(e.target);
      }
    });
  }, { threshold: 0.4 });
  counters.forEach((c) => counterObserver.observe(c));

  // --- Mobile menu auto-close on link click ---
  const collapseEl = document.getElementById('ntNav');
  if (collapseEl) {
    collapseEl.querySelectorAll('a.nav-link, a.nt-btn').forEach((a) => {
      a.addEventListener('click', () => {
        if (collapseEl.classList.contains('show') && window.bootstrap) {
          const inst = window.bootstrap.Collapse.getInstance(collapseEl)
            || new window.bootstrap.Collapse(collapseEl, { toggle: false });
          inst.hide();
        }
      });
    });
  }

  // --- Form validation ---
  const form = document.getElementById('ntForm');
  const okBox = document.getElementById('ntFormOk');

  const isEmail = (v) => /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(String(v).trim());

  const setError = (field, hasError) => {
    const wrap = field.closest('.nt-field');
    if (!wrap) return;
    wrap.classList.toggle('has-error', !!hasError);
  };

  const validateField = (field) => {
    const v = (field.value || '').trim();
    if (field.required && !v) { setError(field, true); return false; }
    if (field.type === 'email' && v && !isEmail(v)) { setError(field, true); return false; }
    setError(field, false);
    return true;
  };

  if (form) {
    form.querySelectorAll('input, textarea, select').forEach((el) => {
      el.addEventListener('blur', () => validateField(el));
      el.addEventListener('input', () => {
        if (el.closest('.nt-field')?.classList.contains('has-error')) validateField(el);
      });
    });

    form.addEventListener('submit', (e) => {
      e.preventDefault();
      let ok = true;
      form.querySelectorAll('input, textarea, select').forEach((el) => {
        if (!validateField(el)) ok = false;
      });
      if (!ok) {
        const firstErr = form.querySelector('.nt-field.has-error input, .nt-field.has-error textarea, .nt-field.has-error select');
        if (firstErr) firstErr.focus();
        return;
      }
      // Success feedback (real submit deve acontecer em contato.php via PHP)
      okBox?.classList.add('show');
      form.reset();
      setTimeout(() => okBox?.classList.remove('show'), 6000);
      okBox?.scrollIntoView?.({ block: 'nearest', behavior: 'smooth' });
    });
  }
})();
