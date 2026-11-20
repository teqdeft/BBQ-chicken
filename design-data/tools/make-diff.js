#!/usr/bin/env node
// Builds ready-to-run use_figma code that lists what changed in a frame since design-data/frame_<id>.json.
// Usage: node design-data/tools/make-diff.js <frame-id>   -> writes design-data/diffs/code_<id>.js and prints its path
const fs = require('fs');
const path = require('path');
const { execFileSync } = require('child_process');
const id = process.argv[2];
const hashes = execFileSync(process.execPath, [path.join(__dirname, 'node-hashes.js'), id]).toString();
const code = fs.readFileSync(path.join(__dirname, 'figma-diff-template.js'), 'utf8')
  .replace("const FRAME = '__FRAME__';", () => "const FRAME = '" + id + "';")
  .replace('const OLD = __OLD__;', () => 'const OLD = ' + hashes.trim() + ';');
const outDir = path.join(__dirname, '..', 'diffs');
fs.mkdirSync(outDir, { recursive: true });
const out = path.join(outDir, 'code_' + id.replace(':', '-') + '.js');
fs.writeFileSync(out, code);
console.log(out, code.length + ' chars');
