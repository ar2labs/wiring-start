<?php
$imagePath = 'public/img/wiring-logo.png';
if (!file_exists($imagePath)) {
    echo "Image not found at $imagePath\n";
    exit;
}

if (!extension_loaded('gd')) {
    echo "GD extension not loaded. Let's try reading the file header or using basic PHP.\n";
    exit;
}

$im = imagecreatefrompng($imagePath);
if (!$im) {
    echo "Failed to load image.\n";
    exit;
}

$width = imagesx($im);
$height = imagesy($im);
$colors = [];

// Sample pixels to find dominant colors
for ($x = 0; $x < $width; $x += max(1, intval($width / 20))) {
    for ($y = 0; $y < $height; $y += max(1, intval($height / 20))) {
        $rgb = imagecolorat($im, $x, $y);
        $cols = imagecolorsforindex($im, $rgb);
        // Exclude transparent or white or very light gray backgrounds
        if ($cols['alpha'] > 100 || ($cols['red'] > 240 && $cols['green'] > 240 && $cols['blue'] > 240)) {
            continue;
        }
        $hex = sprintf("#%02x%02x%02x", $cols['red'], $cols['green'], $cols['blue']);
        if (!isset($colors[$hex])) {
            $colors[$hex] = 0;
        }
        $colors[$hex]++;
    }
}

arsort($colors);
echo "Dominant colors found:\n";
foreach (array_slice($colors, 0, 10, true) as $hex => $count) {
    echo "$hex: $count times\n";
}
