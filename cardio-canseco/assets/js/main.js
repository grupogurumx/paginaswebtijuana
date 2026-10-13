/* ==========================================================================
   Cardiología Tijuana — Dr. Eduardo Canseco
   Interacciones y animaciones. Sin dependencias externas.
   ========================================================================== */
(function () {
  'use strict';

  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function ready(fn) {
    if (document.readyState !== 'loading') { fn(); }
    else { document.addEventListener('DOMContentLoaded', fn); }
  }

  /* ------------------------------------------------------------------
     1. Cabecera fija + barra de progreso de lectura
     ------------------------------------------------------------------ */
  function initHeader() {
    var header = document.querySelector('.site-header');
    if (!header) return;

    var progress = header.querySelector('.scroll-progress');
    var ticking = false;

    function update() {
      var y = window.scrollY || window.pageYOffset;
      header.classList.toggle('is-stuck', y > 12);

      if (progress) {
        var doc = document.documentElement;
        var max = doc.scrollHeight - window.innerHeight;
        var ratio = max > 0 ? Math.min(y / max, 1) : 0;
        progress.style.transform = 'scaleX(' + ratio + ')';
      }
      ticking = false;
    }

    window.addEventListener('scroll', function () {
      if (!ticking) { window.requestAnimationFrame(update); ticking = true; }
    }, { passive: true });

    update();
  }

  /* ------------------------------------------------------------------
     2. Menú móvil
     ------------------------------------------------------------------ */
  function initMobileNav() {
    var toggle = document.querySelector('.nav-toggle');
    var panel = document.querySelector('.mobile-nav');
    if (!toggle || !panel) return;

    var closeBtn = panel.querySelector('.mobile-nav__close');
    var lastFocus = null;

    function open() {
      lastFocus = document.activeElement;
      panel.classList.add('is-open');
      toggle.setAttribute('aria-expanded', 'true');
      document.body.classList.add('is-locked');
      var first = panel.querySelector('a, button');
      if (first) first.focus();
    }

    function close() {
      panel.classList.remove('is-open');
      toggle.setAttribute('aria-expanded', 'false');
      document.body.classList.remove('is-locked');
      if (lastFocus) lastFocus.focus();
    }

    toggle.addEventListener('click', function () {
      panel.classList.contains('is-open') ? close() : open();
    });
    if (closeBtn) closeBtn.addEventListener('click', close);

    panel.addEventListener('click', function (e) {
      if (e.target.tagName === 'A') close();
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && panel.classList.contains('is-open')) close();
    });

    // Cierra al pasar a escritorio
    window.matchMedia('(min-width: 1081px)').addEventListener('change', function (e) {
      if (e.matches && panel.classList.contains('is-open')) close();
    });
  }

  /* ------------------------------------------------------------------
     3. Slider panorámico del hero
     ------------------------------------------------------------------ */
  function initHero() {
    var hero = document.querySelector('[data-hero]');
    if (!hero) return;

    var slides = Array.prototype.slice.call(hero.querySelectorAll('.hero__slide'));
    if (slides.length < 2) return;

    var dots = Array.prototype.slice.call(hero.querySelectorAll('.hero__dot'));
    var prevBtn = hero.querySelector('[data-hero-prev]');
    var nextBtn = hero.querySelector('[data-hero-next]');
    var live = hero.querySelector('[data-hero-live]');

    var index = 0;
    var timer = null;
    var DELAY = 7000;

    function render() {
      slides.forEach(function (slide, i) {
        var active = i === index;
        slide.classList.toggle('is-active', active);
        slide.setAttribute('aria-hidden', active ? 'false' : 'true');
      });
      dots.forEach(function (dot, i) {
        // Reiniciar la animación de la barra del punto activo
        dot.classList.remove('is-active');
        void dot.offsetWidth;
        if (i === index) dot.classList.add('is-active');
        dot.setAttribute('aria-selected', i === index ? 'true' : 'false');
      });
      if (live) live.textContent = 'Diapositiva ' + (index + 1) + ' de ' + slides.length;
    }

    function go(i) {
      index = (i + slides.length) % slides.length;
      render();
      restart();
    }

    function next() { go(index + 1); }
    function prev() { go(index - 1); }

    function start() {
      if (reduceMotion) return;
      stop();
      timer = window.setInterval(next, DELAY);
      hero.classList.remove('is-paused');
    }
    function stop() {
      if (timer) { window.clearInterval(timer); timer = null; }
      hero.classList.add('is-paused');
    }
    function restart() { if (timer !== null || !reduceMotion) start(); }

    if (nextBtn) nextBtn.addEventListener('click', next);
    if (prevBtn) prevBtn.addEventListener('click', prev);
    dots.forEach(function (dot, i) {
      dot.addEventListener('click', function () { go(i); });
    });

    // Pausar al interactuar
    hero.addEventListener('mouseenter', stop);
    hero.addEventListener('mouseleave', start);
    hero.addEventListener('focusin', stop);
    hero.addEventListener('focusout', function (e) {
      if (!hero.contains(e.relatedTarget)) start();
    });

    // Pausar cuando la pestaña no está visible
    document.addEventListener('visibilitychange', function () {
      document.hidden ? stop() : start();
    });

    // Teclado
    hero.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowRight') { e.preventDefault(); next(); }
      if (e.key === 'ArrowLeft') { e.preventDefault(); prev(); }
    });

    // Gestos táctiles
    var startX = 0, startY = 0, tracking = false;
    hero.addEventListener('touchstart', function (e) {
      startX = e.touches[0].clientX;
      startY = e.touches[0].clientY;
      tracking = true;
      stop();
    }, { passive: true });

    hero.addEventListener('touchend', function (e) {
      if (!tracking) return;
      tracking = false;
      var dx = e.changedTouches[0].clientX - startX;
      var dy = e.changedTouches[0].clientY - startY;
      if (Math.abs(dx) > 48 && Math.abs(dx) > Math.abs(dy)) {
        dx < 0 ? next() : prev();
      } else {
        start();
      }
    }, { passive: true });

    render();
    start();
  }

  /* ------------------------------------------------------------------
     4. Aparición al hacer scroll
     ------------------------------------------------------------------ */
  function initReveal() {
    var items = document.querySelectorAll('[data-reveal], [data-reveal-group], .ecg-divider');
    if (!items.length) return;

    if (reduceMotion || !('IntersectionObserver' in window)) {
      items.forEach(function (el) { el.classList.add('is-visible'); });
      return;
    }

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });

    items.forEach(function (el) { io.observe(el); });
  }

  /* ------------------------------------------------------------------
     5. Contadores animados
     ------------------------------------------------------------------ */
  function initCounters() {
    var counters = document.querySelectorAll('[data-count]');
    if (!counters.length) return;

    function run(el) {
      var target = parseFloat(el.getAttribute('data-count'));
      var suffix = el.getAttribute('data-suffix') || '';
      var prefix = el.getAttribute('data-prefix') || '';
      var decimals = (String(target).split('.')[1] || '').length;

      if (reduceMotion) {
        el.textContent = prefix + target.toFixed(decimals) + suffix;
        return;
      }

      var duration = 1500;
      var startTime = null;

      function step(now) {
        if (!startTime) startTime = now;
        var p = Math.min((now - startTime) / duration, 1);
        var eased = 1 - Math.pow(1 - p, 3);
        el.textContent = prefix + (target * eased).toFixed(decimals) + suffix;
        if (p < 1) window.requestAnimationFrame(step);
      }
      window.requestAnimationFrame(step);
    }

    if (!('IntersectionObserver' in window)) {
      counters.forEach(run);
      return;
    }

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          run(entry.target);
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.6 });

    counters.forEach(function (el) { io.observe(el); });
  }

  /* ------------------------------------------------------------------
     6. Parallax ligero
     ------------------------------------------------------------------ */
  function initParallax() {
    if (reduceMotion) return;
    var items = Array.prototype.slice.call(document.querySelectorAll('[data-parallax]'));
    if (!items.length) return;

    var ticking = false;

    function update() {
      var vh = window.innerHeight;
      items.forEach(function (el) {
        var rect = el.getBoundingClientRect();
        if (rect.bottom < -200 || rect.top > vh + 200) return;
        var speed = parseFloat(el.getAttribute('data-parallax')) || 0.14;
        var offset = (rect.top + rect.height / 2 - vh / 2) * speed;
        el.style.transform = 'translate3d(0,' + offset.toFixed(2) + 'px,0)';
      });
      ticking = false;
    }

    window.addEventListener('scroll', function () {
      if (!ticking) { window.requestAnimationFrame(update); ticking = true; }
    }, { passive: true });
    window.addEventListener('resize', update);
    update();
  }

  /* ------------------------------------------------------------------
     7. Navegación activa según la sección visible (sólo en portada)
     ------------------------------------------------------------------ */
  function initScrollSpy() {
    var links = Array.prototype.slice.call(document.querySelectorAll('[data-spy]'));
    if (!links.length || !('IntersectionObserver' in window)) return;

    var map = {};
    var sections = [];
    links.forEach(function (link) {
      var id = link.getAttribute('href');
      if (!id || id.charAt(0) !== '#') return;
      var section = document.querySelector(id);
      if (section) { map[id] = link; sections.push(section); }
    });
    if (!sections.length) return;

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        var link = map['#' + entry.target.id];
        if (!link) return;
        if (entry.isIntersecting) {
          links.forEach(function (l) { l.removeAttribute('aria-current'); });
          link.setAttribute('aria-current', 'page');
        }
      });
    }, { threshold: 0.45, rootMargin: '-20% 0px -40% 0px' });

    sections.forEach(function (s) { io.observe(s); });
  }

  /* ------------------------------------------------------------------
     8. Acordeón: cerrar los demás al abrir uno
     ------------------------------------------------------------------ */
  function initFaq() {
    var groups = document.querySelectorAll('[data-faq]');
    groups.forEach(function (group) {
      var items = Array.prototype.slice.call(group.querySelectorAll('details'));
      items.forEach(function (item) {
        item.addEventListener('toggle', function () {
          if (!item.open) return;
          items.forEach(function (other) {
            if (other !== item) other.open = false;
          });
        });
      });
    });
  }

  /* ------------------------------------------------------------------
     9. Validación del formulario + envío a WhatsApp como respaldo
     ------------------------------------------------------------------ */
  function initForms() {
    var forms = document.querySelectorAll('[data-form]');
    forms.forEach(function (form) {
      form.addEventListener('submit', function (e) {
        if (!form.checkValidity()) {
          e.preventDefault();
          var invalid = form.querySelector(':invalid');
          if (invalid) invalid.focus();
          form.reportValidity();
          return;
        }

        // Si no hay backend configurado, se abre WhatsApp con el mensaje armado.
        var wa = form.getAttribute('data-whatsapp');
        if (!wa) return;

        e.preventDefault();
        var data = new FormData(form);
        var lines = ['Hola, quiero agendar una cita en Cardiología Tijuana.', ''];
        var labels = {
          nombre: 'Nombre', telefono: 'Teléfono', email: 'Correo',
          estudio: 'Estudio de interés', fecha: 'Fecha preferida', mensaje: 'Mensaje'
        };
        Object.keys(labels).forEach(function (key) {
          var value = data.get(key);
          if (value) lines.push(labels[key] + ': ' + value);
        });

        var url = 'https://wa.me/' + wa + '?text=' + encodeURIComponent(lines.join('\n'));
        window.open(url, '_blank', 'noopener');
        form.reset();

        var ok = form.querySelector('[data-form-success]');
        if (ok) { ok.hidden = false; ok.focus(); }
      });
    });
  }

  /* ------------------------------------------------------------------
     10. Año actual en el pie
     ------------------------------------------------------------------ */
  function initYear() {
    var el = document.querySelectorAll('[data-year]');
    var y = new Date().getFullYear();
    el.forEach(function (node) { node.textContent = y; });
  }

  /* ------------------------------------------------------------------
     Arranque
     ------------------------------------------------------------------ */
  ready(function () {
    initHeader();
    initMobileNav();
    initHero();
    initReveal();
    initCounters();
    initParallax();
    initScrollSpy();
    initFaq();
    initForms();
    initYear();
  });
})();
