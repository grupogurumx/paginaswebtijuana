/**
 * Acabados Contemporáneos — interacción y motion.
 * Sin dependencias. Respeta prefers-reduced-motion.
 */
(function () {
	'use strict';

	var doc = document.documentElement;
	doc.classList.add('js');
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

	function $(sel, ctx) { return (ctx || document).querySelector(sel); }
	function $$(sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); }
	function clamp(v, a, b) { return Math.min(b, Math.max(a, v)); }

	/* ------------------------------------------------------------------
	 * Encabezado: estado al hacer scroll y ocultar al bajar
	 * ------------------------------------------------------------------ */
	var header = $('[data-header]');
	var lastY = window.scrollY;
	function onScrollHeader() {
		if (!header) { return; }
		var y = window.scrollY;
		header.classList.toggle('is-scrolled', y > 40);
		var hide = y > lastY && y > 400 && !document.body.classList.contains('nav-open');
		header.classList.toggle('is-hidden', hide);
		lastY = y;
	}

	/* ------------------------------------------------------------------
	 * Menú móvil
	 * ------------------------------------------------------------------ */
	var toggle = $('[data-nav-toggle]');
	if (toggle) {
		toggle.addEventListener('click', function () {
			var open = document.body.classList.toggle('nav-open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && document.body.classList.contains('nav-open')) {
				document.body.classList.remove('nav-open');
				toggle.setAttribute('aria-expanded', 'false');
				toggle.focus();
			}
		});
		$$('.primary-nav .menu-item-has-children > a').forEach(function (a) {
			a.addEventListener('click', function (e) {
				if (window.innerWidth > 1020) { return; }
				var li = a.parentNode;
				if (!li.classList.contains('is-open')) {
					e.preventDefault();
					li.classList.add('is-open');
				}
			});
		});
	}

	/* ------------------------------------------------------------------
	 * HERO: slider panorámico 3D (cilindro)
	 * ------------------------------------------------------------------ */
	function Hero(root) {
		var stage = $('[data-hero-stage]', root);
		var slides = $$('[data-hero-slide]', root);
		var thumbs = $$('[data-hero-go]', root);
		var current = $('[data-hero-current]', root);
		var n = slides.length;
		var active = 0;
		var drag = 0;
		var duration = 7000;
		var timer = null;
		var paused = false;
		var startX = 0;
		var startT = 0;
		var dragging = false;
		var width = root.clientWidth;

		root.style.setProperty('--hero-duration', duration + 'ms');

		function wrap(d) {
			if (d > n / 2) { d -= n; }
			if (d < -n / 2) { d += n; }
			return d;
		}

		function layout() {
			width = root.clientWidth;
			var radius = width * 1.05;
			var angle = 2 * Math.atan((width / 2) / radius) * (180 / Math.PI);
			slides.forEach(function (slide, i) {
				var pos = wrap(i - active) + drag;
				var abs = Math.abs(pos);
				slide.style.transformOrigin = '50% 50% ' + (-radius) + 'px';
				slide.style.transform = reduce
					? 'none'
					: 'rotateY(' + (-pos * angle) + 'deg)';
				slide.style.opacity = reduce ? (i === active ? 1 : 0) : clamp(1.25 - abs * 0.55, 0, 1);
				slide.style.zIndex = String(100 - Math.round(abs * 10));
				slide.style.visibility = abs > 1.6 ? 'hidden' : 'visible';
				slide.style.filter = abs > 0.02 ? 'brightness(' + clamp(1 - abs * 0.45, 0.35, 1) + ')' : 'none';
			});
		}

		function go(index, fromUser) {
			active = (index + n) % n;
			drag = 0;
			slides.forEach(function (slide, i) {
				var on = i === active;
				slide.classList.toggle('is-active', on);
				slide.setAttribute('aria-hidden', on ? 'false' : 'true');
				$$('a, button', slide).forEach(function (el) {
					if (on) { el.removeAttribute('tabindex'); } else { el.setAttribute('tabindex', '-1'); }
				});
			});
			thumbs.forEach(function (t, i) {
				t.classList.remove('is-active');
				if (i === active) {
					void t.offsetWidth; // reinicia la animación de la barra
					t.classList.add('is-active');
				}
			});
			if (current) { current.textContent = ('0' + (active + 1)).slice(-2); }
			layout();
			if (fromUser) { restart(); }
		}

		function next() { go(active + 1, true); }
		function prev() { go(active - 1, true); }

		function restart() {
			clearTimeout(timer);
			if (paused || reduce) { return; }
			timer = setTimeout(function () { go(active + 1); restart(); }, duration);
		}

		function setPaused(p) {
			paused = p;
			root.classList.toggle('is-paused', p);
			if (p) { clearTimeout(timer); } else { restart(); }
		}

		var btnNext = $('[data-hero-next]', root);
		var btnPrev = $('[data-hero-prev]', root);
		if (btnNext) { btnNext.addEventListener('click', next); }
		if (btnPrev) { btnPrev.addEventListener('click', prev); }
		thumbs.forEach(function (t) {
			t.addEventListener('click', function () { go(parseInt(t.getAttribute('data-hero-go'), 10), true); });
		});

		root.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowRight') { next(); }
			if (e.key === 'ArrowLeft') { prev(); }
		});
		root.addEventListener('focusin', function () { setPaused(true); });
		root.addEventListener('focusout', function () { setPaused(false); });
		document.addEventListener('visibilitychange', function () { setPaused(document.hidden); });

		// Arrastre / swipe
		stage.addEventListener('pointerdown', function (e) {
			if (e.button !== 0 || e.target.closest('a, button')) { return; }
			dragging = true;
			startX = e.clientX;
			startT = Date.now();
			root.classList.add('is-dragging');
			clearTimeout(timer);
			stage.setPointerCapture(e.pointerId);
		});
		stage.addEventListener('pointermove', function (e) {
			if (!dragging) { return; }
			drag = clamp((e.clientX - startX) / width, -1, 1);
			layout();
		});
		function endDrag() {
			if (!dragging) { return; }
			dragging = false;
			root.classList.remove('is-dragging');
			var fast = Date.now() - startT < 260 && Math.abs(drag) > 0.04;
			if (drag < -0.15 || (fast && drag < 0)) { next(); }
			else if (drag > 0.15 || (fast && drag > 0)) { prev(); }
			else { drag = 0; layout(); restart(); }
		}
		stage.addEventListener('pointerup', endDrag);
		stage.addEventListener('pointercancel', endDrag);

		// Paralaje con el puntero
		if (finePointer && !reduce) {
			var tx = 0, ty = 0, cx = 0, cy = 0, raf = null;
			root.addEventListener('pointermove', function (e) {
				var r = root.getBoundingClientRect();
				tx = ((e.clientX - r.left) / r.width - 0.5) * 2;
				ty = ((e.clientY - r.top) / r.height - 0.5) * 2;
				if (!raf) { raf = requestAnimationFrame(tick); }
			});
			root.addEventListener('pointerleave', function () { tx = 0; ty = 0; if (!raf) { raf = requestAnimationFrame(tick); } });
			var tick = function () {
				cx += (tx - cx) * 0.08;
				cy += (ty - cy) * 0.08;
				root.style.setProperty('--mx', cx.toFixed(4));
				root.style.setProperty('--my', cy.toFixed(4));
				raf = (Math.abs(tx - cx) > 0.001 || Math.abs(ty - cy) > 0.001) ? requestAnimationFrame(tick) : null;
			};
		}

		window.addEventListener('resize', layout);
		go(0);
		restart();
	}
	$$('[data-hero]').forEach(function (el) { new Hero(el); });

	/* ------------------------------------------------------------------
	 * Títulos divididos en líneas para revelado
	 * ------------------------------------------------------------------ */
	function splitLines(el) {
		var text = el.textContent.trim().replace(/\s+/g, ' ');
		if (!text) { return; }
		el.setAttribute('aria-label', text);
		var words = text.split(' ');
		el.innerHTML = words.map(function (w) { return '<span class="sw">' + w.replace(/</g, '&lt;') + '</span>'; }).join(' ');
		var lines = [];
		var lastTop = null;
		$$('.sw', el).forEach(function (s) {
			var top = s.offsetTop;
			if (lastTop === null || Math.abs(top - lastTop) > 4) { lines.push([]); lastTop = top; }
			lines[lines.length - 1].push(s.textContent);
		});
		el.innerHTML = lines.map(function (l, i) {
			return '<span class="split-line" aria-hidden="true" style="--l:' + i + '"><span>' + l.join(' ') + '</span></span>';
		}).join('');
	}
	if (!reduce) {
		var splitTargets = $$('[data-split]');
		var doSplit = function () { splitTargets.forEach(splitLines); };
		if (document.fonts && document.fonts.ready) { document.fonts.ready.then(doSplit); } else { doSplit(); }
	}

	/* ------------------------------------------------------------------
	 * Revelado al entrar en pantalla + contadores
	 * ------------------------------------------------------------------ */
	function countUp(el) {
		var target = parseInt(el.getAttribute('data-count'), 10) || 0;
		if (reduce) { el.textContent = target; return; }
		var t0 = null;
		var dur = 1800;
		function step(t) {
			if (!t0) { t0 = t; }
			var p = clamp((t - t0) / dur, 0, 1);
			el.textContent = Math.round(target * (1 - Math.pow(1 - p, 4)));
			if (p < 1) { requestAnimationFrame(step); }
		}
		requestAnimationFrame(step);
	}

	if ('IntersectionObserver' in window) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) { return; }
				var el = entry.target;
				el.classList.add('is-visible');
				$$('[data-count]', el).forEach(countUp);
				if (el.hasAttribute('data-count')) { countUp(el); }
				io.unobserve(el);
			});
		}, { rootMargin: '0px 0px -10% 0px', threshold: 0.12 });
		$$('[data-reveal], [data-split]').forEach(function (el) { io.observe(el); });
		$$('[data-count]').forEach(function (el) { if (!el.closest('[data-reveal]')) { io.observe(el); } });
	} else {
		$$('[data-reveal], [data-split]').forEach(function (el) { el.classList.add('is-visible'); });
		$$('[data-count]').forEach(countUp);
	}

	/* ------------------------------------------------------------------
	 * Paralaje vertical en fondos
	 * ------------------------------------------------------------------ */
	var parallax = reduce ? [] : $$('[data-parallax]');
	function onScrollParallax() {
		var vh = window.innerHeight;
		var narrow = window.innerWidth < 1020;
		parallax.forEach(function (el) {
			// En pantallas angostas solo se mueven los fondos (no las figuras en flujo).
			if (narrow && !/__bg\b/.test(el.className)) { el.style.transform = ''; return; }
			var host = el.parentElement;
			var r = host.getBoundingClientRect();
			if (r.bottom < -100 || r.top > vh + 100) { return; }
			var speed = parseFloat(el.getAttribute('data-parallax')) || 0.2;
			var offset = (r.top + r.height / 2 - vh / 2) * -speed;
			el.style.transform = 'translate3d(0,' + offset.toFixed(1) + 'px,0)';
		});
	}

	var ticking = false;
	window.addEventListener('scroll', function () {
		if (ticking) { return; }
		ticking = true;
		requestAnimationFrame(function () {
			onScrollHeader();
			onScrollParallax();
			ticking = false;
		});
	}, { passive: true });
	onScrollHeader();
	onScrollParallax();

	/* ------------------------------------------------------------------
	 * Inclinación 3D en tarjetas + brillo que sigue al puntero
	 * ------------------------------------------------------------------ */
	if (finePointer && !reduce) {
		$$('[data-tilt]').forEach(function (card) {
			card.addEventListener('pointermove', function (e) {
				var r = card.getBoundingClientRect();
				var px = (e.clientX - r.left) / r.width;
				var py = (e.clientY - r.top) / r.height;
				card.style.setProperty('--ry', ((px - 0.5) * 10).toFixed(2) + 'deg');
				card.style.setProperty('--rx', ((0.5 - py) * 8).toFixed(2) + 'deg');
				card.style.setProperty('--px', (px * 100).toFixed(1) + '%');
				card.style.setProperty('--py', (py * 100).toFixed(1) + '%');
			});
			card.addEventListener('pointerleave', function () {
				card.style.setProperty('--rx', '0deg');
				card.style.setProperty('--ry', '0deg');
			});
		});

		// Botones magnéticos
		$$('[data-magnetic]').forEach(function (btn) {
			btn.addEventListener('pointermove', function (e) {
				var r = btn.getBoundingClientRect();
				var x = (e.clientX - r.left - r.width / 2) * 0.25;
				var y = (e.clientY - r.top - r.height / 2) * 0.35;
				btn.style.transform = 'translate(' + x.toFixed(1) + 'px,' + y.toFixed(1) + 'px)';
			});
			btn.addEventListener('pointerleave', function () { btn.style.transform = ''; });
		});
	}

	/* ------------------------------------------------------------------
	 * Carril horizontal arrastrable (Ambientes)
	 * ------------------------------------------------------------------ */
	$$('[data-drag-rail]').forEach(function (rail) {
		var down = false, sx = 0, sl = 0, moved = 0;
		rail.addEventListener('pointerdown', function (e) {
			if (e.pointerType !== 'mouse') { return; }
			down = true; moved = 0; sx = e.clientX; sl = rail.scrollLeft;
			rail.classList.add('is-grabbing');
		});
		window.addEventListener('pointermove', function (e) {
			if (!down) { return; }
			var dx = e.clientX - sx;
			moved = Math.max(moved, Math.abs(dx));
			rail.scrollLeft = sl - dx;
		});
		window.addEventListener('pointerup', function () { down = false; rail.classList.remove('is-grabbing'); });
		rail.addEventListener('click', function (e) { if (moved > 6) { e.preventDefault(); } }, true);
		rail.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowRight') { rail.scrollBy({ left: 400, behavior: 'smooth' }); }
			if (e.key === 'ArrowLeft') { rail.scrollBy({ left: -400, behavior: 'smooth' }); }
		});
	});
})();
