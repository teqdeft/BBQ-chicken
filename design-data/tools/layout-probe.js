// Layout probe: lists the position, size and type style of every text element and image on a page,
// relative to the top of its section, so two builds of the same design can be compared.
// Run in the page (browser console / tool):  await (await fetch('/design-data/tools/layout-probe.js')).text() -> eval
//   probe(sectionSelectors)  -> array of rows
window.probe = function (sections, scale) {
  scale = scale || 1;
  var rows = [];
  var clean = function (t) { return (t || '').replace(/\s+/g, ' ').trim().slice(0, 48); };
  sections.forEach(function (pair) {
    var name = pair[0], sec = document.querySelector(pair[1]);
    if (!sec) { rows.push({ sec: name, missing: true }); return; }
    var top = sec.getBoundingClientRect().top;
    var seen = new Set();
    sec.querySelectorAll('h1,h2,h3,h4,p,a,button,span,strong,em,small,b,li,img,input,svg').forEach(function (el) {
      var cs = getComputedStyle(el);
      if (cs.display === 'none' || cs.visibility === 'hidden' || el.closest('[aria-hidden="true"]:not(img)') && el.tagName !== 'IMG') return;
      var r = el.getBoundingClientRect();
      if (r.width < 4 || r.height < 4) return;
      var key;
      if (el.tagName === 'IMG') key = 'img:' + (el.getAttribute('src') || '').split('/').pop().replace(/\.(webp|png|jpg|svg)$/, '');
      else if (el.tagName === 'INPUT') key = 'input:' + el.placeholder;
      else if (el.tagName === 'svg') return;
      else {
        // only elements that carry their own text (not wrappers of other text elements)
        var own = Array.prototype.some.call(el.childNodes, function (n) { return n.nodeType === 3 && n.textContent.trim(); });
        if (!own) return;
        key = clean(el.textContent);
        if (!key) return;
      }
      if (seen.has(key)) return; seen.add(key);
      rows.push({
        sec: name, key: key, tag: el.tagName.toLowerCase(),
        x: Math.round(r.left / scale), y: Math.round((r.top - top) / scale), w: Math.round(r.width / scale), h: Math.round(r.height / scale),
        fs: el.tagName === 'IMG' ? '' : Math.round(parseFloat(cs.fontSize) * 10) / 10 + '/' + cs.fontWeight,
        col: el.tagName === 'IMG' ? '' : cs.color
      });
    });
  });
  return rows;
};
