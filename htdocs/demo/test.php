<?php

$left = 53 * 2;
$top = 73 * 2;
$width = 96;
$height = 136;
$img_src = '2.png';

$size = getimagesize($img_src);
$original_width = $size[0];
$original_height = $size[1];

$dest = imagecreatefrompng('b_f.png');
$src = imagecreatefrompng($img_src);

$newImg = imagecreatetruecolor($width, $height);
imagealphablending($newImg, false);
imagesavealpha($newImg, true);
$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
imagefilledrectangle($newImg, 0, 0, $width, $height, $transparent);
imagecopyresampled($newImg, $src, 0, 0, 0, 0, $width, $height, $original_width, $original_height);

imagealphablending($dest, true);
imagesavealpha($dest, true);
imagecopy($dest, $newImg, $left, $top, 0, 0, $width, $height);


header('Content-Type: image/png');
imagepng($dest);

?>