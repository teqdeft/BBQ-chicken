// Figma-side diff for the use_figma tool (read-only).
// Returns only layers that are new ("+" = new subtree root, " " = inside a new subtree) or whose own
// properties changed ("~"), in the compact outline format, plus the ids of removed layers.
const FRAME = '149:2814';
const OLD = {"149:2814":"1d4hmru","149:2815":"1cs791k","149:2816":"y3d4b","149:2817":"1khfxim","149:2818":"1778o4i","149:2819":"1ihysgx","149:2820":"1eg2jje","149:2821":"1vuh1a9","149:2822":"1vyh3i1","149:2823":"zqfs4p","149:2824":"1suzhrt","149:2825":"1vud5vc","149:2826":"7kd0pd","149:2827":"1a16g04","149:2828":"1ik0qhw","149:2829":"qac4yd","149:2830":"1az8sai","149:2831":"19bd32s","149:2832":"1se7pn4","149:2833":"19ylw29","149:2834":"7w457j","149:2835":"1l6az4a","149:2836":"1097lij","149:2837":"qxp2f6","149:2838":"zxzqok","149:2839":"zz753i","149:2840":"yezgn3","149:2841":"1nwz4fp","149:2842":"3nb8ar","149:2843":"1j8etm3","149:2844":"4ot87w","149:2845":"1a1w1ep","149:2846":"1lm3hm4","149:2847":"1bqbig3","149:2848":"37igbl","149:2849":"poybiw","149:2850":"11yszbm","149:2851":"142yybx","149:2852":"l6hd92","149:2853":"ek5cie","149:2854":"tlhxur","149:2855":"g6xj57","149:2856":"r0q23l","149:2857":"1tu8szq","149:2858":"16271wc","149:2859":"1n6jg7v","149:2860":"1at5d0t","149:2861":"sv6dvo","149:2862":"1d1k3bf","149:2863":"n36jt2","149:2871":"1ibhn7k","149:2872":"vancsp","149:2873":"mbxeaq","149:2874":"1s08o58","149:2875":"e63zrn","149:2876":"4zni95","149:2877":"dgt64n","149:2878":"1otkgwr","149:2921":"5zhvca","149:2885":"1dvs75k","149:2886":"pinmgt","149:2887":"1haru0m","149:2888":"619fwt","149:2889":"1x0dc5q","149:2926":"q54zgf","149:2927":"irohgz","149:2928":"n79w9f","149:2894":"4dnfh6","149:2895":"1359ybd","149:2896":"4ljhu2","149:2897":"utieqj","149:2898":"zuoihp","149:2929":"18igvuc","149:2930":"1v8ht1q","149:2931":"1kst3ua","149:2902":"1opdu66","149:2903":"1jur8iv","149:2904":"30jp5m","149:2913":"1axpro2","149:2914":"nx06rt","149:2915":"vjcsh6","149:2916":"14z1igi","149:2917":"1csjhtf","149:2918":"rcve7u","149:2919":"l4gsma","149:2920":"2bz2ct","149:2932":"7cc0ic","149:2933":"14zej9d","149:2934":"afd0wk","149:2935":"3ila1k","149:2936":"a6erif","149:2937":"1c5cq27","149:2938":"o9qlr7","149:2939":"1sb15e9","149:2940":"16iw297","149:2941":"153bdf2","149:2942":"16y9s2k","149:2943":"xfc29t","149:2944":"1l8w7gu","149:2945":"dhtqmw","149:2946":"8kztr8","149:2947":"1ysh7wc","149:2948":"s9655i","149:2949":"jt66jm","149:2950":"1jywegf","149:2951":"12c6xu","149:2952":"k8p2r7","149:2957":"urqm2l","149:2958":"1tj6d3r","149:2959":"w9o1pl","149:2960":"1o1biao","149:2961":"1d319j2","149:2962":"dl79m1","149:2963":"zluhlv","149:2964":"zv78b9","149:2965":"r7dfsc","149:2966":"wavhvu","149:2967":"1x8nas9","149:2968":"y79zki","149:2969":"15i1bmv","149:2970":"1hye1wt","149:2973":"1hjz0ot","149:2974":"rfx82t","149:2975":"2qmdtr","149:2976":"ca43ty","149:2977":"1eqlzy","149:2978":"iw5h8t","149:3002":"1dn1hjv","149:3003":"tbmyxf","149:3004":"11o71ek","149:3005":"1fpev95","149:2979":"goz0ef","149:2980":"1v1las","149:2981":"dcw2nz","149:2982":"1nh5p7i","149:2983":"11fl3vg","149:2984":"1i9f1cd","149:2985":"s58wsg","149:2986":"71mfhi","149:2987":"1p96w5y","149:2988":"i07ale","149:2989":"r1bsrj","149:2990":"1vcxps3","149:2991":"1i5mj0k","149:2992":"1fcps4m","149:2993":"u6sh6f","149:2994":"rrrhpq","149:2995":"upewsc","149:2996":"fs234m","149:2997":"4tuqzz","149:2998":"aux2qc","149:2999":"ueh785","149:3000":"1k4qaij","149:3001":"9u9d5u","149:3006":"1lgmy39","149:3075":"1qv39am","149:3096":"1rjetz8"};
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
