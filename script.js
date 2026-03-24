/* ============================================================
   NutrIA – script.js
   Funcionalidades: Navbar, Scroll Suave, Animações, Slider, Formulário
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {

  /* =============================================
     1. NAVBAR — scroll effect
  ============================================= */
  const navbar = document.getElementById('mainNavbar');

  function handleNavbarScroll() {
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  }

  window.addEventListener('scroll', handleNavbarScroll, { passive: true });
  handleNavbarScroll(); // run on load


  /* =============================================
     2. SMOOTH SCROLL para links do menu
  ============================================= */
  document.querySelectorAll('a.nav-smooth, a[href^="#"]').forEach(link => {
    link.addEventListener('click', e => {
      const href = link.getAttribute('href');
      if (!href || href === '#') return;
      const target = document.querySelector(href);
      if (!target) return;

      e.preventDefault();

      // Fechar menu mobile do Bootstrap se estiver aberto
      const collapse = document.getElementById('navbarContent');
      if (collapse && collapse.classList.contains('show')) {
        const bsCollapse = bootstrap.Collapse.getInstance(collapse);
        if (bsCollapse) bsCollapse.hide();
      }

      const offset = navbar.offsetHeight + 8;
      const top = target.getBoundingClientRect().top + window.scrollY - offset;
      window.scrollTo({ top, behavior: 'smooth' });
    });
  });


  /* =============================================
     3. SCROLL REVEAL — IntersectionObserver
  ============================================= */
  const revealEls = document.querySelectorAll('.reveal-up, .reveal-left, .reveal-right');

  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        revealObserver.unobserve(entry.target); // dispara apenas uma vez
      }
    });
  }, { threshold: 0.15 });

  revealEls.forEach(el => revealObserver.observe(el));


  /* =============================================
     4. SLIDER DE DEPOIMENTOS
  ============================================= */
  const track      = document.getElementById('sliderTrack');
  const dotsWrap   = document.getElementById('sliderDots');
  const prevBtn    = document.getElementById('prevBtn');
  const nextBtn    = document.getElementById('nextBtn');

  if (track && dotsWrap && prevBtn && nextBtn) {
    const slides    = Array.from(track.children);
    const total     = slides.length;
    let current     = 0;
    let autoTimer   = null;

    // Criar dots
    slides.forEach((_, i) => {
      const dot = document.createElement('button');
      dot.className = 'slider-dot' + (i === 0 ? ' active' : '');
      dot.setAttribute('aria-label', `Depoimento ${i + 1}`);
      dot.addEventListener('click', () => goTo(i));
      dotsWrap.appendChild(dot);
    });

    function updateDots() {
      dotsWrap.querySelectorAll('.slider-dot').forEach((dot, i) => {
        dot.classList.toggle('active', i === current);
      });
    }

    function goTo(index) {
      current = (index + total) % total;
      track.style.transform = `translateX(-${current * 100}%)`;
      updateDots();
    }

    function goNext() { goTo(current + 1); }
    function goPrev() { goTo(current - 1); }

    nextBtn.addEventListener('click', () => { goNext(); resetAuto(); });
    prevBtn.addEventListener('click', () => { goPrev(); resetAuto(); });

    // Autoplay
    function startAuto() {
      autoTimer = setInterval(goNext, 5000);
    }
    function resetAuto() {
      clearInterval(autoTimer);
      startAuto();
    }
    startAuto();

    // Swipe/touch suporte
    let touchStartX = 0;
    track.addEventListener('touchstart', e => { touchStartX = e.touches[0].clientX; }, { passive: true });
    track.addEventListener('touchend', e => {
      const diff = touchStartX - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 40) {
        diff > 0 ? goNext() : goPrev();
        resetAuto();
      }
    }, { passive: true });
  }


  /* =============================================
     5. FORMULÁRIO DE CONTATO — validação JS
  ============================================= */
  const form       = document.getElementById('contactForm');
  const formSuccess = document.getElementById('formSuccess');

  if (form) {
    form.addEventListener('submit', e => {
      e.preventDefault();
      e.stopPropagation();

      // Validar com API nativa do Bootstrap
      if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
      }

      // Simular envio — animar botão
      const btn = form.querySelector('button[type="submit"]');
      const label = btn.querySelector('.btn-label');
      const originalText = label ? label.textContent : btn.textContent;

      btn.disabled = true;
      if (label) label.textContent = 'Enviando…';
      btn.classList.add('opacity-75');

      setTimeout(() => {
        // Ocultar formulário e mostrar sucesso
        form.style.transition = 'opacity .4s';
        form.style.opacity = '0';
        setTimeout(() => {
          form.classList.add('d-none');
          formSuccess.classList.remove('d-none');
          formSuccess.style.opacity = '0';
          formSuccess.style.transition = 'opacity .4s';
          requestAnimationFrame(() => {
            requestAnimationFrame(() => {
              formSuccess.style.opacity = '1';
            });
          });
        }, 400);

        // Resetar após 6s (opcional)
        setTimeout(() => {
          form.reset();
          form.classList.remove('was-validated');
          form.style.opacity = '1';
          form.classList.remove('d-none');
          formSuccess.classList.add('d-none');
          btn.disabled = false;
          if (label) label.textContent = originalText;
          btn.classList.remove('opacity-75');
        }, 6000);

      }, 1800);
    });
  }


  /* =============================================
     6. ACTIVE NAV LINK — highlight ao scrollar
  ============================================= */
  const sections  = document.querySelectorAll('section[id]');
  const navLinks  = document.querySelectorAll('#mainNavbar .nav-link');

  function setActiveLink() {
    const scrollY = window.scrollY + navbar.offsetHeight + 40;

    sections.forEach(section => {
      const top    = section.offsetTop;
      const height = section.offsetHeight;
      const id     = section.getAttribute('id');

      if (scrollY >= top && scrollY < top + height) {
        navLinks.forEach(link => {
          link.classList.remove('active');
          if (link.getAttribute('href') === `#${id}`) {
            link.classList.add('active');
          }
        });
      }
    });
  }

  window.addEventListener('scroll', setActiveLink, { passive: true });
  setActiveLink();

});
