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

/**
* ��jpegͼƬ��ĳ��������ɫ͸������ת��gifͼƬ
* @param string $jpg_img �����ļ���ַ
* @param string $bg_color ������ɫ����ʽ ���� #ffffff
* @param int $alpha ͼƬ͸���� ��ֵ�� 0 �� 127��0 ��ʾ��ȫ��͸����127 ��ʾ��ȫ͸����
* @param float $radio RGB��ɫ�������ӣ�0-1
* @return boolen
**/
//function jpeg2transpng($jpg_img,$png_img,$bg_color,$alpha,$radio){
function jpeg2transpng($image, $bg_color, $alpha = 0, $radio = 0.618, $filePath){
  $size = getimagesize($image);
  switch($size['mime']) {
    case 'image/jpeg':
      $im_in = imagecreatefromjpeg($image);
      break;
    case 'image/png':
      $im_in = imagecreatefrompng($image);
      break;
    case 'image/gif':
      $im_in = imagecreatefromgif($image);
      break;
    default:
      return FALSE;
  }
  if(!$im_in) {
    return false;
  }

  //����͸������
  $im_out =imagecreatetruecolor($size[0], $size[1]);
  imagealphablending($im_out, true);
  imagesavealpha($im_out, true);
  $trans_colour = imagecolorallocatealpha($im_out, 0, 0, 0, 127);
  imagefill($im_out, 0, 0, $trans_colour);

  //�趨͸��ɫ
  $red = intval( hexdec(substr($bg_color,1,2))*$radio );
  $green = intval( hexdec(substr($bg_color,3,2))*$radio);
  $blue = intval( hexdec(substr($bg_color,5,2))*$radio);

  //���ؼ���ͼƬ�ϳ�
  for ($j=0;$j<=$size[1]-1;$j++)
  {
      for ($i=0;$i<=$size[0]-1;$i++)
      {
        $rgb = imagecolorat($im_in,$i,$j);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
       if ($r>=$red && $g>=$green && $b>=$blue)
        {
            //echo '.';
          continue;
        }
        //echo "<a href='#".dechex($r).dechex($g).dechex($b)."'>*</a>";
          $color=imagecolorallocatealpha($im_out,$r,$g,$b,$alpha);
         imagesetpixel($im_out,$dst_x+$i,$dst_y+$j,$color);
      }
      //echo "\n";
  }

  //����ͼƬ
  //imagepng($im_out,$png_img);
  imagepng($im_out, $filePath);
  imagedestroy($im_in);
  imagedestroy($im_out);

  return true;
}

$img = ltrim($_POST['FilePath'], '/');
$color = $_POST['Color'];
$filePath = 'upload/0000.png';
$result = jpeg2transpng($img, $color, 60, 0.618, $filePath);
if ($result) {
  echo '1';
} else {
  echo '0';
}

?>
