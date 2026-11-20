const FRAME = '144:1333';
const OLD = {"144:1333":"13hqa9v","144:1334":"9da4sx","144:1335":"144bj5r","144:1336":"1bpeoq8","144:1337":"gxv4bc","144:1338":"iwthw1","144:1339":"1pcd44h","144:1340":"424nl0","144:1341":"1nvorah","144:1342":"vqxrzn","144:1343":"16q6ypb","144:1344":"17l6tzd","144:1345":"f9uh44","144:1346":"phrvna","144:1347":"x3qssf","144:1348":"1o5a0se","144:1349":"114qql5","144:1350":"17mfkwm","144:1351":"13oo10f","144:1352":"ijgesu","144:1353":"1mdaffa","144:1354":"qp06ys","144:1355":"18xt4fs","144:1356":"mv6535","144:1357":"11xh6wi","144:1358":"1804sqc","144:1359":"cbo8rm","144:1360":"121btfu","144:1361":"1o1migu","144:1362":"nvs3ey","144:1363":"o52by2","144:1364":"1al3kds","144:1365":"1bm0w11","144:1366":"1xvmq2r","144:1367":"xihe01","144:1368":"1t41te3","144:1369":"13h7wgk","144:1370":"tbqc56","144:1371":"56wfle","144:1372":"12l9na4","144:1373":"1cqxjui","144:1374":"swlv09","144:1375":"1ktb887","144:1376":"ammvlh","144:1377":"zr0uoa","144:1378":"1oy4x2o","144:1379":"1yr4kmf","144:1380":"10e4ouj","144:1381":"ua39ww","144:1382":"1ghms2q","144:1383":"cs4p57","144:1391":"12lpe4j","144:1392":"6n24go","144:1393":"1x3dxp9","144:1394":"5bl8gz","144:1395":"1rbujjn","144:1396":"1b9f1ur","144:1397":"1ho8xmb","144:1398":"12aosym","144:1399":"1wg3ugk","144:1400":"14wpxa6","144:1401":"1fvbfsj","144:1402":"1txafw8","144:1403":"a26gny","144:1404":"tofaow","144:1405":"clz37t","144:1406":"d0h0xr","144:1407":"er8g9m","144:1408":"j0un4a","144:1409":"1rgt3k3","144:1410":"1rvdu21","144:1411":"1axagg9","144:1412":"6xyje1","144:1413":"5uc33u","144:1414":"rtd5b7","144:1415":"1hbsng4","144:1416":"ewg7de","144:1417":"ghehqm","144:1418":"1x8ekkq","144:1419":"p1heic","144:1420":"1ipmtgc","144:1421":"12srdcm","144:1422":"1kfjeiu","144:1423":"l1iljr","144:1424":"1cuzsr8","144:1425":"1yzsvi3","144:1719":"5o97mw","144:1720":"1qe4ijy","144:1721":"16rbs6","144:1722":"mnz1uy","144:1723":"1ecklc5","144:1724":"ps6dms","144:1725":"1as8jwu","144:1726":"1u1f50m","144:1727":"15xgo8p","144:1728":"ixf4wt","144:1729":"1d3w5cn","144:1730":"1tw3gli","144:1731":"2ppi5e","144:1732":"16ot99z","144:1733":"f4qpo4","144:1734":"83mhk6","144:1735":"19sz9vc","144:1736":"1d5vvbn","144:1737":"fvfcy7","144:1738":"t3e103","144:1739":"1cj3ig7","144:1740":"kl5i0u","144:1741":"v8sker","144:1742":"1hyf9cp","144:1743":"1vbijg7","144:1744":"umkmi5","144:1745":"5wjxcm","144:1746":"150dbnj","144:1747":"1lvd8f1","144:1748":"y4ys5x","144:1749":"tcyhd3","144:1750":"1pcatxf","144:1751":"1jrlkf5","144:1752":"1cytc4z","144:1753":"1x3olpo","144:1754":"17oufje","144:1755":"5bjltp","144:1756":"xx9mqy","144:1757":"hphioz","144:1758":"197v2kf","144:1759":"1qy8grc","144:1767":"zr282f","144:1768":"fpnjjq","144:1769":"1xh3cxh","144:1770":"1r1fcl0","144:1771":"asgb9u","144:1546":"9ks50w","144:1623":"1khz0gf","144:1661":"1i2f91y"};
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
