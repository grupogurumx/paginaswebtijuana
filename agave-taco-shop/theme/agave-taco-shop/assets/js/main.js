/**
 * Agave Taco Shop — motion layer (vanilla JS, no dependencies).
 *
 * 3D panoramic hero carousel, split-text reveals, scroll reveals, parallax,
 * 3D tilt cards, magnetic buttons, counters, sticky header and mobile nav.
 */
(function () {
	'use strict';

	var doc = document.documentElement;
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
	doc.classList.remove('no-js');

	/* ---------- Preloader ---------- */
	function loaded() { document.body.classList.add('is-loaded'); }
	if (document.readyState === 'complete') { setTimeout(loaded, 250); } else { window.addEventListener('load', function () { setTimeout(loaded, 250); }); }
	setTimeout(loaded, 2500); // never block content.

	/* ---------- Split text into words/chars ---------- */
	function split(el) {
		if (el.dataset.splitDone) { return; }
		var text = el.textContent.trim();
		var i = 0;
		el.setAttribute('aria-label', text);
		el.innerHTML = text.split(/\s+/).map(function (word) {
			var chars = Array.prototype.map.call(word, function (c) {
				return '<span class="char" aria-hidden="true" style="--i:' + (i++) + '">' + c + '</span>';
			}).join('');
			return '<span class="word" aria-hidden="true">' + chars + '</span>';
		}).join(' ');
		el.dataset.splitDone = '1';
	}
	document.querySelectorAll('[data-split], [data-split-hero]').forEach(split);

	/* ---------- Scroll reveals ---------- */
	var revealEls = document.querySelectorAll('[data-reveal], [data-split]');
	if ('IntersectionObserver' in window && !reduce) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-in');
					io.unobserve(entry.target);
				}
			});
		}, { rootMargin: '0px 0px -8% 0px', threshold: 0.12 });
		revealEls.forEach(function (el) { io.observe(el); });
	} else {
		revealEls.forEach(function (el) { el.classList.add('is-in'); });
	}

	/* ---------- Counters ---------- */
	var counters = document.querySelectorAll('[data-count]');
	if ('IntersectionObserver' in window) {
		var co = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) { return; }
				var el = entry.target;
				var end = parseInt(el.dataset.count, 10);
				var suffix = el.dataset.suffix || '';
				var start = null;
				var dur = reduce ? 1 : 1600;
				function step(ts) {
					if (!start) { start = ts; }
					var p = Math.min((ts - start) / dur, 1);
					var eased = 1 - Math.pow(1 - p, 4);
					el.textContent = Math.round(end * eased) + suffix;
					if (p < 1) { requestAnimationFrame(step); }
				}
				requestAnimationFrame(step);
				co.unobserve(el);
			});
		}, { threshold: 0.6 });
		counters.forEach(function (el) { co.observe(el); });
	}

	/* ---------- Header: shrink + hide on scroll down ---------- */
	var header = document.querySelector('[data-header]');
	var sticky = document.querySelector('.sticky-order');
	var lastY = window.scrollY;
	var ticking = false;
	var parallaxEls = Array.prototype.slice.call(document.querySelectorAll('[data-parallax]'));

	function onScroll() {
		var y = window.scrollY;
		if (header) {
			header.classList.toggle('is-scrolled', y > 40);
			header.classList.toggle('is-hidden', y > 500 && y > lastY && !doc.classList.contains('nav-open'));
		}
		if (sticky) { sticky.classList.toggle('is-visible', y > 600); }
		if (!reduce) {
			parallaxEls.forEach(function (el) {
				var root = el.closest('[data-parallax-root]') || el.parentElement;
				var rect = root.getBoundingClientRect();
				if (rect.bottom < 0 || rect.top > window.innerHeight) { return; }
				var speed = parseFloat(el.dataset.parallax) || 0.2;
				var offset = (rect.top + rect.height / 2 - window.innerHeight / 2) * speed;
				el.style.transform = 'translate3d(0,' + offset.toFixed(1) + 'px,0) scale(1.05)';
			});
		}
		lastY = y;
		ticking = false;
	}
	window.addEventListener('scroll', function () {
		if (!ticking) { requestAnimationFrame(onScroll); ticking = true; }
	}, { passive: true });
	onScroll();

	/* ---------- Mobile nav ---------- */
	var burger = document.querySelector('[data-burger]');
	if (burger) {
		burger.addEventListener('click', function () {
			var open = doc.classList.toggle('nav-open');
			burger.setAttribute('aria-expanded', open ? 'true' : 'false');
			burger.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
			document.body.style.overflow = open ? 'hidden' : '';
		});
		document.querySelectorAll('#site-nav a').forEach(function (a) {
			a.addEventListener('click', function () {
				doc.classList.remove('nav-open');
				burger.setAttribute('aria-expanded', 'false');
				document.body.style.overflow = '';
			});
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && doc.classList.contains('nav-open')) { burger.click(); }
		});
	}

	/* ---------- 3D tilt ---------- */
	if (finePointer && !reduce) {
		document.querySelectorAll('[data-tilt]').forEach(function (el) {
			el.addEventListener('pointermove', function (e) {
				var r = el.getBoundingClientRect();
				var x = (e.clientX - r.left) / r.width - 0.5;
				var y = (e.clientY - r.top) / r.height - 0.5;
				el.style.transform = 'perspective(1000px) rotateY(' + (x * 10).toFixed(2) + 'deg) rotateX(' + (-y * 10).toFixed(2) + 'deg) translateZ(0)';
			});
			el.addEventListener('pointerleave', function () { el.style.transform = ''; });
		});

		/* Magnetic buttons */
		document.querySelectorAll('[data-magnetic]').forEach(function (el) {
			el.addEventListener('pointermove', function (e) {
				var r = el.getBoundingClientRect();
				var x = e.clientX - r.left - r.width / 2;
				var y = e.clientY - r.top - r.height / 2;
				el.style.transform = 'translate(' + (x * 0.18).toFixed(1) + 'px,' + (y * 0.3).toFixed(1) + 'px)';
			});
			el.addEventListener('pointerleave', function () { el.style.transform = ''; });
		});

		/* Warm cursor glow */
		var glow = document.querySelector('.cursor-glow');
		if (glow) {
			window.addEventListener('pointermove', function (e) {
				glow.style.left = e.clientX + 'px';
				glow.style.top = e.clientY + 'px';
			}, { passive: true });
		}
	}

	/* ---------- Menu page: active tab while scrolling ---------- */
	var tabs = document.querySelector('[data-menu-tabs]');
	if (tabs && 'IntersectionObserver' in window) {
		var links = tabs.querySelectorAll('a');
		var to = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) { return; }
				links.forEach(function (l) {
					var on = l.getAttribute('href') === '#' + entry.target.id;
					l.classList.toggle('is-active', on);
					if (on && l.scrollIntoView) { l.parentElement.scrollTo({ left: l.offsetLeft - 20, behavior: 'smooth' }); }
				});
			});
		}, { rootMargin: '-45% 0px -50% 0px' });
		document.querySelectorAll('.menu-section').forEach(function (s) { to.observe(s); });
	}

	/* ======================================================================
	   3D panoramic hero carousel
	   ====================================================================== */
	var hero = document.querySelector('[data-hero3d]');
	if (!hero) { return; }

	var stage = hero.querySelector('[data-hero-stage]');
	var slides = Array.prototype.slice.call(hero.querySelectorAll('[data-slide]'));
	var dots = Array.prototype.slice.call(hero.querySelectorAll('[data-hero-dot]'));
	var counter = hero.querySelector('[data-hero-current]');
	var total = slides.length;
	var current = 0;
	var delay = 6500;
	var timer = null;
	var paused = false;
	hero.style.setProperty('--hero-delay', delay + 'ms');

	function offsetOf(i) {
		var d = i - current;
		if (d > total / 2) { d -= total; }
		if (d < -total / 2) { d += total; }
		return d;
	}

	function layout() {
		var wide = window.innerWidth > 960;
		slides.forEach(function (slide, i) {
			var d = offsetOf(i);
			var abs = Math.abs(d);
			slide.classList.toggle('is-active', d === 0);
			slide.classList.toggle('is-prev', d === -1);
			slide.classList.toggle('is-next', d === 1);
			slide.setAttribute('aria-hidden', d === 0 ? 'false' : 'true');
			if (reduce) {
				slide.style.transform = 'none';
				return;
			}
			var x = d * (wide ? 64 : 85);
			var z = -abs * (wide ? 560 : 420);
			var ry = -d * (wide ? 38 : 30);
			if (abs > 1) {
				x = d * 95;
				z = -1100;
				ry = -d * 55;
			}
			slide.style.transform = 'translate3d(' + x + '%,0,' + z + 'px) rotateY(' + ry + 'deg)';
			slide.style.zIndex = String(10 - abs);
		});
		dots.forEach(function (dot, i) {
			dot.classList.toggle('is-active', i === current);
			dot.classList.toggle('is-done', i < current);
			dot.setAttribute('aria-selected', i === current ? 'true' : 'false');
			// restart progress animation
			var bar = dot.querySelector('span');
			if (bar && i === current) { bar.style.animation = 'none'; void bar.offsetWidth; bar.style.animation = ''; }
		});
		if (counter) { counter.textContent = (current + 1 < 10 ? '0' : '') + (current + 1); }
	}

	function go(i) {
		current = (i + total) % total;
		layout();
		restart();
	}
	function next() { go(current + 1); }
	function prev() { go(current - 1); }

	function restart() {
		clearTimeout(timer);
		if (!paused && !reduce) { timer = setTimeout(next, delay); }
	}
	function pause(state) {
		paused = state;
		hero.classList.toggle('is-paused', state);
		restart();
	}

	hero.querySelector('[data-hero-next]').addEventListener('click', next);
	hero.querySelector('[data-hero-prev]').addEventListener('click', prev);
	dots.forEach(function (dot) {
		dot.addEventListener('click', function () { go(parseInt(dot.dataset.heroDot, 10)); });
	});
	slides.forEach(function (slide, i) {
		slide.addEventListener('click', function (e) {
			if (i !== current && !e.target.closest('a')) { go(i); }
		});
	});

	hero.addEventListener('keydown', function (e) {
		if (e.key === 'ArrowRight') { next(); }
		if (e.key === 'ArrowLeft') { prev(); }
	});
	hero.setAttribute('tabindex', '0');

	hero.addEventListener('focusin', function () { pause(true); });
	hero.addEventListener('focusout', function () { pause(false); });
	document.addEventListener('visibilitychange', function () { pause(document.hidden); });

	/* Swipe / drag */
	var startX = null;
	var startY = null;
	hero.addEventListener('pointerdown', function (e) { startX = e.clientX; startY = e.clientY; }, { passive: true });
	hero.addEventListener('pointerup', function (e) {
		if (startX === null) { return; }
		var dx = e.clientX - startX;
		var dy = e.clientY - startY;
		if (Math.abs(dx) > 50 && Math.abs(dx) > Math.abs(dy)) { if (dx < 0) { next(); } else { prev(); } }
		startX = null;
	});
	hero.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; startY = e.touches[0].clientY; }, { passive: true });
	hero.addEventListener('touchend', function (e) {
		if (startX === null) { return; }
		var t = e.changedTouches[0];
		var dx = t.clientX - startX;
		var dy = t.clientY - startY;
		if (Math.abs(dx) > 50 && Math.abs(dx) > Math.abs(dy)) { if (dx < 0) { next(); } else { prev(); } }
		startX = null;
	}, { passive: true });

	/* Mouse-driven 3D depth: the whole stage pivots, layers drift by depth */
	if (finePointer && !reduce) {
		var depthEls = Array.prototype.slice.call(hero.querySelectorAll('[data-depth]'));
		var tx = 0, ty = 0, cx = 0, cy = 0, raf = null;
		hero.addEventListener('pointermove', function (e) {
			var r = hero.getBoundingClientRect();
			tx = (e.clientX - r.left) / r.width - 0.5;
			ty = (e.clientY - r.top) / r.height - 0.5;
			if (!raf) { raf = requestAnimationFrame(animate); }
		});
		hero.addEventListener('pointerleave', function () { tx = 0; ty = 0; if (!raf) { raf = requestAnimationFrame(animate); } });
		function animate() {
			cx += (tx - cx) * 0.08;
			cy += (ty - cy) * 0.08;
			stage.style.transform = 'rotateY(' + (cx * 5).toFixed(3) + 'deg) rotateX(' + (-cy * 3).toFixed(3) + 'deg)';
			depthEls.forEach(function (el) {
				var depth = parseFloat(el.dataset.depth) || 0;
				el.style.transform = 'translate3d(' + (cx * depth * 40).toFixed(2) + 'px,' + (cy * depth * 30).toFixed(2) + 'px,0)';
			});
			if (Math.abs(tx - cx) > 0.001 || Math.abs(ty - cy) > 0.001) { raf = requestAnimationFrame(animate); } else { raf = null; }
		}
	}

	window.addEventListener('resize', layout);
	layout();
	restart();
}());
