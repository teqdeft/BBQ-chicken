const FRAME = '149:2335';
const OLD = {"149:2335":"1i3srww","149:2336":"x8zwnv","149:2337":"5wdb03","149:2338":"13ngzko","149:2339":"1ru4aaa","149:2340":"r1ihnq","149:2341":"btat46","149:2342":"1x5hhzh","149:2343":"wevdhn","149:2344":"70o0iz","149:2345":"1sk0gfv","149:2346":"zzkyu","149:2347":"13amub1","149:2348":"14ktxu7","149:2349":"1hvt1d4","149:2350":"882ft8","149:2351":"uvdn0c","149:2352":"jr7y5q","149:2353":"1jj6zrj","149:2354":"1r63pyv","149:2355":"1l9ms47","149:2356":"4ksegw","149:2357":"8sayv7","149:2358":"2niblg","149:2359":"rzxud8","149:2360":"12sfthp","149:2361":"14g3ysj","149:2362":"ake7t3","149:2363":"mfjj9r","149:2364":"1igly51","149:2365":"tibxxk","149:2366":"1d6vtkv","149:2367":"1w0vb1s","149:2368":"gi7six","149:2369":"1spi3y5","149:2370":"w61x0n","149:2371":"1966ebe","149:2372":"thgfz3","149:2373":"5odkgu","149:2374":"qeb2bc","149:2375":"sltw5n","149:2376":"k6l8l","149:2377":"6nemll","149:2378":"1fenhhg","149:2379":"q5yoec","149:2380":"1qqfdea","149:2381":"m37u3l","149:2382":"mns2wm","149:2383":"1d11p6f","149:2384":"5ll3cg","149:2392":"1vtu9a","149:2393":"97p2ho","149:2394":"tq09g6","149:2395":"rxqv60","149:2396":"1khvwm5","149:2397":"mckpi6","149:2398":"1tc6bal","149:2399":"xtw97w","149:2400":"43quku","149:2401":"1vyx4m","149:2402":"h2o9vy","149:2403":"3v9tc3","149:2404":"1o5nng7","149:2405":"16sd7vs","149:2406":"xgwmvu","149:2407":"is7kz4","149:2408":"1uzm0y3","149:2409":"ni7cl7","149:2410":"bdel0","149:2411":"14fwvtd","149:2412":"17jkccg","149:2413":"19038v2","149:2414":"jv1045","149:2415":"8w6ogk","149:2416":"1p9usix","149:2417":"rbhxmw","149:2418":"18jdhih","149:2419":"1kh04yi","149:2420":"qqodkr","149:2421":"1bhl3iy","149:2422":"1y2p4d0","149:2423":"2dzvrx","149:2424":"1efngoh","149:2425":"tvnaj4","149:2426":"2s9gt4","149:2427":"wvgrb1","149:2428":"1ijo257","149:2429":"4p7gv0","149:2430":"12y55dn","149:2431":"1s3s4a4","149:2432":"1j5e1hv","149:2433":"1h1w0jj","149:2434":"1rkokef","149:2435":"a9v08g","149:2436":"1gvkue3","149:2437":"1d93twj","149:2438":"17pm73m","149:2439":"1hoh49t","149:2440":"157s00d","149:2441":"km8xya","149:2442":"mmrejw","149:2443":"cvmpyu","149:2444":"1fydjra","149:2445":"s8zmes","149:2446":"1gjhrhv","149:2447":"19mf8jf","149:2448":"16iaa11","149:2449":"1n6qhqj","149:2450":"1i8f2k2","149:2451":"1dmyyb5","149:2452":"1xmlvsk","149:2453":"1moi648","149:2454":"1x6rjlo","149:2455":"ud5c63","149:2456":"1mtvkif","149:2457":"1pvn6i6","149:2458":"avjpcu","149:2459":"1thbsx3","149:2460":"q9n6y8","149:2461":"etmf52","149:2462":"1jfnimn","149:2463":"5efdm4","149:2464":"mei0so","149:2465":"rf765h","149:2466":"18grxen","149:2467":"1k6eluw","149:2468":"z5pjty","149:2469":"e27ajh","149:2470":"1scxnz8","149:2471":"xogxgw","149:2472":"16titmc","149:2473":"syptor","149:2474":"1t8ucco","149:2475":"ancvzn","149:2476":"12uwxfq","149:2477":"5arubd","149:2478":"1m4w3e3","149:2479":"1l32ab2","149:2480":"hv8hj6","149:2481":"y53mp7","149:2482":"10sm66b","149:2490":"azuiau","149:2491":"xrc279","149:2560":"1jvzi2q","149:2581":"7jloty"};
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
