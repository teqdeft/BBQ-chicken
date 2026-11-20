// Paste into the browser console on http://localhost:5173/ (or run via the browser tool) to snapshot
// computed styles inside chosen blocks on several pages and widths. Used to check CSS refactors:
//   await snap('before')   ...edit CSS...   await snap('after'); diffSnap('before', 'after')
window.snap = async function (key, pages, sel, widths) {
  pages = pages || ['careers', 'contact', 'real-estate', 'franchise', 'apply'];
  sel = sel || '.form-section';
  widths = widths || [1680, 1440, 1024, 375];
  var props = ['display', 'order', 'padding', 'margin', 'gap', 'border-radius', 'background-color', 'background-image', 'color', 'font-size', 'font-weight', 'line-height', 'letter-spacing', 'box-shadow', 'border', 'width', 'height'];
  var out = {};
  for (var p of pages) for (var w of widths) {
    var f = document.createElement('iframe');
    f.style.cssText = 'position:fixed;left:0;top:0;width:' + w + 'px;height:900px;opacity:0;pointer-events:none';
    f.src = '/' + p + '.html?nomotion';
    document.body.appendChild(f);
    await new Promise(function (r) { f.onload = r; });
    await new Promise(function (r) { setTimeout(r, 300); });
    var d = f.contentDocument, cw = f.contentWindow;
    d.querySelectorAll(sel).forEach(function (root, ri) {
      [root].concat(Array.from(root.querySelectorAll('*'))).forEach(function (el, i) {
        if (el.matches('.reveal')) el.classList.remove('reveal');
        var cs = cw.getComputedStyle(el);
        out[p + '@' + w + '#' + ri + ':' + i + ':' + el.tagName + '.' + (el.className.baseVal === undefined ? el.className : '').toString().split(' ')[0]] =
          props.map(function (k) { return k + '=' + cs.getPropertyValue(k).replace(/url\([^)]*\/img\//g, 'url(').slice(0, 120); }).join('|');
      });
    });
    f.remove();
  }
  localStorage.setItem('snap-' + key, JSON.stringify(out));
  return Object.keys(out).length;
};
window.diffSnap = function (a, b) {
  var A = JSON.parse(localStorage.getItem('snap-' + a)), B = JSON.parse(localStorage.getItem('snap-' + b)), diffs = [];
  Object.keys(A).forEach(function (k) {
    if (!(k in B)) { diffs.push(k + ' missing'); return; }
    if (A[k] === B[k]) return;
    var x = A[k].split('|'), y = B[k].split('|');
    x.forEach(function (v, i) { if (v !== y[i]) diffs.push(k + '  ' + v + '  ->  ' + y[i].split('=')[1]); });
  });
  return diffs;
};
