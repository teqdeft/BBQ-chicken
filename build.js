#!/usr/bin/env node
/*
 * Tiny static build: assembles src/pages/*.html with the shared partials
 * (head, header, footer) and writes the finished pages to the project root.
 *
 *   node build.js
 *
 * Each page starts with a settings comment, for example:
 *   <!-- page {"title": "…", "description": "…", "active": "franchise", "bodyClass": "page-home"} -->
 * Placeholders:
 *   {{icon:name}}       inline SVG icon (see ICONS below)
 *   {{current:key}}     aria-current="page" when key matches the page's "active"
 */
const fs = require('fs');
const path = require('path');

const ROOT = __dirname;
const SRC = path.join(ROOT, 'src');
const read = p => fs.readFileSync(path.join(SRC, p), 'utf8');

const ICONS = {
  arrow: '<svg viewBox="0 0 10 10" fill="none" aria-hidden="true"><path d="M3.5 1.5 7 5 3.5 8.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>',
  chevdown: '<svg class="chev" viewBox="0 0 10 10" fill="none" aria-hidden="true"><path d="M2 3.5 5 6.5 8 3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
  left: '<svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M13 8H3m4-4L3 8l4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
  right: '<svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
  sparkle: '<svg class="marquee__spark" viewBox="0 0 10 10" aria-hidden="true"><path d="M5 0C5.375 3 7 4.625 10 5C7 5.375 5.375 7 5 10C4.625 7 3 5.375 0 5C3 4.625 4.625 3 5 0Z" fill="currentColor"/></svg>',
  sparkleplain: '<svg viewBox="0 0 10 10" aria-hidden="true"><path d="M5 0C5.375 3 7 4.625 10 5C7 5.375 5.375 7 5 10C4.625 7 3 5.375 0 5C3 4.625 4.625 3 5 0Z" fill="currentColor"/></svg>',
  instagram: '<svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M6.667 2.083h6.666a4.583 4.583 0 0 1 4.584 4.584v6.666a4.583 4.583 0 0 1-4.584 4.584H6.667a4.583 4.583 0 0 1-4.584-4.584V6.667a4.583 4.583 0 0 1 4.584-4.584Z" stroke="currentColor" stroke-width="1.667"/><path d="M13.583 10a3.583 3.583 0 1 1-7.166 0 3.583 3.583 0 0 1 7.166 0Z" stroke="currentColor" stroke-width="1.667"/><circle cx="14.5" cy="5.5" r="1.083" fill="currentColor"/></svg>',
  facebook: '<svg viewBox="0 0 20 20" aria-hidden="true"><path d="M11.25 17.5v-6.25h2.167l.333-2.5h-2.5V7.167c0-.75.25-1.25 1.333-1.25h1.334v-2.25c-.25 0-1-.084-1.917-.084-1.917 0-3.25 1.167-3.25 3.334V8.75H6.667v2.5H8.75v6.25h2.5Z" fill="currentColor"/></svg>',
  linkedin: '<svg viewBox="0 0 20 20" aria-hidden="true"><path d="M5.917 7.5h-3v9.583h3V7.5ZM4.417 6.167a1.75 1.75 0 1 0 0-3.5 1.75 1.75 0 0 0 0 3.5ZM8.333 7.5h2.834v1.333c.416-.75 1.416-1.583 3-1.583 3 0 3.583 2 3.583 4.5v5.333h-3v-4.75c0-1.166 0-2.583-1.583-2.583s-1.834 1.25-1.834 2.5v4.833h-3V7.5Z" fill="currentColor"/></svg>',
  heart: '<svg viewBox="0 0 14 13" aria-hidden="true"><path d="M7 12.683 6.008 11.75C2.45 8.541 0 6.325 0 3.641 0 1.6 1.575.083 3.558.083c1.109 0 2.217.525 2.975 1.342h.934C8.225.608 9.333.083 10.442.083 12.425.083 14 1.6 14 3.641c0 2.684-2.45 4.9-6.008 8.109L7 12.683Z" fill="#E31937"/></svg>',
};

// "Since 1995" stamp: yellow disc, ring, text on a circle, emblem in the middle.
const STAMP = `<svg viewBox="0 0 184 184" aria-hidden="true"><defs><path id="stampPath" d="M92 32a60 60 0 1 1 0 120a60 60 0 1 1 0-120"/></defs><circle cx="92" cy="92" r="92" fill="#F2B33D"/><circle cx="92" cy="92" r="83" fill="none" stroke="#221E1F" stroke-width="1.5"/><text font-family="Pretendard, sans-serif" font-weight="800" font-size="15" fill="#221E1F" letter-spacing="1.6"><textPath href="#stampPath" startOffset="0" textLength="372" lengthAdjust="spacing">SINCE 1995 • KOREAN FRIED CHICKEN •</textPath></text><image href="assets/svg/stamp-emblem.svg" x="63" y="62.7" width="58" height="58.7"/></svg>`;

function render(file) {
  let src = fs.readFileSync(path.join(SRC, 'pages', file), 'utf8');
  const m = src.match(/^<!--\s*page\s+(\{[\s\S]*?\})\s*-->\s*/);
  const opts = Object.assign({ title: 'bb.q Chicken Europe', description: '', active: '', bodyClass: '', extraHead: '', extraScripts: '' }, m ? JSON.parse(m[1]) : {});
  if (m) src = src.slice(m[0].length);

  let html = read('partials/head.html') + read('partials/header.html') + '\n<main id="main">\n' + src + '\n</main>\n\n' + read('partials/footer.html');

  let stampCount = 0;
  html = html
    .replace(/\{\{stamp\}\}/g, () => STAMP.replace(/stampPath/g, 'stampPath' + (++stampCount)))
    .replace(/\{\{icon:(\w+)\}\}/g, (_, n) => { if (!ICONS[n]) throw new Error(`Unknown icon "${n}" in ${file}`); return ICONS[n]; })
    .replace(/\{\{current:(\w+)\}\}/g, (_, k) => (k === opts.active ? 'aria-current="page"' : ''))
    .replace(/\{\{(\w+)\}\}/g, (_, k) => (k in opts ? opts[k] : `{{${k}}}`));

  const left = html.match(/\{\{[^}]+\}\}/);
  if (left) throw new Error(`Unresolved placeholder ${left[0]} in ${file}`);
  fs.writeFileSync(path.join(ROOT, file), html.replace(/[ \t]+\n/g, '\n'));
  return file;
}

// node build.js            -> build every page
// node build.js about.html -> build only the named page(s)
const only = process.argv.slice(2);
const pages = fs.readdirSync(path.join(SRC, 'pages')).filter(f => f.endsWith('.html') && (!only.length || only.includes(f)));
let failed = 0;
pages.forEach(f => {
  try { console.log('built', render(f)); }
  catch (e) { failed++; console.error('FAILED', f, '-', e.message); }
});
if (failed) process.exitCode = 1;
