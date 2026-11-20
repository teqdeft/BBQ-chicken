const FRAME = '144:1214';
const OLD = {"144:1214":"19726n5","144:1215":"1wx2wyr","144:1216":"1y14q5f","144:1217":"b4vmr5","144:1218":"gzuoqq","144:1219":"qws2jr","144:1220":"1fxev66","144:1221":"11pea3m","144:1222":"cthotv","144:1223":"55i5jb","144:1224":"3tvgcv","144:1225":"1ffzuen","144:1226":"to5of2","144:1227":"3gk81o","144:1228":"1qiij7m","144:1229":"sjadjg","144:1230":"1xcwwz4","144:1231":"19e8sc0","144:1232":"9sqk0j","144:1233":"kxgxpx","144:1234":"ckgdnq","144:1235":"ufe3cu","144:1236":"18szztg","144:1237":"3ll8dr","144:1238":"10huvfe","144:1239":"31v57a","144:1240":"iacwzf","144:1241":"196qv18","144:1242":"1bztn76","144:1243":"b1w20c","144:1244":"1w3m4ii","144:1245":"cvw1r2","144:1246":"570szl","144:1247":"1d3cjg9","144:1248":"ngt2c9","144:1249":"3w8qw5","144:1250":"5xrdmf","144:1251":"6uvius","144:1252":"1lnzlfq","144:1253":"1r0zhfa","144:1254":"14a3t6i","144:1255":"n7od7r","144:1256":"nn823","144:1257":"1jpmukv","144:1258":"if6tci","144:1259":"gwxkfy","144:1260":"1m1qyei","144:1261":"6dnmp1","144:1262":"r8qelo","144:1263":"p56t1k","144:1264":"uy3pkr","144:1272":"65c5kr","144:1273":"m08tza","144:1274":"11dyv9b","144:1275":"16nzk9x","144:1276":"1j2xse2","144:1277":"1f4pbbv","144:1278":"dkkz1g","144:1279":"1phw8q1","144:1280":"1iodfjb","144:1281":"5q3wbm","144:1282":"xl3neo","144:1283":"155yik4","144:1284":"1pp3l4s","144:1285":"1t64764","144:1286":"b9x0uf","144:1287":"1ylkirs","144:1288":"1idallc","144:1289":"d3vc06","144:1290":"6pumeh","144:1291":"15pamu6","144:1292":"iuhrp8","144:1293":"wl59ua","144:1294":"fwp8q6","144:1295":"iwsszu","144:1296":"1yq8knx","144:1297":"1xgji0b","144:1298":"1rbe14r","144:1299":"7aocyv","144:1300":"16t25rv","144:1301":"eo4h7v","144:1302":"lqpuwt","144:1303":"1351hlo","144:1304":"1yntn9e","144:1305":"xu50sw","144:1306":"1i82728","144:1307":"1f2kieg","144:1308":"1hlejyh","144:1309":"1p5izj7","144:1310":"1hwp81m","144:1311":"v3gwpm","144:1312":"1hisozi","144:1313":"1tn9xy6","144:1314":"1c5hq0h","144:1315":"11qw491","144:1316":"1cneegh","144:1317":"kp26c3","144:1318":"1l5ealr","144:1319":"12fob54","144:1320":"1relzhp","144:1321":"z6zgo9","144:1322":"7mqrx5","144:1323":"18mf5wl","144:1324":"18ozz0c","144:1325":"y47t16","144:1326":"pxb11o","144:1327":"1hwxsyu","144:1328":"1li4plc","144:1329":"1eo1vqb","144:1330":"6dx8ot","144:1331":"qbn59y","144:1332":"4h39uj","144:1666":"2b5tn9","144:1667":"3hjorh","144:1668":"11z8riu","144:1669":"1qqx19w","144:1670":"12p1etu","144:1671":"2pcp75","144:1672":"1vmv7ok","144:1673":"uryj5s","144:1674":"1szfwv4","144:1675":"1b8ec69","144:1676":"1fahrmc","144:1677":"6ntibc","144:1678":"14z723i","144:1679":"e533pd","144:1680":"43lr6r","144:1681":"1we17o1","144:1682":"t476tt","144:1683":"69c79i","144:1684":"mtiju0","144:1685":"1eglx7u","144:1686":"1w40nd0","144:1687":"1yxctxw","144:1688":"vk5hn3","144:1689":"1uniti3","144:1690":"k7y0da","144:1691":"1xpri94","144:1692":"r7cg6d","144:1693":"71afs6","144:1694":"tsml28","144:1695":"mp668s","144:1696":"x3ttk4","144:1697":"iw98od","144:1698":"8n8f5l","144:1699":"1vzicgd","144:1700":"evg83w","144:1701":"k6h3xw","144:1702":"147fzex","144:1703":"13h2ku4","144:1704":"1ixbb7n","144:1705":"2l90il","144:1706":"z8jwp0","144:1714":"s5ogw9","144:1715":"15zb24g","144:1716":"n1ibef","144:1717":"7f8bxs","144:1718":"1551h3p","144:1426":"ncfp6u","144:1503":"1w10cm1","144:1541":"1ad4vi3"};
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
