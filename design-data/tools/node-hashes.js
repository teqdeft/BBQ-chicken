#!/usr/bin/env node
// Writes per-node "own property" hashes for a saved Figma frame JSON, ignoring x/y and hug-sized w/h,
// so a Figma-side run of figma-diff-template.js can report only layers whose own properties changed.
// Usage: node node-hashes.js <frame-id> [design-data dir]  -> prints a JSON object { nodeId: hash }
const fs = require('fs');
const path = require('path');
const id = process.argv[2];
const dir = process.argv[3] || path.join(__dirname, '..');
const j = JSON.parse(fs.readFileSync(path.join(dir, 'frame_' + id.replace(':', '-') + '.json'), 'utf8'));
const fnv = s => { let h = 0x811c9dc5; for (let i = 0; i < s.length; i++) { h ^= s.charCodeAt(i); h = Math.imul(h, 0x01000193) >>> 0; } return h.toString(36); };
const own = n => {
  const o = Object.assign({}, n);
  delete o.ch; delete o.x; delete o.y;
  const sz = n.sz || 'FF';
  if (sz[0] !== 'F') delete o.w;
  if (sz[1] !== 'F') delete o.h;
  o.kids = (n.ch || []).map(c => c.id).join(',');
  return fnv(JSON.stringify(o));
};
const out = {};
(function w(n) { out[n.id] = own(n); (n.ch || []).forEach(w); })(j);
process.stdout.write(JSON.stringify(out));
