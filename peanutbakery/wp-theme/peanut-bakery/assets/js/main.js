/**
 * Peanut Bakery 2.0 — interacciones y motion.
 * Sin dependencias. Respeta prefers-reduced-motion.
 */
(function () {
	'use strict';

	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
	var $ = function (s, c) { return (c || document).querySelector(s); };
	var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

	/* ---------- Header con sombra al hacer scroll ---------- */
	var header = $('[data-header]');
	if (header) {
		var onScroll = function () { header.classList.toggle('is-scrolled', window.scrollY > 10); };
		onScroll();
		window.addEventListener('scroll', onScroll, { passive: true });
	}

	/* ---------- Menú móvil ---------- */
	var burger = $('[data-burger]');
	var nav = $('[data-nav]');
	if (burger && nav) {
		var toggle = function (open) {
			burger.setAttribute('aria-expanded', open ? 'true' : 'false');
			nav.classList.toggle('is-open', open);
			document.body.style.overflow = open ? 'hidden' : '';
		};
		burger.addEventListener('click', function () { toggle(burger.getAttribute('aria-expanded') !== 'true'); });
		$$('a', nav).forEach(function (a) { a.addEventListener('click', function () { toggle(false); }); });
		document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { toggle(false); } });
	}

	/* ==========================================================
	   Slider panorámico 3D: las caras forman un cilindro y el
	   anillo gira en Y. Durante el giro el escenario se aleja
	   (zoom-out) para revelar la profundidad.
	   ========================================================== */
	var hero = $('[data-hero]');
	if (hero) {
		var stage = $('[data-stage]', hero);
		var ring = $('[data-ring]', hero);
		var faces = $$('[data-face]', hero);
		var texts = $$('[data-text]', hero);
		var dots = $$('[data-dot]', hero);
		var current = $('[data-current]', hero);
		var n = faces.length;
		var pos = 0;
		var delay = 7000;
		var timer = null;
		var angle = 360 / n;
		var radius = 0;

		hero.style.setProperty('--hero-delay', delay + 'ms');

		var layout = function () {
			var w = stage.offsetWidth;
			radius = n > 2 ? Math.round((w / 2) / Math.tan(Math.PI / n)) : w / 2;
			faces.forEach(function (f, i) {
				f.style.transform = 'rotateY(' + (i * angle) + 'deg) translateZ(' + radius + 'px)';
			});
			ring.style.transition = 'none';
			setRing();
			// Fuerza reflow para que la siguiente transición sí anime.
			void ring.offsetWidth;
			ring.style.transition = '';
		};

		var setRing = function () {
			ring.style.transform = 'translateZ(' + (-radius) + 'px) rotateY(' + (-pos * angle) + 'deg)';
		};

		var index = function () { return ((pos % n) + n) % n; };

		var render = function () {
			var i = index();
			faces.forEach(function (f, k) {
				f.classList.toggle('is-active', k === i);
				f.setAttribute('aria-hidden', k === i ? 'false' : 'true');
			});
			texts.forEach(function (t, k) { t.classList.toggle('is-active', k === i); });
			dots.forEach(function (d, k) {
				d.classList.remove('is-active');
				if (k === i) { void d.offsetWidth; d.classList.add('is-active'); }
				d.setAttribute('aria-selected', k === i ? 'true' : 'false');
			});
			if (current) { current.textContent = (i + 1 < 10 ? '0' : '') + (i + 1); }
		};

		var go = function (step) {
			if (!reduce) {
				hero.classList.add('is-moving');
				setTimeout(function () { hero.classList.remove('is-moving'); }, 650);
			}
			pos += step;
			setRing();
			render();
			restart();
		};

		var goTo = function (i) {
			var diff = i - index();
			if (diff > n / 2) { diff -= n; }
			if (diff < -n / 2) { diff += n; }
			if (diff) { go(diff); }
		};

		var restart = function () {
			clearInterval(timer);
			if (!hero.classList.contains('is-paused')) {
				timer = setInterval(function () { go(1); }, delay);
			}
		};

		var pause = function (p) {
			hero.classList.toggle('is-paused', p);
			if (p) { clearInterval(timer); } else { restart(); }
		};

		$('[data-next]', hero).addEventListener('click', function () { go(1); });
		$('[data-prev]', hero).addEventListener('click', function () { go(-1); });
		dots.forEach(function (d) {
			d.addEventListener('click', function () { goTo(parseInt(d.getAttribute('data-dot'), 10)); });
		});

		hero.addEventListener('mouseenter', function () { pause(true); });
		hero.addEventListener('mouseleave', function () { pause(false); });
		hero.addEventListener('focusin', function () { pause(true); });
		hero.addEventListener('focusout', function () { pause(false); });
		document.addEventListener('visibilitychange', function () { pause(document.hidden); });
		hero.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowRight') { go(1); }
			if (e.key === 'ArrowLeft') { go(-1); }
		});

		// Swipe táctil / arrastre.
		var startX = null;
		hero.addEventListener('pointerdown', function (e) { startX = e.clientX; });
		hero.addEventListener('pointerup', function (e) {
			if (startX === null) { return; }
			var dx = e.clientX - startX;
			if (Math.abs(dx) > 50) { go(dx < 0 ? 1 : -1); }
			startX = null;
		});

		// Parallax de profundidad con el mouse.
		if (finePointer && !reduce) {
			hero.addEventListener('mousemove', function (e) {
				var r = hero.getBoundingClientRect();
				var x = (e.clientX - r.left) / r.width - 0.5;
				var y = (e.clientY - r.top) / r.height - 0.5;
				var media = $('.hero__face.is-active .hero__media', hero);
				if (media) {
					var d = parseFloat(media.getAttribute('data-depth')) || 15;
					media.style.transform = 'translate3d(' + (-x * d) + 'px,' + (-y * d) + 'px,0)';
				}
			});
		}

		window.addEventListener('resize', layout);
		layout();
		render();
		restart();
	}

	/* ---------- Revelado al hacer scroll ---------- */
	var revealEls = $$('.reveal, [data-process]');
	if ('IntersectionObserver' in window && !reduce) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (en) {
				if (en.isIntersecting) {
					en.target.classList.add('is-in');
					io.unobserve(en.target);
				}
			});
		}, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
		revealEls.forEach(function (el) { io.observe(el); });
	} else {
		revealEls.forEach(function (el) { el.classList.add('is-in'); });
	}

	/* ---------- Contadores animados ---------- */
	var counters = $$('[data-count]');
	var runCounter = function (el) {
		var target = parseInt(el.getAttribute('data-count'), 10);
		var suffix = el.getAttribute('data-suffix') || '';
		if (reduce) { el.textContent = target + suffix; return; }
		var t0 = null;
		var step = function (t) {
			if (!t0) { t0 = t; }
			var p = Math.min((t - t0) / 1600, 1);
			el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3))) + suffix;
			if (p < 1) { requestAnimationFrame(step); }
		};
		requestAnimationFrame(step);
	};
	if ('IntersectionObserver' in window) {
		var cio = new IntersectionObserver(function (entries) {
			entries.forEach(function (en) {
				if (en.isIntersecting) { runCounter(en.target); cio.unobserve(en.target); }
			});
		}, { threshold: 0.6 });
		counters.forEach(function (c) { cio.observe(c); });
	} else {
		counters.forEach(runCounter);
	}

	/* ---------- Tarjetas con inclinación 3D ---------- */
	if (finePointer && !reduce) {
		$$('[data-tilt]').forEach(function (card) {
			card.addEventListener('mousemove', function (e) {
				var r = card.getBoundingClientRect();
				var x = (e.clientX - r.left) / r.width - 0.5;
				var y = (e.clientY - r.top) / r.height - 0.5;
				card.style.transform = 'perspective(1000px) rotateY(' + (x * 8) + 'deg) rotateX(' + (-y * 8) + 'deg) translateZ(0)';
			});
			card.addEventListener('mouseleave', function () { card.style.transform = ''; });
		});
	}

	/* ---------- Parallax de encabezados ---------- */
	var parallax = $$('[data-parallax]');
	if (parallax.length && !reduce) {
		var ticking = false;
		var update = function () {
			parallax.forEach(function (el) {
				var wrap = el.closest('[data-parallax-wrap]') || el.parentElement;
				var r = wrap.getBoundingClientRect();
				if (r.bottom < 0 || r.top > window.innerHeight) { return; }
				var speed = parseFloat(el.getAttribute('data-parallax')) || 0.2;
				el.style.transform = 'translate3d(0,' + (r.top * -speed) + 'px,0)';
			});
			ticking = false;
		};
		window.addEventListener('scroll', function () {
			if (!ticking) { requestAnimationFrame(update); ticking = true; }
		}, { passive: true });
		update();
	}

	/* ---------- Galería con filtros ---------- */
	var filters = $('[data-filters]');
	var gallery = $('[data-gallery]');
	if (filters && gallery) {
		filters.addEventListener('click', function (e) {
			var btn = e.target.closest('[data-filter]');
			if (!btn) { return; }
			var f = btn.getAttribute('data-filter');
			$$('[data-filter]', filters).forEach(function (b) { b.classList.toggle('is-active', b === btn); });
			$$('.gallery__item', gallery).forEach(function (it) {
				it.classList.toggle('is-hidden', f !== '*' && it.getAttribute('data-cat') !== f);
			});
		});
	}

	/* ---------- Sub-navegación activa en Productos ---------- */
	var subnav = $('[data-subnav]');
	if (subnav && 'IntersectionObserver' in window) {
		var links = $$('a', subnav);
		var sio = new IntersectionObserver(function (entries) {
			entries.forEach(function (en) {
				if (en.isIntersecting) {
					links.forEach(function (a) {
						var on = a.getAttribute('href') === '#' + en.target.id;
						a.classList.toggle('is-active', on);
						if (on && a.scrollIntoView) { a.parentElement.scrollLeft = a.offsetLeft - 16; }
					});
				}
			});
		}, { rootMargin: '-45% 0px -50% 0px' });
		links.forEach(function (a) {
			var sec = document.getElementById(a.getAttribute('href').slice(1));
			if (sec) { sio.observe(sec); }
		});
	}

	/* ---------- Formulario → WhatsApp ---------- */
	$$('[data-form-wa]').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var form = btn.closest('form');
			if (!form.reportValidity()) { return; }
			var val = function (n) { var el = form.elements[n]; return el ? el.value.trim() : ''; };
			var msg = 'Hola Peanut Bakery 👋\n' +
				'Nombre: ' + val('pb_name') + '\n' +
				'Teléfono: ' + val('pb_phone') + '\n' +
				(val('pb_email') ? 'Correo: ' + val('pb_email') + '\n' : '') +
				(val('pb_business') ? 'Negocio/Motivo: ' + val('pb_business') + '\n' : '') +
				'\n' + val('pb_message');
			window.open('https://wa.me/' + form.getAttribute('data-wa') + '?text=' + encodeURIComponent(msg), '_blank', 'noopener');
		});
	});

	/* ---------- Botón flotante: muestra la etiqueta unos segundos ---------- */
	var wa = $('.wa-float');
	if (wa && !reduce) {
		setTimeout(function () {
			wa.classList.add('is-peek');
			setTimeout(function () { wa.classList.remove('is-peek'); }, 4000);
		}, 3500);
	}
})();
