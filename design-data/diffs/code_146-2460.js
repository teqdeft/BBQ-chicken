// Figma-side diff for the use_figma tool (read-only).
// Returns only layers that are new ("+" = new subtree root, " " = inside a new subtree) or whose own
// properties changed ("~"), in the compact outline format, plus the ids of removed layers.
const FRAME = '146:2460';
const OLD = {"146:2460":"nf4dn","146:2461":"1faa2ok","146:2462":"12zi8y2","146:2463":"1j37w0","146:2464":"zye3ph","146:2465":"18oabv","146:2466":"1iu23ar","146:2467":"cy2ool","146:2468":"ug2lg0","146:2469":"1rviuto","146:2470":"1poa1kh","146:2471":"1ng1ss0","146:2472":"hhv9xf","146:2473":"fj1rzm","146:2474":"9e3yzq","146:2475":"1d5hw3q","146:2476":"1x7jfqm","146:2477":"1cnf9dn","146:2478":"10xa9bf","146:2479":"144b2bw","146:2480":"e8ss16","146:2481":"1hfp02p","146:2482":"1uamb0z","146:2483":"18e4ved","146:2484":"1vkr7sw","146:2485":"1a0ra4c","146:2486":"wran2o","146:2487":"hvtmha","146:2488":"1iwcbad","146:2489":"1xgis6a","146:2490":"175wfz8","146:2491":"w9o039","146:2492":"l48eun","146:2493":"1uz90tr","146:2494":"xbg4ao","146:2495":"1cpnu6g","146:2496":"17bspnh","146:2497":"l3x49n","146:2498":"jjxyqy","146:2499":"1dgjtxd","146:2500":"200uic","146:2501":"h1mgk9","146:2502":"20x3wg","146:2503":"1exiani","146:2504":"1ewg25w","146:2505":"mdvuie","146:2506":"1xgkkm7","146:2507":"132523m","146:2508":"1g2opj","146:2509":"14oz8lz","146:2517":"1a5faj9","146:2518":"9st8oq","146:2519":"keu5gp","146:2520":"1vu74xz","146:2521":"1cpm354","146:2522":"1f3yewj","146:2523":"1yskvym","146:2524":"1b76plo","146:2525":"c8kl3w","146:2575":"11sezaz","146:2529":"1ai6myi","146:2530":"1bvprc3","146:2531":"okpkyy","146:2532":"104gbvb","146:2533":"13xi51v","146:2534":"o3i5os","146:2535":"nxnho5","146:2581":"40mfv3","146:2582":"10j8ede","146:2583":"15iuoyn","146:2539":"p9io9p","146:2540":"1hj05bh","146:2541":"1hgxeyx","146:2542":"owcv12","146:2543":"jsd5m2","146:2544":"17287l9","146:2545":"1llw4rp","146:2584":"1qr5fw4","146:2585":"1bu9e24","146:2586":"12qtjqc","146:2550":"7467y8","146:2551":"fbtodn","146:2552":"up71sp","146:2553":"124b8ir","146:2554":"e008p8","146:2555":"12ogpul","146:2556":"3m9f48","146:2587":"1ldnm0s","146:2588":"1crxly7","146:2560":"1bqo8ix","146:2561":"cpn0jt","146:2562":"pbg4zu","146:2563":"1fjiye6","146:2564":"uz0yb","146:2565":"tj8wxb","146:2566":"1cpzxbw","146:2589":"1eqtcvw","146:2570":"132vcdq","146:2571":"iz2c3v","146:2572":"wu3ouv","146:2573":"1w99ueg","146:2595":"2uhl2c","146:2596":"1mwwv29","146:2597":"1rxuvda","146:2598":"1mkhr1m","146:2599":"1tf06ld","146:2600":"1r9zg4g","146:2601":"raawga","146:2602":"1b24j1m","146:2603":"13ar06g","146:2604":"1lt5rgg","146:2609":"1n7z2k9","146:2610":"1m5m1ld","146:2611":"1v34niq","146:2612":"1x700kx","146:2605":"1x48dxu","146:2606":"v3ig02","146:2607":"e0h2hs","146:2608":"10mds10","146:2658":"8yyh5d","146:2659":"yodsz6","146:2660":"1c9k9qk","146:2661":"10zijc1","146:2618":"ugm8uq","146:2619":"12n7iw2","146:2620":"1a8mlwj","146:2621":"blmo48","146:2622":"1ipx0ri","146:2623":"jp64kd","146:2624":"1ikd3z2","146:2625":"1k837r8","146:2626":"1gg2crc","146:2627":"1rwcpml","146:2628":"1umenum","146:2662":"12fdvk3","146:2663":"svnvxr","146:2664":"5bbu84","146:2665":"5bgpn","146:2613":"1y7m6jn","146:2614":"g1i05d","146:2615":"c18pth","146:2616":"1kh7xpb","146:2617":"9pq2yl","146:2666":"yybhe0","146:2667":"13baoy3","146:2668":"1knrkrg","146:2669":"1dqnkt9","146:2670":"1qxuot1","146:2671":"lrbars","146:2672":"1lm1uue","146:2673":"1qg6jug","146:2629":"1wu0arm","146:2630":"ibsh1z","146:2631":"12kpfl1","146:2632":"ty10yk","146:2633":"33wz54","146:2634":"1pdo8w3","146:2674":"1ff2djy","146:2675":"1mt962g","146:2676":"bkeuj2","146:2677":"b9s1w","146:2635":"1q1wn2v","146:2636":"7i836j","146:2637":"180v2a2","146:2638":"gn5oeg","146:2639":"1pugz5f","146:2640":"o0p6vd","146:2641":"tcrc3c","146:2642":"hvbs58","146:2644":"a1swu5","146:2645":"1bt4vo9","146:2646":"1wj3kw2","146:2647":"1xa1qkw","146:2648":"sxx82n","146:2649":"9lgak4","146:2650":"107p40o","146:2651":"1blevxg","146:2652":"10cnnqc","146:2653":"8tfoy7","146:2654":"1u6htzj","146:2655":"kq4dqs","146:2656":"mlpj98","146:2657":"1e8anh9","146:2643":"14grsil","146:2678":"19qdyz1","146:2747":"y8oq34"};
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
