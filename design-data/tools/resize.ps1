param([string]$map, [string]$src, [string]$dst)
# Resizes images for the web.
# Map file lines: <source-file-name-prefix> <dest-name> <maxWidth>   (# comments allowed)
# PNG keeps transparency; JPG is saved at quality 82.
Add-Type -AssemblyName System.Drawing
New-Item -ItemType Directory -Force $dst | Out-Null
$jpgCodec = [System.Drawing.Imaging.ImageCodecInfo]::GetImageEncoders() | Where-Object { $_.MimeType -eq 'image/jpeg' }
$ep = New-Object System.Drawing.Imaging.EncoderParameters 1
$ep.Param[0] = New-Object System.Drawing.Imaging.EncoderParameter([System.Drawing.Imaging.Encoder]::Quality, [long]82)
foreach ($line in Get-Content $map) {
  if (-not $line.Trim() -or $line.StartsWith('#')) { continue }
  $parts = $line -split '\s+'
  $file = Get-ChildItem $src -File | Where-Object { $_.Name.StartsWith($parts[0]) } | Select-Object -First 1
  if (-not $file) { "MISSING $($parts[0])"; continue }
  $img = [System.Drawing.Image]::FromFile($file.FullName)
  $maxW = [int]$parts[2]
  $w = [math]::Min($maxW, $img.Width); $h = [int]([math]::Round($img.Height * $w / $img.Width))
  $pf = if ($parts[1].EndsWith('.png')) { [System.Drawing.Imaging.PixelFormat]::Format32bppArgb } else { [System.Drawing.Imaging.PixelFormat]::Format24bppRgb }
  $bmp = New-Object System.Drawing.Bitmap $w, $h, $pf
  $g = [System.Drawing.Graphics]::FromImage($bmp)
  $g.InterpolationMode = [System.Drawing.Drawing2D.InterpolationMode]::HighQualityBicubic
  $g.PixelOffsetMode = [System.Drawing.Drawing2D.PixelOffsetMode]::HighQuality
  $g.CompositingQuality = [System.Drawing.Drawing2D.CompositingQuality]::HighQuality
  $g.DrawImage($img, 0, 0, $w, $h)
  $out = Join-Path $dst $parts[1]
  if ($parts[1].EndsWith('.png')) { $bmp.Save($out, [System.Drawing.Imaging.ImageFormat]::Png) }
  else { $bmp.Save($out, $jpgCodec, $ep) }
  $g.Dispose(); $bmp.Dispose(); $img.Dispose()
  "{0} {1}x{2} {3}KB" -f $parts[1], $w, $h, [math]::Round((Get-Item $out).Length / 1KB)
}
