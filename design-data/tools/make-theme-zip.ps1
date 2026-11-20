# Packages the WordPress theme as dist/bbq-chicken.zip (upload under Appearance → Themes → Add New → Upload).
# Usage (from the repo root):  powershell -File design-data/tools/make-theme-zip.ps1
# Entries use forward slashes (Compress-Archive in Windows PowerShell 5 writes backslashes, which break on Linux servers).
$ErrorActionPreference = 'Stop'
Add-Type -AssemblyName System.IO.Compression
Add-Type -AssemblyName System.IO.Compression.FileSystem

$root  = Split-Path -Parent (Split-Path -Parent $PSScriptRoot)
$theme = Join-Path $root 'wp-content\themes\bbq-chicken'
$dist  = Join-Path $root 'dist'
New-Item -ItemType Directory -Force -Path $dist | Out-Null
$zipPath = Join-Path $dist 'bbq-chicken.zip'
if (Test-Path $zipPath) { Remove-Item $zipPath -Force }

$skipDirs  = @('raw', 'node_modules', '.git')
$skipFiles = @('Thumbs.db', 'desktop.ini', '.DS_Store')
$zip = [System.IO.Compression.ZipFile]::Open($zipPath, [System.IO.Compression.ZipArchiveMode]::Create)
try {
  Get-ChildItem $theme -Recurse -File | ForEach-Object {
    $rel = $_.FullName.Substring($theme.Length + 1)
    $parts = $rel -split '\\'
    if (($parts | Where-Object { $skipDirs -contains $_ }).Count -gt 0) { return }
    if ($skipFiles -contains $_.Name -or $_.Extension -eq '.map') { return }
    $entry = 'bbq-chicken/' + ($rel -replace '\\', '/')
    [System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile($zip, $_.FullName, $entry, [System.IO.Compression.CompressionLevel]::Optimal) | Out-Null
  }
} finally {
  $zip.Dispose()
}
'Theme zip: ' + $zipPath + ' (' + [math]::Round((Get-Item $zipPath).Length / 1MB, 1) + ' MB)'
