/* bb.q Chicken Europe — "Submit your application" modal (desktop) / full-screen sheet (mobile)
 *
 * Every [data-apply] link (header, floating CTA, footer, page buttons) keeps its href to the Apply page.
 * With JS, a click opens the application form in a dialog instead, so visitors keep their place.
 * WordPress: the form is the Contact Form 7 form of the Apply page (window.bbqSite.applyUrl,
 * #application-form inside div.wpcf7) — it is defined only once. The pop-up's own texts come from
 * <template id="apply-modal-content"> on that page (editable there); the texts below are the fallback.
 * The copy is initialised with Contact Form 7's own script (wpcf7.init), so validation and the AJAX
 * submit work as on the page; after a successful submit the dialog shows its thank-you state.
 * Without JS, without Contact Form 7's script or when the fetch fails, the link simply navigates to the Apply page.
 * Figma: modal 93-362, mobile sheet 116-520 (B1 sheet, B2 full screen + sticky submit, B3 thank you).
 */
(function () {
  'use strict';

  var doc = document;
  var html = doc.documentElement;
  var body = doc.body;
  var site = window.bbqSite || {};
  var FORM_ID = 'application-form';
  var TEXTS_ID = 'apply-modal-content';
  var ID_PREFIX = 'm-';
  var MAX_BYTES = 10 * 1024 * 1024;
  var mqMobile = window.matchMedia('(max-width: 767px)');
  var mqReduce = window.matchMedia('(prefers-reduced-motion: reduce)');

  var ICON_ARROW = '<svg viewBox="0 0 10 10" fill="none" aria-hidden="true"><path d="M3.5 1.5 7 5 3.5 8.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>';
  var ICON_CLOSE = '<svg viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M2 2l10 10M12 2 2 12" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>';
  var ICON_CHECK = '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12.5 10 17.5 19.5 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>';

  function cf7Ready() {
    return !!(window.wpcf7 && typeof window.wpcf7.init === 'function');
  }

  /* ---------- Upload fields: show the chosen file name ----------
     In a Contact Form 7 form, CF7 checks the type and size (and shows its message); a plain form
     accepts PDF up to 10 MB through the browser's own validation. */
  function initUploads(scope) {
    scope.querySelectorAll('[data-upload]').forEach(function (field) {
      if (field.hasAttribute('data-upload-ready')) return;
      field.setAttribute('data-upload-ready', '');
      var input = field.querySelector('input[type="file"]');
      var title = field.querySelector('[data-upload-title]');
      if (!input || !title) return;
      var original = title.innerHTML;
      var isCf7 = !!input.closest('.wpcf7-form');
      var hint = field.querySelector('.app-upload__hint[id]');
      if (hint && !input.hasAttribute('aria-describedby')) input.setAttribute('aria-describedby', hint.id);

      function update() {
        var file = input.files && input.files[0];
        if (!isCf7) {
          input.setCustomValidity('');
          if (file) {
            var isPdf = /\.pdf$/i.test(file.name) || file.type === 'application/pdf';
            if (!isPdf) input.setCustomValidity('Please choose a PDF file.');
            else if (file.size > MAX_BYTES) input.setCustomValidity('Please choose a PDF of 10 MB or less.');
          }
        }
        if (file) title.textContent = file.name;
        else title.innerHTML = original;
        field.classList.toggle('is-filled', !!file);
        if (!isCf7 && input.validationMessage) input.reportValidity();
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
  var pageForm = doc.getElementById(FORM_ID); // present on the Apply page itself

  function triggerUrl(trigger) {
    try { return new URL(trigger.getAttribute('href') || site.applyUrl || '', window.location.href); }
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
    // CF7 names its error messages after the unit tag: keep them unique as well
    root.querySelectorAll('input[name="_wpcf7_unit_tag"]').forEach(function (input) {
      if (input.value.indexOf(ID_PREFIX) !== 0) input.value = ID_PREFIX + input.value;
    });
  }

  /* ---------- Fetch the form from the Apply page (once) ---------- */
  var formPromise = null;
  function loadForm(url) {
    if (!formPromise) {
      var src = url;
      try { if (site.applyUrl) src = new URL(site.applyUrl, window.location.href); } catch (e) { /* use the link */ }
      formPromise = fetch(src.pathname + src.search, { credentials: 'same-origin' })
        .then(function (res) {
          if (!res.ok) throw new Error('HTTP ' + res.status);
          return res.text();
        })
        .then(function (text) {
          var srcDoc = new DOMParser().parseFromString(text, 'text/html');
          var form = srcDoc.getElementById(FORM_ID);
          if (!form) throw new Error('#' + FORM_ID + ' not found');
          return { doc: srcDoc, form: form };
        });
      formPromise.catch(function () { formPromise = null; }); // allow a retry later
    }
    return formPromise;
  }

  /* ---------- Contact Form 7 ---------- */
  // Run CF7's own set-up on the copy (the page's forms were set up on DOMContentLoaded).
  function initCf7(cf7Form) {
    var cf7 = window.wpcf7;
    var idInput = cf7Form.querySelector('input[name="_wpcf7"]');
    var id = idInput ? Math.abs(parseInt(idInput.value, 10)) : 0;
    // wpcf7.init() forgets the validation schema of this form id (it is shared with a copy already
    // on the page, e.g. the Franchise page's form): keep it, or load it as CF7 does on page load.
    var schemas = cf7.schemas;
    var schema = schemas && id ? schemas.get(id) : undefined;
    cf7.init(cf7Form);
    var wrap = cf7Form.closest('.wpcf7');
    if (wrap) wrap.classList.replace('no-js', 'js');
    if (!schemas || !id) return;
    if (schema) { schemas.set(id, schema); return; }
    var api = cf7.api || {};
    if (!api.root) return;
    var path = String(api.namespace || 'contact-form-7/v1').replace(/^\/|\/$/g, '') + '/contact-forms/' + id + '/feedback/schema';
    if (api.root.indexOf('?') > -1) path = path.replace('?', '&');
    fetch(api.root + path, { credentials: 'same-origin', headers: { Accept: 'application/json' } })
      .then(function (res) { return res.ok ? res.json() : null; })
      .then(function (data) { if (data) schemas.set(id, data); })
      .catch(function () { /* the server still validates on submit */ });
  }

  /* ---------- Build the dialog ---------- */
  var modal, scroller, dialog, sheetBody, card, done, form, submitBtn;
  var isOpen = false, isDone = false, submitBelow = false;
  var lastTrigger = null, inerted = [], closeTimer = null, downOnBackdrop = false;

  // Editable texts from the Apply page's <template id="apply-modal-content"> (if present)
  function useTexts(srcDoc) {
    var tpl = srcDoc && srcDoc.getElementById(TEXTS_ID);
    var src = tpl && tpl.content;
    if (!src) return;
    ['.apply-modal__bar-title', '.form-card__intro', '.apply-modal__done-title', '.apply-modal__done-text'].forEach(function (sel) {
      var from = src.querySelector(sel);
      var to = modal.querySelector(sel);
      if (from && to) to.parentNode.replaceChild(doc.importNode(from, true), to);
    });
    [['[data-modal-submit]', '.apply-modal__sticky .btn'], ['[data-modal-back]', '.apply-modal__done .btn']].forEach(function (pair) {
      var from = src.querySelector(pair[0]);
      var btn = modal.querySelector(pair[1]);
      var text = from ? from.textContent.trim() : '';
      if (text && btn && btn.firstChild && btn.firstChild.nodeType === 3) btn.firstChild.nodeValue = text + ' ';
    });
  }

  function build(source) {
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
                  '<p class="info-box__step">We reply within 5 working days.</p>' +
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
          // Sits outside the form (form="…"): the browser submits the form, CF7's submit handler takes over
          '<div class="apply-modal__sticky"><button class="btn btn--red" type="submit" form="' + ID_PREFIX + FORM_ID + '">Submit your application <span class="btn__chip">' + ICON_ARROW + '</span></button></div>' +
        '</div>' +
      '</div>';
    useTexts(source.doc);

    scroller = modal.querySelector('.apply-modal__scroller');
    dialog = modal.querySelector('.apply-modal__dialog');
    sheetBody = modal.querySelector('.apply-modal__body');
    card = modal.querySelector('.apply-modal__card');
    done = modal.querySelector('.apply-modal__done');

    // Copy the whole CF7 block (div.wpcf7 holds the screen-reader messages CF7 writes to)
    var sourceWrap = source.form.closest('.wpcf7') || source.form;
    var wrap = doc.importNode(sourceWrap, true);
    form = wrap.tagName === 'FORM' ? wrap : wrap.querySelector('form');
    form.removeAttribute('data-form');        // never handled by main.js's placeholder submit
    form.removeAttribute('data-success-url'); // the sheet shows its own thank-you state
    prefixIds(wrap);
    card.appendChild(wrap);
    submitBtn = form.querySelector('[type="submit"]');
    body.appendChild(modal);
    initUploads(form);
    initCf7(form);

    // Sent: show the dialog's thank-you state. The site-wide "go to the thank-you page" listener
    // (inc/forms.php) skips forms inside .apply-modal; the event still bubbles for other listeners
    // (e.g. conversion tracking).
    form.addEventListener('wpcf7mailsent', function () {
      showDone();
    });
    // Errors: bring the first field with a message into view (the sticky button may be far below it).
    // CF7 fires the event before it marks the fields, hence the timeout.
    ['wpcf7invalid', 'wpcf7unaccepted'].forEach(function (type) {
      form.addEventListener(type, function () {
        setTimeout(function () {
          var bad = form.querySelector('.wpcf7-not-valid');
          if (!bad) return;
          var target = bad.matches('input, select, textarea') ? bad : bad.querySelector('input, select, textarea');
          var field = bad.closest('.field, .app-options, .check') || bad;
          field.scrollIntoView({ behavior: mqReduce.matches ? 'auto' : 'smooth', block: 'center' });
          if (target && target.type !== 'file') target.focus({ preventScroll: true });
        }, 0);
      });
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
    // After a sent application, start the next one from a clean form (CF7 keeps its "sent" message otherwise)
    if (form && form.getAttribute('data-status') === 'sent') form.reset();
    card.hidden = false;
    done.hidden = true;
    dialog.classList.remove('is-done', 'is-full', 'has-sticky');
  }

  function showDone() {
    isDone = true;   // CF7 resets the form itself after a successful submit
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
      dialog.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]):not([type="hidden"]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'),
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
    loadForm(url).then(function (source) {
      html.classList.remove('apply-modal-loading');
      if (!cf7Ready()) throw new Error('Contact Form 7 script not loaded');
      if (!modal) build(source);
      show();
    }).catch(function () {
      html.classList.remove('apply-modal-loading');
      window.location.href = url.href; // fallback: the stand-alone Apply page
    });
  }

  function focusPageForm() {
    var section = pageForm.closest('section') || pageForm;
    section.scrollIntoView({ behavior: mqReduce.matches ? 'auto' : 'smooth', block: 'start' });
    var first = pageForm.querySelector('input:not([type="hidden"]), select, textarea');
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
    if (pageForm) { focusPageForm(); return; } // already on the Apply page
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
