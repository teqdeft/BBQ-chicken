// Figma-side diff for the use_figma tool (read-only).
// Returns only layers that are new ("+" = new subtree root, " " = inside a new subtree) or whose own
// properties changed ("~"), in the compact outline format, plus the ids of removed layers.
const FRAME = '141:754';
const OLD = {"141:754":"1bqkb3m","141:755":"7v1xq9","141:756":"1h3syzq","141:757":"wmf0jz","141:758":"vbweo7","141:759":"ivlhzn","141:760":"1x5spom","141:761":"l7fx8q","141:762":"18qe6f","141:763":"10gqnga","141:764":"1a01bvi","141:765":"rwmt9y","141:766":"5oy3y2","141:767":"12pyea3","141:768":"1ke8xvv","141:769":"yhenex","141:770":"8zcxyr","141:771":"1tk2c96","141:772":"1z04wgw","141:773":"1kubnqa","141:774":"unzqq0","141:775":"dzk8kr","141:776":"1ryptk3","141:777":"1ohd05m","141:778":"ly15o0","141:779":"1ivy88k","141:780":"5ehtjy","141:781":"6906op","141:782":"1y3d89","141:783":"19ow66b","141:784":"1luulrm","141:785":"rjtcs6","141:786":"1eb17tu","141:787":"1oiamte","141:788":"et6tps","141:789":"fu45d1","141:790":"1cnp8vk","141:791":"delmpo","141:792":"nss2v4","141:793":"f8mlfj","141:794":"h097zm","141:795":"zjywy2","141:796":"1hgepw","141:797":"1kbntaq","141:798":"12p3l15","141:799":"1ulsy93","141:800":"10vqm6n","141:801":"s9ve14","141:802":"qgkg2y","141:803":"lya4jh","141:804":"sch3f2","141:805":"o8gx33","141:806":"1lvhi6f","141:807":"12gh4i8","141:815":"1egfki3","141:816":"bhg4ft","141:817":"1qx4218","141:818":"1fslzw0","141:819":"nlxus8","141:820":"1s7u5tb","141:821":"14pdosx","141:822":"1gs3s83","141:823":"1y0szmz","141:824":"xvnfpq","141:825":"1pmlruu","141:875":"vbuv4v","141:829":"1ke6074","141:830":"drxo49","141:831":"1euzw0v","141:832":"11a3dzj","141:833":"u7tyxu","141:834":"1228142","141:835":"6bmp5f","141:881":"c90ylb","141:882":"1cx0k2k","141:883":"14em1mr","141:839":"e65sk7","141:840":"1fmnonl","141:841":"tvahj4","141:842":"f3eqk0","141:843":"1hrwwud","141:844":"1lc7ju7","141:845":"si6g0b","141:884":"10r1hpq","141:885":"djnw3x","141:886":"1jvtjic","141:850":"684j0y","141:851":"1mfxoeb","141:852":"6gs11s","141:853":"1t3ijld","141:854":"jg1x4p","141:855":"z0kodp","141:856":"9rlcnm","141:887":"pnb8j0","141:888":"1buoj56","141:860":"7v65qr","141:861":"3s82jb","141:862":"1em38cf","141:863":"1ww0giw","141:864":"1niqnmi","141:865":"gfypn7","141:866":"nnh79e","141:889":"1mhqvkc","141:870":"1b36rd0","141:871":"14hl4uf","141:872":"1lxb8bi","141:873":"vn4c2u","141:895":"1ddw8mo","141:896":"1p57cpy","141:897":"loj4d4","141:898":"jpkcg2","141:899":"zwdu07","141:900":"m4ybwv","141:901":"1ho5fcb","141:902":"6djh1s","141:903":"u4v2vk","141:904":"13wllwd","141:905":"deuo52","141:906":"g3j4z0","141:907":"my1d6z","141:908":"12x3wmq","141:909":"1lglcud","141:910":"w2ihzv","141:911":"tsr2mo","141:912":"oy6qzo","141:913":"go7mds","141:914":"1dzewtn","141:915":"10wp0bw","141:916":"c1ngu9","141:917":"a4hzow","141:918":"1n64rd5","141:919":"1rpjigd","141:920":"1expbze","141:921":"uvsmcr","141:922":"1ag6m2z","141:923":"n4mat0","141:924":"18vdtcq","141:925":"6pl9vh","141:926":"1xnkhaz","141:927":"12qkfjk","141:928":"1w3sc1l","141:929":"9woyc1","141:964":"15cgg1e","141:965":"2u2a0m","141:966":"1494l81","141:967":"1uhusur","141:935":"z9f1mk","141:936":"1ur93ii","141:937":"rgj9v2","141:938":"nhiaji","141:939":"1rnmwzi","141:940":"5j8s43","141:941":"lh11n7","141:942":"7kzss6","141:943":"1eg6d7p","141:944":"1kndfgl","141:945":"163fjqn","141:968":"xhklbj","141:969":"bsu8j2","141:970":"qeo11l","141:971":"14rig5y","141:930":"6dms1t","141:931":"u14bvf","141:932":"17l8fkb","141:933":"c0avys","141:934":"10jjgco","141:972":"xffrf4","141:973":"114lt5x","141:974":"14eale9","141:975":"jnr0u2","141:976":"83n8sg","141:977":"1x2lmnx","141:978":"9eqdo9","141:979":"7458zu","141:946":"12cf9so","141:947":"sj7lmm","141:948":"9jfl7o","141:949":"1ks5bkr","141:950":"cookj6","141:951":"11w7zyb","141:952":"14od1h9","141:953":"1niy9vi","141:980":"1kdis9g","141:981":"1kyblv0","141:982":"fg8bad","141:983":"jlm6sl","141:954":"1q4rtdz","141:955":"waezh1","141:956":"1oe8v67","141:957":"1ii6b03","141:958":"davrea","141:959":"4jkib0","141:960":"ag06w","141:961":"2xqiue","141:962":"n7eoig","141:963":"1xv1nfb","141:984":"19z2jum","141:1061":"9i9nyl","141:1099":"6b6xx2"};
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
