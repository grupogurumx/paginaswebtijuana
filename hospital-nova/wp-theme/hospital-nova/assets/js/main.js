/* Hospital Nova — motion & interacciones (sin dependencias) */
(function () {
  'use strict';
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* Header al hacer scroll + menú móvil */
  var header = document.querySelector('.site-header');
  var onScroll = function () { if (header) header.classList.toggle('is-scrolled', window.scrollY > 10); };
  window.addEventListener('scroll', onScroll, { passive: true }); onScroll();
  var toggle = document.querySelector('.nav-toggle');
  if (toggle) toggle.addEventListener('click', function () {
    var open = document.body.classList.toggle('nav-open');
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
  });

  /* Texto "magnific": divide en palabras y las revela */
  document.querySelectorAll('[data-split]').forEach(function (el) {
    var i = 0;
    var walk = function (node) {
      Array.prototype.slice.call(node.childNodes).forEach(function (child) {
        if (child.nodeType === 3) {
          var frag = document.createDocumentFragment();
          child.textContent.split(/(\s+)/).forEach(function (part) {
            if (!part) return;
            if (/^\s+$/.test(part)) { frag.appendChild(document.createTextNode(part)); return; }
            var w = document.createElement('span'); w.className = 'w';
            var s = document.createElement('span'); s.textContent = part; s.style.setProperty('--i', i++);
            w.appendChild(s); frag.appendChild(w);
          });
          node.replaceChild(frag, child);
        } else if (child.nodeType === 1) { walk(child); }
      });
    };
    walk(el);
    el.classList.add('split-reveal');
    requestAnimationFrame(function () { setTimeout(function () { el.classList.add('is-in'); }, 60); });
  });

  /* Reveal on scroll + contadores */
  var counters = function (el) {
    el.querySelectorAll('[data-count]').forEach(function (c) {
      var end = parseFloat(c.getAttribute('data-count')), suffix = c.getAttribute('data-suffix') || '', t0 = null;
      if (reduce) { c.textContent = end + suffix; return; }
      var step = function (t) {
        if (!t0) t0 = t;
        var p = Math.min((t - t0) / 1600, 1), e = 1 - Math.pow(1 - p, 3);
        c.textContent = Math.round(end * e) + suffix;
        if (p < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
    });
  };
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) { en.target.classList.add('is-in'); counters(en.target); io.unobserve(en.target); }
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
    document.querySelectorAll('.reveal, [data-counters]').forEach(function (el) { io.observe(el); });
  } else {
    document.querySelectorAll('.reveal').forEach(function (el) { el.classList.add('is-in'); });
  }

  /* Botones magnéticos */
  if (!reduce && window.matchMedia('(hover: hover)').matches) {
    document.querySelectorAll('[data-magnetic]').forEach(function (b) {
      b.addEventListener('mousemove', function (e) {
        var r = b.getBoundingClientRect();
        b.style.setProperty('--bx', ((e.clientX - r.left - r.width / 2) * 0.25) + 'px');
        b.style.setProperty('--by', ((e.clientY - r.top - r.height / 2) * 0.35) + 'px');
      });
      b.addEventListener('mouseleave', function () { b.style.setProperty('--bx', '0px'); b.style.setProperty('--by', '0px'); });
    });
  }

  /* Slider panorámico 3D */
  document.querySelectorAll('[data-pano]').forEach(function (pano) {
    var ring = pano.querySelector('.pano__ring');
    var tilt = pano.querySelector('.pano__tilt');
    var cards = Array.prototype.slice.call(pano.querySelectorAll('.pano__card'));
    var dotsWrap = pano.querySelector('.pano__dots');
    var bar = pano.querySelector('.pano__progress i');
    var orig = cards.length; if (!orig) return;
    // Panorámico: se clonan las tarjetas hasta tener un anillo de >= 9 para que las vecinas se vean en ángulo.
    var copies = 1;
    while (orig * (copies + 1) <= 12 && orig * copies < 9) {
      for (var k = 0; k < orig; k++) {
        var cl = cards[k].cloneNode(true);
        cl.setAttribute('aria-hidden', 'true');
        cl.querySelector('img').removeAttribute('fetchpriority');
        ring.appendChild(cl);
      }
      copies++;
    }
    cards = Array.prototype.slice.call(ring.querySelectorAll('.pano__card'));
    var n = cards.length;
    var step = 360 / n, index = 0, delay = parseInt(pano.getAttribute('data-autoplay') || '5000', 10), timer, start;

    ring.style.setProperty('--step', step + 'deg');
    // Radio calculado según el ancho de tarjeta y el número de caras del cilindro.
    var setRadius = function () {
      var w = ring.offsetWidth || 290;
      ring.style.setProperty('--radius', Math.round((w + 26) / (2 * Math.tan(Math.PI / n))) + 'px');
    };
    setRadius(); window.addEventListener('resize', setRadius);
    cards.forEach(function (c, i) {
      c.style.setProperty('--n', i);
      c.addEventListener('click', function () { go(i); });
      if (dotsWrap && i < orig) {
        var d = document.createElement('button');
        d.type = 'button'; d.setAttribute('aria-label', (c.getAttribute('data-label') || 'Slide') + ' ' + (i + 1));
        d.addEventListener('click', function () { go(i); });
        dotsWrap.appendChild(d);
      }
    });
    var dots = dotsWrap ? dotsWrap.children : [];

    function go(i) {
      // Camino más corto alrededor del cilindro
      var diff = ((i - index) % n + n) % n; if (diff > n / 2) diff -= n;
      index = index + diff;
      var active = ((index % n) + n) % n;
      ring.style.setProperty('--rot', (-index * step) + 'deg');
      cards.forEach(function (c, k) { c.classList.toggle('is-active', k === active); c.setAttribute('aria-hidden', k === active ? 'false' : 'true'); });
      Array.prototype.forEach.call(dots, function (d, k) { d.classList.toggle('is-active', k === active % orig); });
      restart();
    }
    function restart() {
      clearTimeout(timer); start = performance.now();
      if (!reduce && delay > 0) timer = setTimeout(function () { go(index + 1); }, delay);
    }
    (function tick(t) {
      if (bar && start && delay > 0) bar.style.width = Math.min(((t - start) / delay) * 100, 100) + '%';
      requestAnimationFrame(tick);
    })(0);

    var prev = pano.querySelector('[data-prev]'), next = pano.querySelector('[data-next]');
    if (prev) prev.addEventListener('click', function () { go(index - 1); });
    if (next) next.addEventListener('click', function () { go(index + 1); });
    pano.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowLeft') go(index - 1);
      if (e.key === 'ArrowRight') go(index + 1);
    });

    // Arrastre / swipe
    var x0 = null;
    pano.addEventListener('pointerdown', function (e) { x0 = e.clientX; });
    window.addEventListener('pointerup', function (e) {
      if (x0 === null) return;
      var dx = e.clientX - x0; x0 = null;
      if (Math.abs(dx) > 40) go(index + (dx < 0 ? 1 : -1));
    });

    // Parallax 3D con el mouse
    if (!reduce && tilt && window.matchMedia('(hover: hover)').matches) {
      pano.addEventListener('mousemove', function (e) {
        var r = pano.getBoundingClientRect();
        var px = (e.clientX - r.left) / r.width - 0.5, py = (e.clientY - r.top) / r.height - 0.5;
        tilt.style.transform = 'rotateX(' + (-py * 8) + 'deg) rotateY(' + (px * 10) + 'deg)';
      });
      pano.addEventListener('mouseleave', function () { tilt.style.transform = ''; });
    }
    pano.addEventListener('mouseenter', function () { clearTimeout(timer); start = null; if (bar) bar.style.width = '0'; });
    pano.addEventListener('mouseleave', restart);
    document.addEventListener('visibilitychange', function () { if (document.hidden) clearTimeout(timer); else restart(); });

    go(0);
  });

  /* Inclinación 3D sutil en tarjetas */
  if (!reduce && window.matchMedia('(hover: hover)').matches) {
    document.querySelectorAll('[data-tilt]').forEach(function (c) {
      c.addEventListener('mousemove', function (e) {
        var r = c.getBoundingClientRect();
        var px = (e.clientX - r.left) / r.width - 0.5, py = (e.clientY - r.top) / r.height - 0.5;
        c.style.transform = 'translateY(-6px) rotateX(' + (-py * 6) + 'deg) rotateY(' + (px * 6) + 'deg)';
      });
      c.addEventListener('mouseleave', function () { c.style.transform = ''; });
    });
  }
})();
