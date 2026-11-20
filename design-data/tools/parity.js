// Parity check: WordPress page vs static page (both served from http://localhost via XAMPP:
// /bbq-static/<page>.html is the html-backup folder, /bbq-chicken/<slug>/ the WordPress site).
// XAMPP serves this folder as /bbq-tools (a junction). In the console of any http://localhost page:
//   (0,eval)(await (await fetch('/bbq-tools/parity.js')).text());
//   await parity('/bbq-static/contact.html', '/bbq-chicken/contact/', [1680, 1440, 390])
// Optional 5th argument: what to compare instead of <main>, e.g. '.site-footer' or '.site-header'.
// Returns, per width: section heights and every text/image whose position, size or type style differs.
window.parity = async function (staticUrl, wpUrl, widths, tolerance, rootSel) {
  rootSel = rootSel || 'main';
  widths = widths || [1680, 1440, 390];
  tolerance = tolerance || 3;
  const clean = t => (t || '').replace(/\s+/g, ' ').trim().slice(0, 60);
  async function measure(url, w) {
    const f = document.createElement('iframe');
    f.style.cssText = 'position:fixed;left:0;top:0;width:' + w + 'px;height:900px;opacity:0;pointer-events:none;border:0';
    f.src = url;
    document.body.appendChild(f);
    await new Promise(r => { f.onload = r; });
    const d = f.contentDocument, win = f.contentWindow;
    const st = d.createElement('style');
    st.textContent = 'html{scrollbar-width:none} .reveal{opacity:1!important;transform:none!important} *{transition:none!important;animation:none!important} #wpadminbar{display:none!important}';
    d.head.appendChild(st);
    await new Promise(r => setTimeout(r, 700));
    const main = d.querySelector(rootSel);
    const top = main.getBoundingClientRect().top;
    const sections = [...main.children].map(e => (e.className || e.tagName).toString().split(' ').slice(0, 2).join('.') + ' ' + Math.round(e.getBoundingClientRect().height));
    const rows = {};
    main.querySelectorAll('h1,h2,h3,h4,p,a,button,span,strong,em,small,li,label,img,input,select,textarea,address,figcaption').forEach(el => {
      const cs = win.getComputedStyle(el);
      if (cs.display === 'none' || cs.visibility === 'hidden') return;
      const r = el.getBoundingClientRect();
      if (r.width < 2 || r.height < 2) return;
      let key;
      if (el.tagName === 'IMG') key = 'img:' + (el.getAttribute('src') || '').split('/').pop().replace(/[-\d]*x[-\d]*(?=\.)/, '').split('?')[0];
      else if (/^(INPUT|SELECT|TEXTAREA)$/.test(el.tagName)) key = el.tagName.toLowerCase() + ':' + (el.getAttribute('placeholder') || el.id || el.name);
      else {
        const own = [...el.childNodes].some(n => n.nodeType === 3 && n.textContent.trim());
        if (!own) return;
        key = clean(el.textContent);
      }
      if (!key || rows[key]) return;
      rows[key] = { x: Math.round(r.left), y: Math.round(r.top - top), w: Math.round(r.width), h: Math.round(r.height), font: cs.fontSize + '/' + cs.fontWeight + '/' + cs.lineHeight, color: cs.color };
    });
    const height = Math.round(main.getBoundingClientRect().height);
    f.remove();
    return { sections, rows, height };
  }
  const report = {};
  for (const w of widths) {
    const a = await measure(staticUrl, w), b = await measure(wpUrl, w);
    const diffs = [], missing = [], extra = [];
    for (const k in a.rows) {
      const p = a.rows[k], q = b.rows[k];
      if (!q) { missing.push(k); continue; }
      const d = [];
      ['x', 'y', 'w', 'h'].forEach(n => { if (Math.abs(p[n] - q[n]) > tolerance) d.push(n + ' ' + p[n] + '→' + q[n]); });
      if (p.font !== q.font) d.push('font ' + p.font + '→' + q.font);
      if (p.color !== q.color) d.push('color ' + p.color + '→' + q.color);
      if (d.length) diffs.push(k.slice(0, 40) + ': ' + d.join(', '));
    }
    for (const k in b.rows) if (!a.rows[k]) extra.push(k);
    report[w] = { mainHeight: a.height + ' → ' + b.height, sections: a.sections.join(' | ') + '  ⇢  ' + b.sections.join(' | '), diffs, missing, extra };
  }
  return report;
};
