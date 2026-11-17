/* bb.q Chicken Europe — "Submit your application" modal (desktop) / full-screen sheet (mobile)
 *
 * Every [data-apply] link (header, floating CTA, footer, page buttons) keeps href="apply.html".
 * With JS, a click opens the application form in a dialog instead, so visitors keep their place.
 * The form is fetched from apply.html (#application-form) — it is defined only once.
 * Without JS, or when the fetch fails, the link simply navigates to apply.html.
 * Figma: modal 93-362, mobile sheet 116-520 (B1 sheet, B2 full screen + sticky submit, B3 thank you).
 */
(function () {
  'use strict';

  var doc = document;
  var html = doc.documentElement;
  var body = doc.body;
  var FORM_ID = 'application-form';
  var ID_PREFIX = 'm-';
  var MAX_BYTES = 10 * 1024 * 1024;
  var mqMobile = window.matchMedia('(max-width: 767px)');
  var mqReduce = window.matchMedia('(prefers-reduced-motion: reduce)');

  var ICON_ARROW = '<svg viewBox="0 0 10 10" fill="none" aria-hidden="true"><path d="M3.5 1.5 7 5 3.5 8.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>';
  var ICON_CLOSE = '<svg viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M2 2l10 10M12 2 2 12" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>';
  var ICON_CHECK = '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12.5 10 17.5 19.5 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>';

  /* ---------- Upload fields: show the chosen file name, accept PDF up to 10 MB ---------- */
  function initUploads(scope) {
    scope.querySelectorAll('[data-upload]').forEach(function (field) {
      if (field.hasAttribute('data-upload-ready')) return;
      field.setAttribute('data-upload-ready', '');
      var input = field.querySelector('input[type="file"]');
      var title = field.querySelector('[data-upload-title]');
      if (!input || !title) return;
      var original = title.innerHTML;

      function update() {
        var file = input.files && input.files[0];
        input.setCustomValidity('');
        if (file) {
          var isPdf = /\.pdf$/i.test(file.name) || file.type === 'application/pdf';
          if (!isPdf) input.setCustomValidity('Please choose a PDF file.');
          else if (file.size > MAX_BYTES) input.setCustomValidity('Please choose a PDF of 10 MB or less.');
          title.textContent = file.name;
        } else {
          title.innerHTML = original;
        }
        field.classList.toggle('is-filled', !!file);
        if (input.validationMessage) input.reportValidity();
      }

      input.addEventListener('change', update);
      ['dragenter', 'dragover'].forEach(function (type) {
        input.addEventListener(type, function () { field.classList.add('is-dragover'); });
      });
      ['dragleave', 'drop'].forEach(function (type) {
        input.addEventListener(type, function () { field.classList.remove('is-dragover'); });
      });
      if (input.form) input.form.addEventListener('reset', function () { setTimeout(update, 0); });
    });
  }
  initUploads(doc);

  /* ---------- Helpers ---------- */
  var pageForm = doc.getElementById(FORM_ID); // present on apply.html itself

  function triggerUrl(trigger) {
    try { return new URL(trigger.getAttribute('href') || 'apply.html', window.location.href); }
    catch (e) { return null; }
  }

  function isVisible(el) {
    return el.getClientRects().length > 0 && getComputedStyle(el).visibility !== 'hidden';
  }

  // Give every id in the cloned form a prefix (and update the references) so it never clashes
  // with a form already on the page (e.g. the one in the Franchise page's #apply section).
  function prefixIds(root) {
    var map = {};
    [root].concat(Array.prototype.slice.call(root.querySelectorAll('[id]'))).forEach(function (el) {
      if (!el.id) return;
      map[el.id] = ID_PREFIX + el.id;
      el.id = map[el.id];
    });
    ['for', 'aria-describedby', 'aria-labelledby', 'aria-controls', 'form', 'list'].forEach(function (attr) {
      root.querySelectorAll('[' + attr + ']').forEach(function (el) {
        el.setAttribute(attr, el.getAttribute(attr).split(/\s+/).map(function (t) { return map[t] || t; }).join(' '));
      });
    });
  }

  /* ---------- Fetch the form from apply.html (once) ---------- */
  var formPromise = null;
  function loadForm(url) {
    if (!formPromise) {
      formPromise = fetch(url.pathname + url.search, { credentials: 'same-origin' })
        .then(function (res) {
          if (!res.ok) throw new Error('HTTP ' + res.status);
          return res.text();
        })
        .then(function (text) {
          var form = new DOMParser().parseFromString(text, 'text/html').getElementById(FORM_ID);
          if (!form) throw new Error('#' + FORM_ID + ' not found');
          return form;
        });
      formPromise.catch(function () { formPromise = null; }); // allow a retry later
    }
    return formPromise;
  }

  /* ---------- Build the dialog ---------- */
  var modal, scroller, dialog, sheetBody, card, done, form, submitBtn;
  var isOpen = false, isDone = false, submitBelow = false;
  var lastTrigger = null, inerted = [], closeTimer = null, downOnBackdrop = false;

  function build(sourceForm) {
    modal = doc.createElement('div');
    modal.className = 'apply-modal';
    modal.hidden = true;
    modal.innerHTML =
      '<div class="apply-modal__backdrop"></div>' +
      '<div class="apply-modal__scroller">' +
        '<div class="apply-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="apply-modal-title" tabindex="-1">' +
          '<button class="apply-modal__close" type="button" aria-label="Close" data-apply-close>' + ICON_CLOSE + '</button>' +
          '<div class="apply-modal__bar" aria-hidden="true"><span class="apply-modal__handle"></span><span class="apply-modal__bar-title">Submit your application</span></div>' +
          '<div class="apply-modal__body">' +
            '<div class="form-card form-card--app apply-modal__card">' +
              '<div class="form-card__intro">' +
                '<span class="eyebrow">Apply</span>' +
                '<h2 class="h2" id="apply-modal-title">Submit your application</h2>' +
                '<p class="lead"><span class="only-desktop">Ready to join the bb.q Chicken franchise network? You\'ll stay on this page.</span><span class="only-mobile">Ready to join the bb.q Chicken franchise network? Tell us who you are and where you\'d like to grow. Our expansion team reads every application.</span></p>' +
                '<div class="info-box">' +
                  '<p class="info-box__title">What happens next</p>' +
                  '<p class="info-box__step">We review your application within 5 working days.</p>' +
                  '<p class="info-box__step">We schedule an introductory meeting.</p>' +
                  '<p class="info-box__step">Together we look at your territory and the right site.</p>' +
                '</div>' +
              '</div>' +
            '</div>' +
            '<div class="apply-modal__done" hidden>' +
              '<span class="apply-modal__check" aria-hidden="true">' + ICON_CHECK + '</span>' +
              '<h2 class="apply-modal__done-title" tabindex="-1">Thank you for your interest</h2>' +
              '<p class="apply-modal__done-text">Our team will be in touch.</p>' +
              '<button class="btn btn--dark" type="button" data-apply-close>Back to the page <span class="btn__chip">' + ICON_ARROW + '</span></button>' +
            '</div>' +
          '</div>' +
          '<div class="apply-modal__sticky"><button class="btn btn--red" type="submit" form="' + ID_PREFIX + FORM_ID + '">Submit your application <span class="btn__chip">' + ICON_ARROW + '</span></button></div>' +
        '</div>' +
      '</div>';

    scroller = modal.querySelector('.apply-modal__scroller');
    dialog = modal.querySelector('.apply-modal__dialog');
    sheetBody = modal.querySelector('.apply-modal__body');
    card = modal.querySelector('.apply-modal__card');
    done = modal.querySelector('.apply-modal__done');

    form = doc.importNode(sourceForm, true);
    form.removeAttribute('data-form');        // submit is handled below, not by main.js
    form.removeAttribute('data-success-url'); // the sheet shows its own thank-you state
    prefixIds(form);
    card.appendChild(form);
    submitBtn = form.querySelector('[type="submit"]');
    body.appendChild(modal);
    initUploads(form);

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!form.reportValidity()) return;
      // [Form handling to be connected] — post the data to the backend here.
      showDone();
    });

    // Close: close button, "Back to the page", backdrop (only when the press started there too)
    modal.addEventListener('pointerdown', function (e) {
      downOnBackdrop = e.target === scroller || e.target.classList.contains('apply-modal__backdrop');
    });
    modal.addEventListener('click', function (e) {
      if (e.target.closest('[data-apply-close]')) { close(); return; }
      var onBackdrop = e.target === scroller || e.target.classList.contains('apply-modal__backdrop');
      if (onBackdrop && downOnBackdrop) close();
    });

    // Mobile: the sheet grows to full screen once scrolled; the sticky submit shows while
    // the form's own submit button is still below the fold.
    sheetBody.addEventListener('scroll', function () {
      if (mqMobile.matches && sheetBody.scrollTop > 8 && !dialog.classList.contains('is-full')) {
        dialog.classList.add('is-full');
        updateSticky();
      }
    }, { passive: true });
    if ('IntersectionObserver' in window && submitBtn) {
      new IntersectionObserver(function (entries) {
        var en = entries[entries.length - 1];
        var bottom = en.rootBounds ? en.rootBounds.bottom : window.innerHeight;
        submitBelow = !en.isIntersecting && en.boundingClientRect.top >= bottom - 1;
        updateSticky();
      }, { root: sheetBody, threshold: 0 }).observe(submitBtn);
    }
    if (mqMobile.addEventListener) mqMobile.addEventListener('change', updateSticky);

    // Mobile: swipe the top bar down to close
    var bar = modal.querySelector('.apply-modal__bar');
    var startY = null, dy = 0;
    bar.addEventListener('touchstart', function (e) {
      startY = e.touches[0].clientY; dy = 0;
      dialog.style.transition = 'none';
    }, { passive: true });
    bar.addEventListener('touchmove', function (e) {
      if (startY === null) return;
      dy = Math.max(0, e.touches[0].clientY - startY);
      dialog.style.transform = 'translateY(' + dy + 'px)';
    }, { passive: true });
    function endSwipe() {
      if (startY === null) return;
      startY = null;
      dialog.style.transition = '';
      dialog.style.transform = '';
      if (dy > 90) close();
    }
    bar.addEventListener('touchend', endSwipe);
    bar.addEventListener('touchcancel', endSwipe);
  }

  function updateSticky() {
    if (!dialog) return;
    dialog.classList.toggle('has-sticky', mqMobile.matches && !isDone && submitBelow && dialog.classList.contains('is-full'));
  }

  function resetView() {
    isDone = false;
    card.hidden = false;
    done.hidden = true;
    dialog.classList.remove('is-done', 'is-full', 'has-sticky');
  }

  function showDone() {
    isDone = true;
    form.reset();
    card.hidden = true;
    done.hidden = false;
    dialog.classList.add('is-done');
    updateSticky();
    sheetBody.scrollTop = 0;
    scroller.scrollTop = 0;
    done.querySelector('.apply-modal__done-title').focus({ preventScroll: true });
  }

  /* ---------- Open / close ---------- */
  function closeMenus() {
    doc.querySelectorAll('[data-dropdown].is-open').forEach(function (dd) {
      dd.classList.remove('is-open');
      var b = dd.querySelector('[aria-expanded]');
      if (b) b.setAttribute('aria-expanded', 'false');
    });
  }

  function show() {
    if (isOpen) return;
    isOpen = true;
    clearTimeout(closeTimer);
    closeMenus();
    resetView();
    modal.hidden = false;
    html.classList.add('apply-modal-open');

    // Everything else becomes inert (not focusable, hidden from assistive tech)
    inerted = [];
    Array.prototype.forEach.call(body.children, function (el) {
      if (el === modal || el.tagName === 'SCRIPT' || el.inert) return;
      el.inert = true;
      inerted.push(el);
    });

    sheetBody.scrollTop = 0;
    scroller.scrollTop = 0;
    void modal.offsetWidth; // start the enter transition from the initial state
    modal.classList.add('is-open');
    dialog.focus({ preventScroll: true });
    doc.addEventListener('keydown', onKeydown, true);
  }

  function close() {
    if (!isOpen) return;
    isOpen = false;
    doc.removeEventListener('keydown', onKeydown, true);
    modal.classList.remove('is-open');
    dialog.style.transform = '';
    inerted.forEach(function (el) { el.inert = false; });
    inerted = [];

    function finish() {
      modal.hidden = true;
      html.classList.remove('apply-modal-open');
      if (isDone) resetView();
    }
    if (mqReduce.matches) finish();
    else closeTimer = setTimeout(finish, 350);

    if (lastTrigger && doc.contains(lastTrigger)) {
      try { lastTrigger.focus({ preventScroll: true }); } catch (e) { /* ignore */ }
    }
  }

  function onKeydown(e) {
    if (e.key === 'Escape' || e.key === 'Esc') {
      e.preventDefault();
      close();
      return;
    }
    if (e.key !== 'Tab') return;
    // Keep focus inside the dialog
    var items = Array.prototype.filter.call(
      dialog.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'),
      isVisible
    );
    if (!items.length) { e.preventDefault(); return; }
    var first = items[0];
    var last = items[items.length - 1];
    var active = doc.activeElement;
    if (e.shiftKey && (active === first || active === dialog || !dialog.contains(active))) {
      e.preventDefault();
      last.focus();
    } else if (!e.shiftKey && (active === last || !dialog.contains(active))) {
      e.preventDefault();
      first.focus();
    }
  }

  function open(trigger, url) {
    lastTrigger = trigger;
    if (modal) { show(); return; }
    html.classList.add('apply-modal-loading');
    loadForm(url).then(function (sourceForm) {
      html.classList.remove('apply-modal-loading');
      if (!modal) build(sourceForm);
      show();
    }).catch(function () {
      html.classList.remove('apply-modal-loading');
      window.location.href = url.href; // fallback: the stand-alone apply page
    });
  }

  function focusPageForm() {
    var section = pageForm.closest('section') || pageForm;
    section.scrollIntoView({ behavior: mqReduce.matches ? 'auto' : 'smooth', block: 'start' });
    var first = pageForm.querySelector('input, select, textarea');
    if (first) first.focus({ preventScroll: true });
  }

  /* ---------- Wire up every [data-apply] trigger (event delegation) ---------- */
  doc.addEventListener('click', function (e) {
    var trigger = e.target.closest && e.target.closest('[data-apply]');
    if (!trigger || e.defaultPrevented) return;
    if (e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return; // new tab/window
    if (trigger.target && trigger.target !== '_self') return;
    var url = triggerUrl(trigger);
    if (!url || url.origin !== window.location.origin) return;
    e.preventDefault();
    if (pageForm) { focusPageForm(); return; } // already on apply.html
    open(trigger, url);
  });

  // Warm the cache as soon as someone points at / focuses a trigger
  function prefetch(e) {
    if (pageForm || modal) return;
    var trigger = e.target.closest && e.target.closest('[data-apply]');
    var url = trigger && triggerUrl(trigger);
    if (url && url.origin === window.location.origin) loadForm(url).catch(function () { /* fallback on click */ });
  }
  doc.addEventListener('pointerover', prefetch, { passive: true });
  doc.addEventListener('touchstart', prefetch, { passive: true });
  doc.addEventListener('focusin', prefetch);
})();
