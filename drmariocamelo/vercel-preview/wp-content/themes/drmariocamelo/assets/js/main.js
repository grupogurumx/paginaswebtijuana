/* Dr. Mario Camelo — motion layer. No dependencies. */
(function () {
  'use strict';

  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var fine = window.matchMedia('(pointer: fine)').matches;

  /* Header state + mobile nav ------------------------------------------- */
  var header = document.querySelector('.site-header');
  var onScroll = function () {
    if (header) header.classList.toggle('is-scrolled', window.scrollY > 40);
  };
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  var toggle = document.querySelector('.nav-toggle');
  var nav = document.getElementById('main-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var open = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      document.body.style.overflow = open ? 'hidden' : '';
    });
    nav.addEventListener('click', function (e) {
      if (e.target.closest('a')) {
        nav.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      }
    });
  }

  /* 3D panoramic hero slider --------------------------------------------- */
  var hero = document.querySelector('[data-hero3d]');
  if (hero) {
    var slides = hero.querySelectorAll('.hero3d__slide');
    var dots = hero.querySelectorAll('.hero3d__dot');
    var counter = hero.querySelector('[data-hero-current]');
    var interval = parseInt(hero.getAttribute('data-interval'), 10) || 7000;
    var current = 0;
    var timer = null;
    hero.style.setProperty('--slide-ms', interval + 'ms');

    var go = function (n) {
      if (n === current) return;
      var prev = slides[current];
      prev.classList.remove('is-active');
      prev.classList.add('is-leaving');
      setTimeout(function () { prev.classList.remove('is-leaving'); }, 1400);
      dots[current].classList.remove('is-active');
      current = (n + slides.length) % slides.length;
      slides[current].classList.add('is-active');
      void dots[current].offsetWidth; // restart progress animation
      dots[current].classList.add('is-active');
      if (counter) counter.textContent = ('0' + (current + 1)).slice(-2);
    };
    var play = function () {
      clearInterval(timer);
      if (!reduce) timer = setInterval(function () { go(current + 1); }, interval);
    };
    hero.querySelector('[data-hero-next]').addEventListener('click', function () { go(current + 1); play(); });
    hero.querySelector('[data-hero-prev]').addEventListener('click', function () { go(current - 1); play(); });
    dots.forEach(function (d, i) { d.addEventListener('click', function () { go(i); play(); }); });

    // Swipe.
    var sx = null;
    hero.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; }, { passive: true });
    hero.addEventListener('touchend', function (e) {
      if (sx === null) return;
      var dx = e.changedTouches[0].clientX - sx;
      if (Math.abs(dx) > 50) { go(current + (dx < 0 ? 1 : -1)); play(); }
      sx = null;
    });
    // Keyboard.
    hero.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowRight') { go(current + 1); play(); }
      if (e.key === 'ArrowLeft') { go(current - 1); play(); }
    });
    // Pause when tab hidden.
    document.addEventListener('visibilitychange', function () { document.hidden ? clearInterval(timer) : play(); });

    // Mouse parallax depth on the panoramic backgrounds.
    if (fine && !reduce) {
      hero.addEventListener('mousemove', function (e) {
        var r = hero.getBoundingClientRect();
        var x = (e.clientX - r.left) / r.width - 0.5;
        var y = (e.clientY - r.top) / r.height - 0.5;
        hero.querySelectorAll('.hero3d__bg').forEach(function (bg) {
          bg.style.setProperty('--px', (-x * 40) + 'px');
          bg.style.setProperty('--py', (-y * 30) + 'px');
        });
      });
    }
    play();

    // Gold particles.
    var canvas = hero.querySelector('.hero3d__particles');
    if (canvas && !reduce) {
      var ctx = canvas.getContext('2d');
      var dpr = Math.min(window.devicePixelRatio || 1, 2);
      var parts = [];
      var resize = function () {
        canvas.width = hero.offsetWidth * dpr;
        canvas.height = hero.offsetHeight * dpr;
        canvas.style.width = hero.offsetWidth + 'px';
        canvas.style.height = hero.offsetHeight + 'px';
      };
      resize();
      window.addEventListener('resize', resize);
      var count = window.innerWidth < 720 ? 28 : 60;
      for (var i = 0; i < count; i++) {
        parts.push({
          x: Math.random(), y: Math.random(), z: Math.random() * 0.8 + 0.2,
          r: Math.random() * 1.8 + 0.4, s: Math.random() * 0.0006 + 0.0002, o: Math.random() * 0.6 + 0.2
        });
      }
      var visible = true;
      new IntersectionObserver(function (en) { visible = en[0].isIntersecting; }).observe(hero);
      var tick = function () {
        if (visible) {
          ctx.clearRect(0, 0, canvas.width, canvas.height);
          parts.forEach(function (p) {
            p.y -= p.s * p.z * 3;
            if (p.y < -0.05) { p.y = 1.05; p.x = Math.random(); }
            var px = p.x * canvas.width, py = p.y * canvas.height;
            var g = ctx.createRadialGradient(px, py, 0, px, py, p.r * 4 * dpr * p.z);
            g.addColorStop(0, 'rgba(243,221,151,' + p.o + ')');
            g.addColorStop(1, 'rgba(212,175,55,0)');
            ctx.fillStyle = g;
            ctx.beginPath();
            ctx.arc(px, py, p.r * 4 * dpr * p.z, 0, Math.PI * 2);
            ctx.fill();
          });
        }
        requestAnimationFrame(tick);
      };
      tick();
    }
  }

  /* Scroll reveal --------------------------------------------------------- */
  var revealEls = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window && !reduce) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach(function (el) { io.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add('is-in'); });
  }

  /* Counters -------------------------------------------------------------- */
  var counters = document.querySelectorAll('[data-count]');
  if ('IntersectionObserver' in window && !reduce) {
    var co = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (!en.isIntersecting) return;
        var el = en.target, end = parseInt(el.getAttribute('data-count'), 10), t0 = null;
        var step = function (ts) {
          if (!t0) t0 = ts;
          var p = Math.min((ts - t0) / 2000, 1);
          var eased = 1 - Math.pow(1 - p, 4);
          el.textContent = Math.round(end * eased).toLocaleString('en-US');
          if (p < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
        co.unobserve(el);
      });
    }, { threshold: 0.6 });
    counters.forEach(function (el) { co.observe(el); });
  }

  /* 3D tilt cards + magnetic buttons ------------------------------------- */
  if (fine && !reduce) {
    document.querySelectorAll('[data-tilt]').forEach(function (card) {
      card.addEventListener('mousemove', function (e) {
        var r = card.getBoundingClientRect();
        var x = (e.clientX - r.left) / r.width - 0.5;
        var y = (e.clientY - r.top) / r.height - 0.5;
        card.style.setProperty('--ry', (x * 14) + 'deg');
        card.style.setProperty('--rx', (-y * 14) + 'deg');
      });
      card.addEventListener('mouseleave', function () {
        card.style.setProperty('--ry', '0deg');
        card.style.setProperty('--rx', '0deg');
      });
    });
    document.querySelectorAll('[data-magnetic]').forEach(function (btn) {
      btn.addEventListener('mousemove', function (e) {
        var r = btn.getBoundingClientRect();
        btn.style.setProperty('--mx', ((e.clientX - r.left - r.width / 2) * 0.25) + 'px');
        btn.style.setProperty('--my', ((e.clientY - r.top - r.height / 2) * 0.35) + 'px');
      });
      btn.addEventListener('mouseleave', function () {
        btn.style.setProperty('--mx', '0px');
        btn.style.setProperty('--my', '0px');
      });
    });
  }

  /* Scroll parallax for panoramic bands --------------------------------- */
  var para = document.querySelectorAll('[data-parallax]');
  if (para.length && !reduce) {
    var ticking = false;
    var update = function () {
      para.forEach(function (el) {
        var r = el.parentElement.getBoundingClientRect();
        if (r.bottom < 0 || r.top > window.innerHeight) return;
        var p = (r.top + r.height / 2 - window.innerHeight / 2) / window.innerHeight;
        el.style.transform = 'translate3d(0,' + (p * -80) + 'px,0) scale(1.05)';
      });
      ticking = false;
    };
    window.addEventListener('scroll', function () {
      if (!ticking) { requestAnimationFrame(update); ticking = true; }
    }, { passive: true });
    update();
  }

  /* Conversion tracking (GA4 / GTM / Meta Pixel) ------------------------- */
  document.addEventListener('click', function (e) {
    var el = e.target.closest('[data-track]');
    if (!el || el.tagName === 'FORM') return;
    var name = el.getAttribute('data-track');
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({ event: name });
    if (typeof window.gtag === 'function') window.gtag('event', name);
    if (typeof window.fbq === 'function' && /whatsapp|call|financing/.test(name)) window.fbq('track', 'Contact');
  });
  document.querySelectorAll('form[data-track]').forEach(function (f) {
    f.addEventListener('submit', function () {
      window.dataLayer = window.dataLayer || [];
      window.dataLayer.push({ event: 'generate_lead' });
      if (typeof window.gtag === 'function') window.gtag('event', 'generate_lead');
      if (typeof window.fbq === 'function') window.fbq('track', 'Lead');
    });
  });
})();
