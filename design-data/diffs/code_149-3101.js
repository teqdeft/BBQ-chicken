// Figma-side diff for the use_figma tool (read-only).
// Returns only layers that are new ("+" = new subtree root, " " = inside a new subtree) or whose own
// properties changed ("~"), in the compact outline format, plus the ids of removed layers.
const FRAME = '149:3101';
const OLD = {"149:3101":"1upq0e9","149:3102":"1sj5d4v","149:3103":"xf46gf","149:3104":"12pfn9g","149:3105":"f11m9e","149:3106":"109e01t","149:3107":"gds52v","149:3108":"jhrbjv","149:3109":"v85vpk","149:3110":"1ctdi6d","149:3111":"k5kqh7","149:3112":"1rjvmpa","149:3113":"13kd5hb","149:3114":"1tnp7y2","149:3115":"mpbwu2","149:3116":"oj2a48","149:3117":"1lra52s","149:3118":"cegt3l","149:3119":"w9l226","149:3120":"1yq9grz","149:3121":"rwvkhr","149:3122":"12r7088","149:3123":"4fd70r","149:3124":"1azrf04","149:3125":"1b2vss","149:3126":"2gklek","149:3127":"yng4hq","149:3128":"z6u4me","149:3129":"2miyxy","149:3130":"1l4gwin","149:3131":"10in0gy","149:3132":"9wsng9","149:3133":"1z05iey","149:3134":"1o644dj","149:3135":"1b4n8zj","149:3136":"l2xewo","149:3137":"6x2o7z","149:3138":"188p3se","149:3139":"1r4o48j","149:3140":"dkvsho","149:3141":"3to9fz","149:3142":"2j3g21","149:3143":"16d8qr9","149:3144":"1n3rgaw","149:3145":"1dehy4o","149:3146":"1hx9vip","149:3147":"mgg5li","149:3148":"12iokst","149:3149":"1mpg8b4","149:3150":"t5k0fu","149:3158":"1vwvaf7","149:3159":"3xt37w","149:3160":"rkrmbs","149:3161":"qkkow4","149:3162":"mcpd7","149:3163":"17i5txb","149:3164":"b5bf4r","149:3165":"ciz3w1","149:3209":"1671hkr","149:3172":"14ei79k","149:3173":"azwnuv","149:3174":"1agwg6w","149:3208":"16t2x8g","149:3175":"1w42aag","149:3176":"1snbd9f","149:3214":"nl2z2t","149:3181":"1v33adi","149:3182":"1qs6yj3","149:3183":"1qnh1i2","149:3213":"1t4fcee","149:3184":"hoe3rq","149:3185":"jge7eu","149:3219":"jjq4l1","149:3220":"o051ih","149:3221":"11j6h4f","149:3189":"1ilfvtq","149:3190":"14lhqkm","149:3191":"s3h5qf","149:3218":"t72ker","149:3200":"kwdug0","149:3201":"1rn1ltj","149:3202":"1vvuqtc","149:3203":"q9x8ck","149:3204":"y4cv11","149:3205":"1yzifa8","149:3206":"123x2hu","149:3207":"zmqfna","149:3222":"k93j6h","149:3223":"rq8f2m","149:3224":"10ydoca","149:3225":"1alco5t","149:3226":"t2sa7e","149:3227":"lseqk3","149:3228":"vo0ll0","149:3229":"7qh0lb","149:3230":"d2zcu2","149:3231":"14y8426","149:3232":"jx4d28","149:3233":"u90c8c","149:3234":"17a8baa","149:3235":"2gag8","149:3240":"1obdu9f","149:3241":"182zdyl","149:3242":"at58z9","149:3243":"18qz09f","149:3244":"1krolvz","149:3285":"1wpjuw1","149:3286":"3al0o","149:3287":"rnjdr2","149:3288":"11rh4bg","149:3262":"yz3vc7","149:3263":"1jv0a8n","149:3264":"145253w","149:3265":"7cw58f","149:3266":"18r5u8f","149:3267":"39irhz","149:3268":"giod6m","149:3269":"ahr33","149:3270":"97l04z","149:3271":"1ve4ua2","149:3272":"1eipm8n","149:3273":"wsaatc","149:3274":"1vpbxje","149:3275":"c4wqq5","149:3276":"15dnnzq","149:3277":"rwan62","149:3278":"107a3wy","149:3279":"addmal","149:3280":"syawu3","149:3281":"1xmfhjd","149:3282":"4dy89u","149:3283":"14syi2c","149:3284":"1d88xd1","149:3289":"1hvzyfd","149:3358":"ph6vgi","149:3379":"1kh1tju"};
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
