<?php
/**
  * Generates an UUID
  *
  * @author     Anis uddin Ahmad 
  * @param      string  an optional prefix
  * @return     string  the formatted uuid
  */
function uuid($prefix = '')
{
	$chars = md5(uniqid(mt_rand(), true));
	$uuid  = substr($chars,0,8) . '-';
	$uuid .= substr($chars,8,4) . '-';
	$uuid .= substr($chars,12,4) . '-';
	$uuid .= substr($chars,16,4) . '-';
	$uuid .= substr($chars,20,12);
	return $prefix . $uuid;
}

function image2transpng($image, $bg_color, $targetFile, $level = 1){
  $size = getimagesize($image);
  if(!$size) {
    return FALSE;
  }
  switch($size['mime']) {
    case 'image/jpeg':
      $img = imagecreatefromjpeg($image);
      break;
    case 'image/png':
      $img = imagecreatefrompng($image);
      break;
    case 'image/gif':
      $img = imagecreatefromgif($image);
      break;
    default:
      return FALSE;
  }
  if(!$img) {
    return FALSE;
  }
  
  for($i = 0; $i < $size[0]; $i += $level) {
    for($j = 0; $j < $size[1]; $j += $level) {
      $thisColor = imagecolorat($img, $i, $j);
      $rgb = imagecolorsforindex($img, $thisColor); 
      $color = sprintf('%02X%02X%02X', (round(round(($rgb['red'] / 0x33)) * 0x33)), round(round(($rgb['green'] / 0x33)) * 0x33), round(round(($rgb['blue'] / 0x33)) * 0x33));
	  if ($color == $bg_color) {
		imagecolortransparent($img, $thisColor);
	  }
    }
  }
  
  imagepng($img, $targetFile); 
  imagedestroy($img);
  return true;
}

$img = ltrim($_POST['FilePath'], '/');
$color = ltrim($_POST['Color'], '#');
$targetFile = 'upload/' . uuid() . '.png';
$result = image2transpng($img, $color, $targetFile);
if ($result) {
  echo '1:/' . $targetFile;
} else {
  echo '0';
}
?>
