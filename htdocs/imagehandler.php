<?php
function detectColors($image, $num, $level = 5) {
  $level = (int)$level;
  $palette = array();
  $size = getimagesize($image);
  $result = array();
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
  
  $opertorCount = 0;
  for($i = 0; $i < $size[0]; $i += $level) {
    for($j = 0; $j < $size[1]; $j += $level) {
      $thisColor = imagecolorat($img, $i, $j);
      $rgb = imagecolorsforindex($img, $thisColor); 
      $color = sprintf('%02X%02X%02X', (round(round(($rgb['red'] / 0x33)) * 0x33)), round(round(($rgb['green'] / 0x33)) * 0x33), round(round(($rgb['blue'] / 0x33)) * 0x33));
      $palette[$color] = isset($palette[$color]) ? ++$palette[$color] : 1;
	  $opertorCount++;
    }
  }
  
  $specificSize = $opertorCount / 2;
  foreach($palette as $key=>$val){
	if($val > $specificSize){
		$result[$key] = $val;
	}
  }
  
  arsort($result);
  return array_slice(array_keys($result), 0, $num);
}

$img = ltrim($_POST['FilePath'], '/');
$num = $_POST['ColorNum'];
$palette = detectColors($img, $num, 1);
$count = count($palette);
$colors = ''; 
foreach($palette as $color) { 
  $colors .= '<li class="colorBlock" style="background-color:#' . $color . ';"></li>';   
} 
if (empty($colors)) {
  $colors = '';
} else {
  $colors = '<ul>' . $colors . '</ul>';
}
echo $count . '|' . $colors;
?>
