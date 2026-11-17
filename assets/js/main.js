/* bb.q Chicken Europe — shared behaviour (no dependencies) */
(function () {
  'use strict';

  var doc = document;
  var body = doc.body;
  var mqMobile = window.matchMedia('(max-width: 767px)');

  /* ---------- Header shadow on scroll ---------- */
  var header = doc.querySelector('[data-header]');
  function onScroll() {
    if (header) header.classList.toggle('is-scrolled', window.scrollY > 8);
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

  /* ---------- Card slider (home food cards) ---------- */
  doc.querySelectorAll('[data-slider]').forEach(function (slider) {
    var viewport = slider.querySelector('[data-slider-viewport]');
    var cards = Array.prototype.slice.call(viewport.children).filter(function (c) {
      return getComputedStyle(c).display !== 'none';
    });
    var dotsWrap = slider.querySelector('[data-slider-dots]');
    var startAttr = mqMobile.matches && slider.hasAttribute('data-start-mobile') ? 'data-start-mobile' : 'data-start';
    var active = Math.min(Number(slider.getAttribute(startAttr) || 0), cards.length - 1);
    var dots = [];

    if (dotsWrap) {
      cards.forEach(function (_, i) {
        var d = doc.createElement('button');
        d.type = 'button';
        d.className = 'slider__dot';
        d.setAttribute('aria-label', 'Show card ' + (i + 1));
        d.addEventListener('click', function () { go(i); });
        dotsWrap.appendChild(d);
        dots.push(d);
      });
    }

    function setActive(i) {
      active = i;
      cards.forEach(function (c, k) { c.classList.toggle('is-active', k === i); });
      dots.forEach(function (d, k) { d.classList.toggle('is-active', k === i); });
    }

    function go(i, instant) {
      i = (i + cards.length) % cards.length;
      setActive(i);
      var card = cards[i];
      var target = mqMobile.matches
        ? card.offsetLeft - viewport.offsetLeft - 20
        : card.offsetLeft - viewport.offsetLeft - (viewport.clientWidth - card.offsetWidth) / 2;
      viewport.scrollTo({ left: target, behavior: instant ? 'auto' : 'smooth' });
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
        if (best !== active) setActive(best);
      });
    }, { passive: true });

    var prev = slider.querySelector('[data-slider-prev]');
    var next = slider.querySelector('[data-slider-next]');
    if (prev) prev.addEventListener('click', function () { go(active - 1); });
    if (next) next.addEventListener('click', function () { go(active + 1); });

    setActive(active);
    // wait for layout (fonts/images) before centring the starting card
    window.addEventListener('load', function () { go(active, true); });
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
    input.addEventListener('change', function () {
      var files = Array.prototype.map.call(input.files || [], function (f) { return f.name; });
      zone.classList.toggle('has-file', files.length > 0);
      title.textContent = files.length ? '✓ ' + files.join(', ') : '';
      if (!files.length) title.innerHTML = original;
    });
    ['dragenter', 'dragover'].forEach(function (t) { zone.addEventListener(t, function () { zone.classList.add('is-dragover'); }); });
    ['dragleave', 'drop'].forEach(function (t) { zone.addEventListener(t, function () { zone.classList.remove('is-dragover'); }); });
  });

  /* ---------- Floating CTA: hide while another apply button is in view ---------- */
  var floating = doc.querySelector('[data-floating-cta]');
  var hiders = doc.querySelectorAll('[data-hides-floating], .site-footer');
  if (floating && hiders.length && 'IntersectionObserver' in window) {
    var visible = new Set();
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) { if (en.isIntersecting) visible.add(en.target); else visible.delete(en.target); });
      floating.classList.toggle('is-hidden', visible.size > 0);
    }, { threshold: 0.01 });
    hiders.forEach(function (el) { io.observe(el); });
  }
})();
