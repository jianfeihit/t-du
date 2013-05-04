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

// Define a destination
$targetFolder = '/upload'; // Relative to the root

if (!empty($_FILES)) {
	$tempFile = $_FILES['t-du-file']['tmp_name'];
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['t-du-file']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
		$targetName = uuid();
		$targetFile = rtrim($targetPath,'/') . '/' . $targetName . '.' .$fileParts['extension'];
		$relativeFile = rtrim($targetFolder,'/') . '/' . $targetName . '.' .$fileParts['extension'];
		move_uploaded_file($tempFile,$targetFile);
		
		list($width, $height) = getimagesize($targetFile);
		//"1:320:240:td/20130409/200113_de936b1802be0d8bb2ae27f2be8c2e09.jpg"
		echo '1' . ':' . $width . ':' . $height . ':' . $relativeFile;
	} else {
		echo 'Invalid file type.';
	}
}
?>