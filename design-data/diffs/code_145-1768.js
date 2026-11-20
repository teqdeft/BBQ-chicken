// Figma-side diff for the use_figma tool (read-only).
// Returns only layers that are new ("+" = new subtree root, " " = inside a new subtree) or whose own
// properties changed ("~"), in the compact outline format, plus the ids of removed layers.
const FRAME = '145:1768';
const OLD = {"145:1768":"r3p4q5","145:1769":"3ii6mr","145:1770":"ua6oyt","145:1771":"13ndh2w","145:1772":"71kwye","145:1773":"d2dbdd","145:1774":"zomm6z","145:1775":"k62t6z","145:1776":"oeqjrd","145:1777":"1gl2s7y","145:1778":"4dvijw","145:1779":"ced74m","145:1780":"1qhn7km","145:1781":"11hhn2y","145:1782":"185jhnv","145:1783":"1flmrg6","145:1784":"pmakj8","145:1785":"aly2aw","145:1786":"y9ql14","145:1787":"o50e3y","145:1788":"1qbj3gj","145:1789":"zeo34x","145:1790":"r36pzm","145:1791":"4cllmt","145:1792":"10393xg","145:1793":"17p0y10","145:1794":"1clwzxk","145:1795":"1phacdl","145:1796":"10ugygv","145:1797":"5budn1","145:1798":"11rc0nr","145:1799":"1p63rp5","145:1800":"dud500","145:1801":"1h3caxo","145:1802":"1ptg0cq","145:1803":"1c3pz5o","145:1804":"15d5f9p","145:1805":"1a1miim","145:1806":"1n5e424","145:1807":"142y41k","145:1808":"4igap0","145:1809":"knbqwd","145:1810":"1tpxbc8","145:1811":"1sv829i","145:1812":"k4rf35","145:1813":"1bqzlff","145:1814":"1nicyxq","145:1815":"1wap7i9","145:1816":"1a20hrk","145:1817":"1vlhr4k","145:1818":"1yvslzj","145:1826":"1cz3tss","145:1827":"ctf3na","145:1828":"1rycuq2","145:1829":"12bp84b","145:1830":"r281mk","145:1831":"ej1uh9","145:1832":"1n4loqc","145:1833":"vklqgu","145:1877":"mof0ye","145:1840":"17p4i8g","145:1841":"ybau43","145:1842":"ltyoz8","145:1876":"1bjoqlv","145:1843":"1e9labu","145:1844":"1q1tg60","145:1882":"peaqei","145:1849":"i68mot","145:1850":"h03lux","145:1851":"456t60","145:1881":"3en87f","145:1852":"1neo7vb","145:1853":"1rgi4ej","145:1887":"21bohq","145:1888":"1ey1g2p","145:1889":"3t1s6v","145:1857":"utuoxk","145:1858":"gyx11p","145:1859":"13iilf2","145:1886":"58nwpm","145:1868":"1wgyn6c","145:1869":"xbbxca","145:1870":"7vl40k","145:1871":"157p4ru","145:1872":"dkidzt","145:1873":"z2xkpo","145:1874":"1uppe21","145:1875":"197x53g","145:1890":"cg5ac5","145:1891":"15cl3vi","145:1892":"1r42jsc","145:1893":"yvetp0","145:1894":"1kbhpyv","145:1895":"1q80i0d","145:1896":"ah2iar","145:1897":"swjq59","145:1898":"zwyuci","145:1899":"1xwekvb","145:1900":"1a46sky","145:1901":"3ni6x2","145:1902":"1ozugw7","145:1903":"7xvh5h","145:1904":"15q8lmi","145:1905":"1ukz3zu","145:1906":"oxjm60","145:1907":"q8i8k6","145:1908":"110y4j6","145:1909":"7i1qdu","145:1910":"47g4n1","145:1911":"a0l5sz","145:1912":"yrdbi1","145:1913":"1h68vfy","145:1914":"456m31","145:1915":"81gshe","145:1916":"1q633ws","145:1917":"1q2yy0u","145:1918":"72ofzx","145:1919":"rro88f","145:1920":"1l8gwih","145:1925":"1uihjlw","145:1926":"d4a2fc","145:1927":"18bqccw","145:1928":"tw9o5x","145:1929":"14i3xpp","145:1959":"uf9bde","145:1960":"1mgdn3u","145:1961":"4n0dpp","145:1962":"m1btt7","145:1949":"yuar0m","145:1950":"1uer6l","145:1951":"yxnabz","145:1952":"10z4zjo","145:1953":"101rcmt","145:1954":"1tqlaf8","145:1955":"1tt8uyy","145:1956":"16hzqvy","145:1957":"1e2g2i5","145:1958":"15acpqd","145:1963":"12rg0hs","145:2040":"1xzy5ed","145:2078":"12nvhbw"};
const hex = c => '#' + [c.r, c.g, c.b].map(v => Math.round(v * 255).toString(16).padStart(2, '0')).join('').toUpperCase();
const paint = p => {
  if (p.visible === false) return null;
  const o = {t: p.type};
  if (p.opacity !== undefined && p.opacity < 1) o.op = +p.opacity.toFixed(3);
  if (p.blendMode && p.blendMode !== 'NORMAL' && p.blendMode !== 'PASS_THROUGH') o.blend = p.blendMode;
  if (p.type === 'SOLID') o.c = hex(p.color);
  else if (p.type.startsWith('GRADIENT')) { o.stops = p.gradientStops.map(s => hex(s.color) + (s.color.a < 1 ? '/' + s.color.a.toFixed(2) : '') + '@' + s.position.toFixed(2)); o.tf = p.gradientTransform.map(r => r.map(v => +v.toFixed(3))); }
  else if (p.type === 'IMAGE') { o.img = p.imageHash; o.scale = p.scaleMode; if (p.imageTransform) o.itf = p.imageTransform.map(r => r.map(v => +v.toFixed(3))); if (p.filters) { const f = Object.entries(p.filters).filter(([k, v]) => v); if (f.length) o.filters = Object.fromEntries(f); } }
  return o;
};
const paints = arr => (arr === figma.mixed || !arr) ? (arr === figma.mixed ? 'mixed' : undefined) : (arr.map(paint).filter(Boolean));
const r1 = v => Math.round(v * 10) / 10;
const vecTypes = ['VECTOR', 'BOOLEAN_OPERATION', 'STAR', 'LINE', 'ELLIPSE', 'POLYGON'];
function ownSer(n) {
  const o = {id: n.id, n: n.name, t: n.type, x: r1(n.x), y: r1(n.y), w: r1(n.width), h: r1(n.height)};
  if (n.visible === false) o.hidden = true;
  if ('opacity' in n && n.opacity < 1) o.op = +n.opacity.toFixed(3);
  if ('rotation' in n && Math.abs(n.rotation) > 0.01) o.rot = r1(n.rotation);
  if ('blendMode' in n && !['PASS_THROUGH', 'NORMAL'].includes(n.blendMode)) o.blend = n.blendMode;
  if ('layoutMode' in n && n.layoutMode !== 'NONE') { o.al = {mode: n.layoutMode, gap: n.itemSpacing, p: [n.paddingTop, n.paddingRight, n.paddingBottom, n.paddingLeft], main: n.primaryAxisAlignItems, cross: n.counterAxisAlignItems}; if (n.layoutWrap === 'WRAP') { o.al.wrap = true; o.al.cgap = n.counterAxisSpacing; } }
  if ('layoutSizingHorizontal' in n) o.sz = [n.layoutSizingHorizontal, n.layoutSizingVertical].map(s => s[0]).join('');
  if ('layoutPositioning' in n && n.layoutPositioning === 'ABSOLUTE') o.abs = true;
  if ('minWidth' in n && n.minWidth) o.minW = n.minWidth;
  if ('maxWidth' in n && n.maxWidth) o.maxW = n.maxWidth;
  if ('fills' in n) { const f = paints(n.fills); if (f && f.length) o.fill = f; }
  if ('strokes' in n && n.strokes.length) { o.stroke = paints(n.strokes); o.sw = n.strokeWeight === figma.mixed ? 'mixed' : n.strokeWeight; if (n.dashPattern && n.dashPattern.length) o.dash = n.dashPattern; if (n.strokeAlign && n.strokeAlign !== 'INSIDE') o.salign = n.strokeAlign; }
  if ('cornerRadius' in n) { if (n.cornerRadius === figma.mixed) o.r = [n.topLeftRadius, n.topRightRadius, n.bottomRightRadius, n.bottomLeftRadius]; else if (n.cornerRadius) o.r = n.cornerRadius; }
  if ('effects' in n && n.effects.length) o.fx = n.effects.filter(e => e.visible !== false).map(e => { const x = {t: e.type, rad: e.radius}; if (e.color) x.c = hex(e.color) + '/' + e.color.a.toFixed(2); if (e.offset) x.off = [e.offset.x, e.offset.y]; if (e.spread) x.spread = e.spread; return x; });
  if ('clipsContent' in n && n.clipsContent) o.clip = true;
  if (n.type === 'INSTANCE') { try { o.comp = n.mainComponent ? n.mainComponent.name : null; } catch (e) {} }
  if (n.type === 'TEXT') {
    o.txt = n.characters; o.align = n.textAlignHorizontal; if (n.textAutoResize) o.auto = n.textAutoResize;
    const segs = n.getStyledTextSegments(['fontName', 'fontSize', 'lineHeight', 'letterSpacing', 'textCase', 'textDecoration', 'fills']);
    o.st = segs.map(s => ({s: s.start, e: s.end, f: s.fontName.family + ' ' + s.fontName.style, fs: s.fontSize, lh: s.lineHeight.unit === 'AUTO' ? 'auto' : (s.lineHeight.unit === 'PERCENT' ? s.lineHeight.value.toFixed(0) + '%' : s.lineHeight.value), ls: s.letterSpacing.value ? (s.letterSpacing.unit === 'PERCENT' ? s.letterSpacing.value.toFixed(1) + '%' : s.letterSpacing.value + 'px') : 0, tc: s.textCase !== 'ORIGINAL' ? s.textCase : undefined, td: s.textDecoration !== 'NONE' ? s.textDecoration : undefined, c: (s.fills[0] && s.fills[0].type === 'SOLID') ? hex(s.fills[0].color) + (s.fills[0].opacity < 1 ? '/' + s.fills[0].opacity.toFixed(2) : '') : (s.fills[0] ? s.fills[0].type : null)}));
    if (o.st.length === 1) { Object.assign(o, o.st[0]); delete o.s; delete o.e; delete o.st; }
  }
  let kids = [];
  if ('children' in n && !vecTypes.includes(n.type)) {
    const allVec = n.children.length > 0 && n.children.every(c => vecTypes.includes(c.type) || (c.type === 'GROUP' && c.findAll(d => !vecTypes.includes(d.type) && d.type !== 'GROUP').length === 0));
    if (allVec && n.children.length > 2) o.vecGroup = n.children.length; else kids = n.children;
  }
  return [o, kids];
}
const fnv = s => { let h = 0x811c9dc5; for (let i = 0; i < s.length; i++) { h ^= s.charCodeAt(i); h = Math.imul(h, 0x01000193) >>> 0; } return h.toString(36); };
const short = {FRAME: 'F', TEXT: 'T', RECTANGLE: 'R', INSTANCE: 'I', COMPONENT: 'C', GROUP: 'G', VECTOR: 'V', ELLIPSE: 'E', LINE: 'L', BOOLEAN_OPERATION: 'B'};
const fmtFill = f => !f ? '' : (f === 'mixed' ? 'mixed' : f.map(p => p.t === 'SOLID' ? p.c + (p.op ? '/' + p.op : '') : p.t === 'IMAGE' ? 'IMG(' + (p.img ? p.img.slice(0, 8) : '?') + ',' + p.scale + ')' : p.t.replace('GRADIENT_', 'G-') + '[' + p.stops.join(' ') + ']').join('+'));
const line = (n, d, tag) => {
  const name = (n.t === 'TEXT' && n.n === n.txt) ? '' : ' "' + n.n + '"';
  const parts = [tag + ' ' + '  '.repeat(d) + (short[n.t] || n.t) + ' ' + n.id + name + ' ' + n.w + 'x' + n.h + ' @' + n.x + ',' + n.y];
  if (n.hidden) parts.push('HIDDEN');
  if (n.abs) parts.push('ABS');
  if (n.sz) parts.push('sz:' + n.sz);
  if (n.al) parts.push('AL:' + n.al.mode[0] + ' gap' + n.al.gap + ' p[' + n.al.p.join(',') + '] ' + n.al.main + '/' + n.al.cross + (n.al.wrap ? ' wrap' : ''));
  if (n.fill && n.t !== 'TEXT') parts.push('fill:' + fmtFill(n.fill));
  if (n.stroke) parts.push('stroke:' + fmtFill(n.stroke) + ' ' + n.sw + (n.dash ? ' dash' + n.dash : ''));
  if (n.r) parts.push('r:' + n.r);
  if (n.op) parts.push('op:' + n.op);
  if (n.rot) parts.push('rot:' + n.rot);
  if (n.fx) parts.push('fx:' + n.fx.map(e => e.t + '(' + (e.c || '') + ' ' + (e.off ? e.off.join(',') : '') + ' r' + e.rad + (e.spread ? ' s' + e.spread : '') + ')').join(','));
  if (n.clip) parts.push('clip');
  if (n.comp) parts.push('comp:' + n.comp);
  if (n.vecGroup) parts.push('VECTORS(' + n.vecGroup + ')');
  if (n.t === 'TEXT') {
    if (n.st) parts.push('styles:' + n.st.map(s => '[' + s.s + '-' + s.e + ' ' + s.f + ' ' + s.fs + '/' + s.lh + ' ls' + s.ls + ' ' + s.c + ']').join(''));
    else parts.push('{' + n.f + ' ' + n.fs + '/' + n.lh + ' ls' + n.ls + ' ' + n.c + (n.tc ? ' ' + n.tc : '') + ' ' + n.align + '}');
    parts.push(JSON.stringify(n.txt));
  }
  return parts.join(' ');
};
const ownHash = o => { const c = Object.assign({}, o); delete c.x; delete c.y; const sz = c.sz || 'FF'; if (sz[0] !== 'F') delete c.w; if (sz[1] !== 'F') delete c.h; return c; };
const lines = [];
const seen = new Set();
const walk = (n, d, parentNew) => {
  // layers inside instances (shared header/footer/buttons) are handled in the components frames
  if (n.id.startsWith('I')) { seen.add(n.id); return; }
  const [o, kids] = ownSer(n);
  const c = ownHash(o);
  c.kids = kids.map(k => k.id).join(',');
  const h = fnv(JSON.stringify(c));
  seen.add(n.id);
  const isNew = !(n.id in OLD);
  if (isNew) lines.push(line(o, d, parentNew ? ' ' : '+'));
  else if (OLD[n.id] !== h) lines.push(line(o, d, '~'));
  kids.forEach(k => walk(k, d + 1, isNew));
};
const root = await figma.getNodeByIdAsync(FRAME);
walk(root, 0, false);
const removed = Object.keys(OLD).filter(id => !seen.has(id) && !id.startsWith('I'));
return lines.join('\n') + '\nREMOVED: ' + removed.join(',');
