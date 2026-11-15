/* Southwestern Solutions — motion & 3D panoramic slider (vanilla JS, no dependencies) */
(function () {
  'use strict';
  var doc = document.documentElement;
  doc.classList.add('js');
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

  /* ---------- Header state + floating CTA ---------- */
  var header = document.querySelector('.site-header');
  var floatCta = document.querySelector('.float-cta');
  function onScroll() {
    var y = window.scrollY || 0;
    if (header) header.classList.toggle('is-scrolled', y > 40);
    if (floatCta) floatCta.classList.toggle('is-visible', y > 600);
    var heroBg = document.querySelector('.page-hero__bg');
    if (heroBg && !reduce) heroBg.style.setProperty('--scroll', (y * 0.25) + 'px');
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* ---------- Mobile nav ---------- */
  var toggle = document.querySelector('.nav-toggle');
  if (toggle) {
    toggle.addEventListener('click', function () {
      var open = document.body.classList.toggle('nav-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    document.querySelectorAll('.main-nav a').forEach(function (a) {
      a.addEventListener('click', function () { document.body.classList.remove('nav-open'); toggle.setAttribute('aria-expanded', 'false'); });
    });
  }

  /* ---------- 3D panoramic slider ---------- */
  document.querySelectorAll('[data-pano]').forEach(function (pano) {
    var slides = Array.prototype.slice.call(pano.querySelectorAll('.pano__slide'));
    var dots = Array.prototype.slice.call(pano.querySelectorAll('.pano__dot'));
    var countEl = pano.querySelector('.pano__count b');
    var delay = parseInt(pano.getAttribute('data-interval'), 10) || 7000;
    var idx = 0, timer = null, busy = false;
    pano.style.setProperty('--dur', delay + 'ms');

    function go(next, dir) {
      if (busy || next === idx || !slides[next]) return;
      busy = true;
      var cur = slides[idx];
      var forward = dir !== undefined ? dir > 0 : next > idx;
      slides.forEach(function (s) { s.classList.remove('from-left', 'to-right'); });
      cur.classList.remove('is-active');
      cur.classList.add('is-leaving');
      if (!forward) { cur.classList.add('to-right'); slides[next].classList.add('from-left'); }
      // force reflow so the incoming slide starts from its off-stage 3D position
      void slides[next].offsetWidth;
      slides[next].classList.remove('from-left');
      slides[next].classList.add('is-active');
      slides[next].removeAttribute('aria-hidden');
      cur.setAttribute('aria-hidden', 'true');
      dots.forEach(function (d, i) { d.classList.toggle('is-active', i === next); d.setAttribute('aria-selected', i === next ? 'true' : 'false'); });
      if (countEl) countEl.textContent = ('0' + (next + 1)).slice(-2);
      idx = next;
      setTimeout(function () { cur.classList.remove('is-leaving', 'to-right'); busy = false; }, 1400);
      restart();
    }
    function nextSlide() { go((idx + 1) % slides.length, 1); }
    function prevSlide() { go((idx - 1 + slides.length) % slides.length, -1); }
    function restart() {
      clearTimeout(timer);
      if (reduce || slides.length < 2) return;
      // restart the progress bar animation
      dots.forEach(function (d) { var i = d.querySelector('i'); if (i) { i.style.animation = 'none'; void i.offsetWidth; i.style.animation = ''; } });
      timer = setTimeout(nextSlide, delay);
    }

    dots.forEach(function (d, i) { d.addEventListener('click', function () { go(i); }); });
    var n = pano.querySelector('[data-pano-next]'), p = pano.querySelector('[data-pano-prev]');
    if (n) n.addEventListener('click', nextSlide);
    if (p) p.addEventListener('click', prevSlide);
    pano.addEventListener('keydown', function (e) { if (e.key === 'ArrowRight') nextSlide(); if (e.key === 'ArrowLeft') prevSlide(); });

    // touch swipe
    var sx = null;
    pano.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; }, { passive: true });
    pano.addEventListener('touchend', function (e) {
      if (sx === null) return;
      var dx = e.changedTouches[0].clientX - sx;
      if (Math.abs(dx) > 50) { dx < 0 ? nextSlide() : prevSlide(); }
      sx = null;
    });

    // pointer-driven panoramic pan + depth parallax
    if (fine && !reduce) {
      var raf = null, tx = 0, ty = 0;
      pano.addEventListener('mousemove', function (e) {
        var r = pano.getBoundingClientRect();
        tx = ((e.clientX - r.left) / r.width - 0.5) * -60;
        ty = ((e.clientY - r.top) / r.height - 0.5) * -30;
        if (!raf) raf = requestAnimationFrame(function () {
          pano.style.setProperty('--px', tx.toFixed(1) + 'px');
          pano.style.setProperty('--py', ty.toFixed(1) + 'px');
          raf = null;
        });
      });
      pano.addEventListener('mouseleave', function () { pano.style.setProperty('--px', '0px'); pano.style.setProperty('--py', '0px'); });
    }
    // pause when tab hidden
    document.addEventListener('visibilitychange', function () { document.hidden ? clearTimeout(timer) : restart(); });
    restart();
  });

  /* ---------- Reveal on scroll ---------- */
  var revealEls = document.querySelectorAll('[data-reveal]');
  if ('IntersectionObserver' in window && !reduce) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) { if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); } });
    }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach(function (el) { io.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add('is-in'); });
  }

  /* ---------- Animated counters ---------- */
  var counters = document.querySelectorAll('[data-count]');
  if ('IntersectionObserver' in window) {
    var co = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (!en.isIntersecting) return;
        var el = en.target, end = parseFloat(el.getAttribute('data-count')), suffix = el.getAttribute('data-suffix') || '', t0 = null;
        co.unobserve(el);
        if (reduce) { el.textContent = end + suffix; return; }
        function tick(ts) {
          if (!t0) t0 = ts;
          var k = Math.min((ts - t0) / 1600, 1), e = 1 - Math.pow(1 - k, 3);
          el.textContent = Math.round(end * e) + suffix;
          if (k < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
      });
    }, { threshold: 0.5 });
    counters.forEach(function (c) { co.observe(c); });
  }

  /* ---------- 3D tilt cards + spotlight ---------- */
  if (fine && !reduce) {
    document.querySelectorAll('[data-tilt]').forEach(function (el) {
      var max = parseFloat(el.getAttribute('data-tilt')) || 8;
      el.addEventListener('mousemove', function (e) {
        var r = el.getBoundingClientRect(), x = (e.clientX - r.left) / r.width, y = (e.clientY - r.top) / r.height;
        el.style.transform = 'perspective(900px) rotateX(' + ((0.5 - y) * max).toFixed(2) + 'deg) rotateY(' + ((x - 0.5) * max).toFixed(2) + 'deg) translateZ(0)';
        el.style.setProperty('--mx', (x * 100) + '%');
        el.style.setProperty('--my', (y * 100) + '%');
      });
      el.addEventListener('mouseleave', function () { el.style.transform = ''; });
    });

    var glow = document.createElement('div');
    glow.className = 'cursor-glow';
    glow.setAttribute('aria-hidden', 'true');
    document.body.appendChild(glow);
    window.addEventListener('mousemove', function (e) { glow.style.left = e.clientX + 'px'; glow.style.top = e.clientY + 'px'; }, { passive: true });
  }

  /* ---------- EN / ES language toggle for theme-rendered copy ---------- */
  var langBtn = document.querySelector('.lang-toggle');
  function setLang(l) {
    document.querySelectorAll('[data-es]').forEach(function (el) {
      if (!el.hasAttribute('data-en')) el.setAttribute('data-en', el.innerHTML);
      el.innerHTML = l === 'es' ? el.getAttribute('data-es') : el.getAttribute('data-en');
    });
    if (langBtn) langBtn.innerHTML = l === 'es' ? '<b>ES</b> / EN' : '<b>EN</b> / ES';
    try { localStorage.setItem('sws-lang', l); } catch (e) {}
  }
  if (langBtn) {
    var saved = 'en';
    try { saved = localStorage.getItem('sws-lang') || 'en'; } catch (e) {}
    if (saved === 'es') setLang('es');
    var curLang = saved;
    langBtn.addEventListener('click', function () {
      curLang = curLang === 'es' ? 'en' : 'es';
      setLang(curLang);
    });
  }
})();
