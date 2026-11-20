/* bb.q Chicken Europe — motion (matched to the Studio Ubique prototype).
   Scroll reveals, count-up numbers, cut-out parallax, rising steam.
   Works on every page: it looks for known blocks and also honours
   [data-reveal], [data-reveal-group], [data-count] and [data-par] in the markup. */
(function () {
  'use strict';
  var doc = document;
  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var $$ = function (sel, root) { return Array.prototype.slice.call((root || doc).querySelectorAll(sel)); };

  /* ---------- Steam: wisps of noise that rise above hot food ---------- */
  if (!reduced) {
    var texture = function (w, h, fx, fy, seed, k, t) {
      var svg = '<svg xmlns="http://www.w3.org/2000/svg" width="' + w + '" height="' + h + '">' +
        '<filter id="f" x="0" y="0" width="100%" height="100%">' +
        '<feTurbulence type="fractalNoise" baseFrequency="' + fx + ' ' + fy + '" numOctaves="3" seed="' + seed + '" stitchTiles="stitch"/>' +
        '<feColorMatrix type="matrix" values="0 0 0 0 1  0 0 0 0 1  0 0 0 0 1  ' + k + ' 0 0 0 ' + t + '"/></filter>' +
        '<rect width="100%" height="100%" filter="url(#f)"/></svg>';
      return 'url("data:image/svg+xml,' + encodeURIComponent(svg) + '")';
    };
    doc.documentElement.style.setProperty('--steam-1', texture(360, 720, 0.0139, 0.0083, 3, 3.6, -1.95));
    doc.documentElement.style.setProperty('--steam-2', texture(240, 720, 0.0208, 0.0111, 11, 3.6, -1.98));
    var steamTargets = $$('.hero .cutout, .hero [data-steam], .why .cutout--cheesling, .closing .cutout--fried, [data-steam]');
    steamTargets.forEach(function (el) {
      if (el.querySelector('.steam')) return;
      var s = doc.createElement('div');
      s.className = 'steam';
      s.setAttribute('aria-hidden', 'true');
      s.innerHTML = '<i></i><i></i>';
      el.insertBefore(s, el.firstChild);
    });
  }

  /* ---------- Scroll reveal ---------- */
  // single blocks
  var singles = [
    '.intro__text', '.intro__brands', '.food__head', '.find__text', '.map-card',
    '.markets .section-head', '.markets__text', '.europe-card', '.why .section-head',
    '.mascot__img', '.mascot__text', '.team__img', '.team__text', '.news__head',
    '.cta-card', '.order-bar', '.footer-brand',
    'main .section-head', 'main .form-card', '[data-reveal]'
  ];
  // groups whose children appear one after another
  var groups = ['.reasons', '.news__list', '.news__track', '.proof__items', '[data-reveal-group]'];

  if (!reduced && 'IntersectionObserver' in window) {
    var finish = function (el) {
      // once shown, hand the element back to its own transitions (hover lifts etc.)
      setTimeout(function () { el.classList.remove('reveal', 'in'); el.style.transitionDelay = ''; }, 1000 + (parseFloat(el.style.transitionDelay) || 0) * 1000);
    };
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        io.unobserve(e.target);
        var items = e.target.__revealItems || [e.target];
        items.forEach(function (el) { el.classList.add('in'); finish(el); });
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });

    var used = new Set();
    groups.forEach(function (sel) {
      $$(sel).forEach(function (g) {
        if (used.has(g) || g.closest('.hero, .page-hero')) return;
        var kids = Array.prototype.slice.call(g.children).filter(function (k) { return getComputedStyle(k).position !== 'absolute'; });
        if (!kids.length) return;
        kids.forEach(function (k, i) { k.classList.add('reveal'); k.style.transitionDelay = (Math.min(i, 5) * 0.08) + 's'; used.add(k); });
        g.__revealItems = kids;
        used.add(g);
        io.observe(g);
      });
    });
    var insideUsed = function (el) {
      for (var p = el.parentElement; p; p = p.parentElement) if (used.has(p)) return true;
      return false;
    };
    singles.forEach(function (sel) {
      $$(sel).forEach(function (el) {
        if (used.has(el) || el.closest('.hero, .page-hero') || getComputedStyle(el).position === 'absolute') return;
        // skip anything inside an element that is already revealed
        if (insideUsed(el)) return;
        el.classList.add('reveal');
        used.add(el);
        io.observe(el);
      });
    });

    /* Inner pages: every block of every section rises in as it enters the window;
       lists, card rows and slider cards follow one another. (The home page keeps
       the hand-picked set above, which mirrors the prototype.) */
    if (!doc.body.classList.contains('page-home')) {
      var main = doc.querySelector('main');
      var fixedLike = /^(absolute|fixed|sticky)$/;
      var canMove = function (el) {
        if (used.has(el) || insideUsed(el) || el.querySelector('.reveal')) return false;
        if (el.matches('.marquee, .steam, script, template, [hidden]')) return false;
        var cs = getComputedStyle(el);
        // leave rotated or positioned pieces alone: the reveal would override their transform
        return !fixedLike.test(cs.position) && cs.transform === 'none' && cs.display !== 'none';
      };
      var single = function (el) {
        if (!canMove(el)) return;
        el.classList.add('reveal'); used.add(el); io.observe(el);
      };
      var group = function (list) {
        if (used.has(list) || insideUsed(list)) return;
        var kids = Array.prototype.slice.call(list.children).filter(canMove);
        if (!kids.length) return;
        kids.forEach(function (k, i) { k.classList.add('reveal'); k.style.transitionDelay = (Math.min(i, 5) * 0.08) + 's'; used.add(k); });
        list.__revealItems = kids; used.add(list); io.observe(list);
      };
      var looksLikeList = function (el) {
        if (el.matches('ul, ol, [data-reveal-group]')) return true;
        var kids = Array.prototype.slice.call(el.children);
        if (kids.length < 3) return false;
        var key = function (k) { return k.classList[0] || k.tagName; }; // a card may be an <a> or a <div>
        return kids.every(function (k) { return key(k) === key(kids[0]); });
      };
      $$('main section').forEach(function (sec) {
        if (sec.matches('.hero, .page-hero, .closing') || sec.closest('.hero, .page-hero')) return;
        if (sec.parentElement !== main) { single(sec); return; } // nested sections (legal text) move as one
        Array.prototype.slice.call(sec.children).forEach(function (block) {
          var vp = block.matches('[data-slider-viewport]') ? block : block.querySelector('[data-slider-viewport]');
          if (vp && vp !== block) {
            group(vp);
            Array.prototype.slice.call(block.children).forEach(function (k) { if (!k.contains(vp)) single(k); });
          } else if (vp || looksLikeList(block)) group(block);
          else single(block);
        });
      });
    }
  }

  /* ---------- Count-up numbers (proof band, key metrics) ---------- */
  if (!reduced && 'IntersectionObserver' in window) {
    var countEls = $$('.proof__num, [data-count]');
    var fmt = function (n) { return n.toLocaleString('en-GB'); };
    var co = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        co.unobserve(e.target);
        var el = e.target;
        var raw = el.getAttribute('data-count') || el.textContent.trim();
        var m = raw.match(/^([^\d]*)([\d,.]+)(.*)$/);
        if (!m) return;
        var pre = el.getAttribute('data-prefix') || m[1], post = m[3];
        var end = parseFloat(m[2].replace(/,/g, ''));
        if (!isFinite(end) || /\./.test(m[2])) return; // leave decimals (e.g. +24.5%) as they are
        var year = end >= 1900 && end <= 2100 && m[2].indexOf(',') < 0;
        var start = year ? end - 30 : 0, t0 = performance.now(), dur = 1400;
        var step = function (t) {
          var p = Math.min(1, (t - t0) / dur);
          var v = Math.round(start + (end - start) * (1 - Math.pow(1 - p, 3)));
          el.textContent = pre + (year ? v : fmt(v)) + post;
          if (p < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
      });
    }, { threshold: 0.4 });
    countEls.forEach(function (el) { co.observe(el); });
  }

  /* ---------- Parallax on loose cut-outs ----------
     Each element sits exactly on its designed position when it is centred in the window
     and drifts up to 70px as it scrolls past. */
  var parDefaults = [
    ['.food .cutout--fried', -0.07], ['.food .cutout--sauce', 0.09],
    ['.why .cutout--cheesling', 0.08], ['.mascot__img', 0.05], ['.closing .cutout--fried', 0.07]
  ];
  parDefaults.forEach(function (d) { $$(d[0]).forEach(function (el) { if (!el.hasAttribute('data-par')) el.setAttribute('data-par', d[1]); }); });
  var pars = $$('[data-par]');
  if (!reduced && pars.length) {
    var ticking = false;
    var run = function () {
      var vh = window.innerHeight;
      pars.forEach(function (el) {
        var cur = parseFloat(el.dataset.parY || 0);
        var r = el.getBoundingClientRect();
        if (r.bottom < -300 || r.top > vh + 300) return;
        var centre = r.top - cur + r.height / 2 - vh / 2;
        var y = Math.max(-70, Math.min(70, centre * -parseFloat(el.dataset.par)));
        el.dataset.parY = y;
        el.style.translate = '0 ' + y.toFixed(1) + 'px';
      });
      ticking = false;
    };
    window.addEventListener('scroll', function () { if (!ticking) { ticking = true; requestAnimationFrame(run); } }, { passive: true });
    window.addEventListener('resize', run);
    run();
  }
})();
