// Figma-side diff for the use_figma tool (read-only).
// Returns only layers that are new ("+" = new subtree root, " " = inside a new subtree) or whose own
// properties changed ("~"), in the compact outline format, plus the ids of removed layers.
const FRAME = '145:1448';
const OLD = {"145:1448":"1tbc1ip","145:1449":"1fgcgap","145:1450":"z1tdmi","145:1451":"d06y8v","145:1452":"1np0hhs","145:1453":"rwehde","145:1454":"kgmcyi","145:1455":"jmzsie","145:1456":"cuatce","145:1457":"1gfhyrj","145:1458":"bgyow7","145:1459":"3es01m","145:1460":"1q4etbi","145:1461":"1myo3j3","145:1462":"ojmtnu","145:1463":"139588t","145:1464":"12kbb0","145:1465":"17elbys","145:1466":"4ayf39","145:1467":"o1bf6z","145:1468":"5zba68","145:1469":"11k8plo","145:1470":"1ggofrl","145:1471":"18jipqs","145:1472":"cqm8yx","145:1473":"hz3sxn","145:1474":"ceclz3","145:1475":"4u8gko","145:1476":"1r59fgm","145:1477":"vkyofk","145:1478":"1ej0zh2","145:1479":"15rbasa","145:1480":"1t11bf8","145:1481":"1e1acm8","145:1482":"b1ym12","145:1483":"cx2s8g","145:1484":"17lvvj5","145:1485":"mxg7ia","145:1486":"1obc4eg","145:1487":"1mtr8lw","145:1488":"1ob9bko","145:1489":"k3llvt","145:1490":"h2h2fo","145:1491":"1pwgb4a","145:1492":"i2fmmd","145:1493":"zt3hl3","145:1494":"100zcbm","145:1495":"lwc89p","145:1496":"1veof50","145:1497":"1jxzar4","145:1498":"1pzeswr","145:1506":"gezd8q","145:1507":"s6serx","145:1508":"1akgqjo","145:1509":"11kn59m","145:1510":"8f5qxp","145:1511":"p82i1l","145:1512":"r8vk1l","145:1513":"1m0323p","145:1556":"qhrawv","145:1520":"1jnwzpr","145:1521":"lktd9g","145:1522":"1mpflav","145:1523":"49djvg","145:1524":"1ip1l0x","145:1561":"12qbo03","145:1562":"164vmmd","145:1563":"1arae83","145:1529":"vf3d4y","145:1530":"bvyose","145:1531":"1nkdmwx","145:1532":"9iijv","145:1533":"1tkwk6u","145:1564":"zkp53s","145:1565":"1d96xen","145:1566":"1whlh9h","145:1537":"1ao9mkf","145:1538":"1c0jg64","145:1539":"pxxhnl","145:1548":"7ydatn","145:1549":"1kboih","145:1550":"1lumcxv","145:1551":"1k5qtcb","145:1552":"hme275","145:1553":"mydi9c","145:1554":"1u3wv96","145:1555":"mpgtt","145:1567":"6ujvf2","145:1568":"1v8gh24","145:1569":"tor9gi","145:1570":"1uh54s5","145:1571":"1dh45id","145:1572":"oyos00","145:1573":"1xg0qs0","145:1574":"4ws5ml","145:1575":"gv728j","145:1576":"1e6zuvx","145:1577":"8ygkwv","145:1578":"iphghy","145:1579":"z6guoz","145:1580":"1aj78iu","145:1581":"37weri","145:1582":"roeut","145:1583":"1l9qo3b","145:1584":"vcs1la","145:1585":"jae4b0","145:1586":"1cn0xhb","145:1587":"owzrb8","145:1588":"dgnf51","145:1589":"ledl3","145:1590":"uo5xzw","145:1591":"1xhzoi5","145:1592":"go8bwh","145:1593":"17pmjuw","145:1594":"b0th1w","145:1595":"6vn02d","145:1596":"1igqaeq","145:1597":"141sd0m","145:1598":"cf4qpf","145:1599":"1ae6nqm","145:1600":"bujfma","145:1601":"14zc7hn","145:1602":"12km9wn","145:1603":"1wlk6pg","145:1604":"q9c6u2","145:1605":"brko35","145:1610":"qk8u31","145:1611":"o44s0r","145:1612":"1dqhqal","145:1613":"143534k","145:1614":"w3w85k","145:1615":"1igl90h","145:1616":"iz347g","145:1617":"frcgdf","145:1618":"w4tih0","145:1619":"1y0hd4w","145:1620":"p0y88h","145:1621":"1ec1f3b","145:1622":"ejgs8m","145:1623":"1invm35","145:1626":"vwzlso","145:1627":"vpoxiq","145:1628":"x2l28","145:1629":"83br1x","145:1630":"id9a2u","145:1631":"zsm7k3","145:1632":"1uaufex","145:1633":"gzd2mc","145:1644":"v2dk36","145:1645":"va5npc","145:1646":"hkil4z","145:1647":"z95zs3","145:1634":"1d7pmed","145:1635":"w3i37t","145:1636":"gvr291","145:1637":"17khsgf","145:1638":"7aitgc","145:1639":"196156u","145:1640":"1iwvgmc","145:1641":"ki4k34","145:1642":"1iswxg8","145:1643":"19c4b67","145:1648":"sila1w","145:1725":"sxab37","145:1763":"dfawnu"};
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
