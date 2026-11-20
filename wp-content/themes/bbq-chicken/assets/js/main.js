/* bb.q Chicken Europe — shared behaviour (no dependencies) */
(function () {
  'use strict';

  var doc = document;
  var body = doc.body;
  var mqMobile = window.matchMedia('(max-width: 767px)');

  /* ---------- Header shadow on scroll ---------- */
  var header = doc.querySelector('[data-header]');
  function onScroll() {
    if (header) header.classList.toggle('is-scrolled', window.scrollY > 40);
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* ---------- Dropdowns (nav + order menu) ---------- */
  var dropdowns = Array.prototype.slice.call(doc.querySelectorAll('[data-dropdown]'));
  function closeAll(except) {
    dropdowns.forEach(function (dd) {
      if (dd === except) return;
      dd.classList.remove('is-open');
      var b = dd.querySelector('[aria-expanded]');
      if (b) b.setAttribute('aria-expanded', 'false');
    });
  }
  dropdowns.forEach(function (dd) {
    var btn = dd.querySelector('button[aria-expanded]');
    if (!btn) return;
    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      var open = !dd.classList.contains('is-open');
      closeAll(dd);
      dd.classList.toggle('is-open', open);
      btn.setAttribute('aria-expanded', String(open));
    });
  });
  doc.addEventListener('click', function (e) {
    if (!e.target.closest('[data-dropdown]')) closeAll();
  });
  doc.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { closeAll(); setMenu(false); }
  });

  /* ---------- Mobile / tablet menu ---------- */
  var burger = doc.querySelector('[data-burger]');
  function setMenu(open) {
    body.classList.toggle('nav-open', open);
    if (burger) {
      burger.setAttribute('aria-expanded', String(open));
      burger.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
    }
  }
  if (burger) {
    burger.addEventListener('click', function () { setMenu(!body.classList.contains('nav-open')); });
    doc.querySelectorAll('.mobile-menu a').forEach(function (a) {
      a.addEventListener('click', function () { setMenu(false); });
    });
  }

  /* Expandable items in the mobile menu (Discover bb.q, Franchise) */
  doc.querySelectorAll('[data-mnav]').forEach(function (item) {
    var btn = item.querySelector('button');
    btn.addEventListener('click', function () {
      var open = !item.classList.contains('is-open');
      item.classList.toggle('is-open', open);
      btn.setAttribute('aria-expanded', String(open));
    });
  });

  /* ---------- Marquees: duplicate content for a seamless loop ---------- */
  doc.querySelectorAll('[data-marquee]').forEach(function (track) {
    var html = track.innerHTML;
    var copies = 4; // enough to cover very wide screens
    var out = '';
    for (var i = 0; i < copies; i++) out += html;
    track.innerHTML = out + out; // animation moves by exactly half the track
    var seconds = Math.max(20, track.scrollWidth / 2 / 60); // ~60px per second
    track.style.animationDuration = seconds + 's';
  });

  /* ---------- Card sliders ----------
     [data-slider]       one row of cards with arrows and dots. Desktop centres the active card,
                         mobile lines it up on the left edge. Arrows dim at either end.
     [data-slider-loop]  endless row (home food cards): the set is repeated on both sides,
                         so the arrows never run out; clicking a side card brings it to the middle.
     Mouse users can also drag the row left or right. */
  var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  doc.querySelectorAll('[data-slider]').forEach(function (slider) {
    var viewport = slider.querySelector('[data-slider-viewport]');
    if (!viewport) return;
    var loop = slider.hasAttribute('data-slider-loop');
    var real = Array.prototype.slice.call(viewport.children).filter(function (c) {
      return getComputedStyle(c).display !== 'none';
    });
    var n = real.length;
    if (!n) return;
    var SETS = loop ? 9 : 1, MID = loop ? 4 : 0; // 9 copies of the set, start in the middle one
    var cards = real;
    if (loop) {
      var before = doc.createDocumentFragment(), after = doc.createDocumentFragment();
      cards = [];
      for (var s = 0; s < SETS; s++) {
        real.forEach(function (c) {
          if (s === MID) { cards.push(c); return; }
          var copy = c.cloneNode(true);
          copy.setAttribute('aria-hidden', 'true');
          copy.querySelectorAll('a, button').forEach(function (el) { el.tabIndex = -1; });
          (s < MID ? before : after).appendChild(copy);
          cards.push(copy);
        });
      }
      viewport.insertBefore(before, viewport.firstChild);
      viewport.appendChild(after);
    }
    cards.forEach(function (c) { c.querySelectorAll('img').forEach(function (img) { img.draggable = false; }); });

    var dotsWrap = slider.querySelector('[data-slider-dots]');
    var prev = slider.querySelector('[data-slider-prev]');
    var next = slider.querySelector('[data-slider-next]');
    var startAttr = mqMobile.matches && slider.hasAttribute('data-start-mobile') ? 'data-start-mobile' : 'data-start';
    var active = MID * n + Math.min(Number(slider.getAttribute(startAttr) || 0), n - 1);
    var dots = [];

    if (dotsWrap) {
      real.forEach(function (_, i) {
        var d = doc.createElement('button');
        d.type = 'button';
        d.className = 'slider__dot';
        d.setAttribute('aria-label', 'Show card ' + (i + 1) + ' of ' + n);
        d.addEventListener('click', function () { go(active - (active % n) + i); });
        dotsWrap.appendChild(d);
        dots.push(d);
      });
    }

    function maxScroll() { return viewport.scrollWidth - viewport.clientWidth; }
    function updateArrows() {
      // endless row: on mobile the back arrow fades on the first card of the set, as in the design
      if (loop) { if (prev) prev.classList.toggle('is-dim', mqMobile.matches && active % n === 0); return; }
      if (prev) prev.disabled = active <= 0 && viewport.scrollLeft <= 2;
      if (next) next.disabled = active >= cards.length - 1 || viewport.scrollLeft >= maxScroll() - 2;
    }
    function setActive(i) {
      active = i;
      cards.forEach(function (c, k) { c.classList.toggle('is-active', k === i); });
      dots.forEach(function (d, k) { d.classList.toggle('is-active', k === i % n); });
      updateArrows();
    }
    function go(i, instant) {
      i = Math.max(0, Math.min(cards.length - 1, i));
      setActive(i);
      var card = cards[i];
      var target = mqMobile.matches
        ? card.offsetLeft - viewport.offsetLeft - 20
        : card.offsetLeft - viewport.offsetLeft - (viewport.clientWidth - card.offsetWidth) / 2;
      viewport.scrollTo({ left: target, behavior: instant || reducedMotion ? 'auto' : 'smooth' });
    }

    var raf = null;
    viewport.addEventListener('scroll', function () {
      if (raf) cancelAnimationFrame(raf);
      raf = requestAnimationFrame(function () {
        var anchor = mqMobile.matches
          ? viewport.scrollLeft + 20
          : viewport.scrollLeft + viewport.clientWidth / 2;
        var best = active, bestDist = Infinity;
        cards.forEach(function (c, k) {
          var pos = mqMobile.matches ? c.offsetLeft - viewport.offsetLeft : c.offsetLeft - viewport.offsetLeft + c.offsetWidth / 2;
          var dist = Math.abs(pos - anchor);
          if (dist < bestDist) { bestDist = dist; best = k; }
        });
        if (best !== active) setActive(best); else updateArrows();
      });
    }, { passive: true });

    if (prev) prev.addEventListener('click', function () { go(active - 1); });
    if (next) next.addEventListener('click', function () { go(active + 1); });

    // drag with the mouse (touch already scrolls natively): a flick of 40px+ moves one card,
    // a long drag moves one card per 400px
    var dragX = null, dragged = false;
    viewport.addEventListener('pointerdown', function (e) {
      if (e.pointerType !== 'mouse' || e.button !== 0 || maxScroll() <= 2) return;
      dragX = e.clientX; dragged = false;
    });
    window.addEventListener('pointerup', function (e) {
      if (dragX === null) return;
      var dx = e.clientX - dragX;
      dragX = null;
      if (Math.abs(dx) > 40) {
        dragged = true;
        go(active + (dx < 0 ? 1 : -1) * Math.max(1, Math.round(Math.abs(dx) / 400)));
      }
    });
    viewport.addEventListener('click', function (e) {
      if (dragged) { e.preventDefault(); e.stopPropagation(); dragged = false; return; }
      if (!loop) return;
      var card = e.target.closest('[data-slider-viewport] > *');
      var k = cards.indexOf(card);
      if (k > -1 && k !== active) { e.preventDefault(); go(k); }
    }, true);

    setActive(active);
    // wait for layout (fonts/images) before centring the starting card
    window.addEventListener('load', function () { go(active, true); });
    window.addEventListener('resize', function () { go(active, true); });
    go(active, true);
  });

  /* ---------- Footer accordions (mobile) ---------- */
  doc.querySelectorAll('[data-accordion]').forEach(function (col) {
    var head = col.querySelector('.footer-col__head');
    if (!head) return;
    head.addEventListener('click', function () {
      if (!mqMobile.matches) return;
      var open = !col.classList.contains('is-open');
      col.classList.toggle('is-open', open);
      head.setAttribute('aria-expanded', String(open));
    });
  });

  /* ---------- Postcode check (placeholder behaviour) ---------- */
  doc.querySelectorAll('[data-postcode]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var input = form.querySelector('input');
      if (!input.value.trim()) { input.focus(); return; }
      var note = form.parentNode.querySelector('.postcode-result');
      if (!note) {
        note = doc.createElement('p');
        note.className = 'postcode-result';
        note.setAttribute('role', 'status');
        form.insertAdjacentElement('afterend', note);
      }
      note.textContent = 'Thanks! Delivery checking for "' + input.value.trim() + '" will be connected once the kitchens are live. [To be connected]';
    });
  });

  /* ---------- Generic forms (placeholder submit until a backend is connected) ---------- */
  doc.querySelectorAll('form[data-form]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!form.reportValidity()) return;
      var next = form.getAttribute('data-success-url');
      if (next) { window.location.href = next; return; }
      var status = form.querySelector('.form-status');
      if (!status) {
        status = doc.createElement('p');
        status.className = 'form-status';
        status.setAttribute('role', 'status');
        form.appendChild(status);
      }
      status.textContent = form.getAttribute('data-success') || 'Thank you! Your message has been received. [Form handling to be connected]';
    });
  });

  /* ---------- File upload fields: show the chosen file name ---------- */
  doc.querySelectorAll('[data-dropzone]').forEach(function (zone) {
    var input = zone.querySelector('input[type="file"]');
    var title = zone.querySelector('.dropzone__title');
    if (!input || !title) return;
    var original = title.innerHTML;
    function update() {
      var files = Array.prototype.map.call(input.files || [], function (f) { return f.name; });
      zone.classList.toggle('has-file', files.length > 0);
      title.textContent = files.length ? '✓ ' + files.join(', ') : '';
      if (!files.length) title.innerHTML = original;
    }
    input.addEventListener('change', update);
    // Forms are reset after a successful submission (e.g. by Contact Form 7): show the prompt again.
    if (input.form) input.form.addEventListener('reset', function () { setTimeout(update, 0); });
    ['dragenter', 'dragover'].forEach(function (t) { zone.addEventListener(t, function () { zone.classList.add('is-dragover'); }); });
    ['dragleave', 'drop'].forEach(function (t) { zone.addEventListener(t, function () { zone.classList.remove('is-dragover'); }); });
  });

  /* ---------- Swipe rows ----------
     [data-carousel] with [data-carousel-viewport], -prev, -next, -dots and -nav: a scroll row lined up
     on the left, one dot per stop, no wrap-around, arrows dim at either end, nav hidden when it all fits.
     (Home brand cards, reasons and news.) */
  doc.querySelectorAll('[data-carousel]').forEach(function (root) {
    var vp = root.querySelector('[data-carousel-viewport]');
    var nav = root.querySelector('[data-carousel-nav]');
    var dotsWrap = root.querySelector('[data-carousel-dots]');
    var prev = root.querySelector('[data-carousel-prev]');
    var next = root.querySelector('[data-carousel-next]');
    if (!vp) return;
    var stops = [0], dots = [], active = 0, timer = 0;

    function measure() {
      var max = vp.scrollWidth - vp.clientWidth;
      var pad = parseFloat(getComputedStyle(vp).scrollPaddingLeft) || 0;
      var origin = vp.getBoundingClientRect().left - vp.scrollLeft;
      stops = [];
      Array.prototype.forEach.call(vp.children, function (item) {
        if (!item.offsetWidth) return;
        var x = Math.max(0, Math.min(max, Math.round(item.getBoundingClientRect().left - origin - pad)));
        if (!stops.length || x - stops[stops.length - 1] > 2) stops.push(x);
      });
      if (max <= 2 || !stops.length) stops = [0];
      if (nav) nav.hidden = stops.length < 2;
      if (dotsWrap) {
        dotsWrap.innerHTML = '';
        dots = stops.map(function (_, i) {
          var d = doc.createElement('button');
          d.type = 'button';
          d.className = 'slider__dot';
          d.setAttribute('aria-label', 'Go to position ' + (i + 1) + ' of ' + stops.length);
          d.addEventListener('click', function () { go(i); });
          dotsWrap.appendChild(d);
          return d;
        });
      }
      update();
    }
    function update() {
      var x = vp.scrollLeft;
      active = 0;
      stops.forEach(function (s, i) { if (Math.abs(s - x) < Math.abs(stops[active] - x)) active = i; });
      dots.forEach(function (d, i) { d.classList.toggle('is-active', i === active); });
      if (prev) prev.disabled = active === 0;
      if (next) next.disabled = active === stops.length - 1;
    }
    function go(i) {
      i = Math.max(0, Math.min(stops.length - 1, i));
      vp.scrollTo({ left: stops[i], behavior: reducedMotion ? 'auto' : 'smooth' });
    }
    if (prev) prev.addEventListener('click', function () { go(active - 1); });
    if (next) next.addEventListener('click', function () { go(active + 1); });
    vp.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', function () { clearTimeout(timer); timer = setTimeout(measure, 150); });
    window.addEventListener('load', measure);
    measure();
  });

  /* ---------- Placeholder links (href="#") don't jump to the top ---------- */
  doc.addEventListener('click', function (e) {
    var a = e.target.closest('a[href="#"]');
    if (a) e.preventDefault();
  });
})();
