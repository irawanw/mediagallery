<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

//check the extension
$temp = explode('.', $_GET['file']);
$extension = strtolower(end($temp));
//print $extension;

if($_GET['folder']!=''){
	$folder = $_GET['folder'].'/';
	$stamp = imagecreatefrompng('/home/sdc/htdocs/assets/img/sdc-watermark2.png');
}
else{
	$folder = '';
	$stamp = imagecreatefrompng('/home/sdc/htdocs/assets/img/sdc-watermark.png');
}
	

// Load the stamp and the photo to apply the watermark to

switch($extension){
	case "jpg":
		$im = imagecreatefromjpeg('/home/sdc/htdocs/admin/server/php/files/'.$_GET['id'].'/'.$folder.$_GET['file']);
		break;
	case "png":
		$im = imagecreatefrompng('/home/sdc/htdocs/admin/server/php/files/'.$_GET['id'].'/'.$folder.$_GET['file']);
		break;
	case "gif":
		$im = imagecreatefromgif('/home/sdc/htdocs/admin/server/php/files/'.$_GET['id'].'/'.$folder.$_GET['file']);
		break;
}

// Set the margins for the stamp and get the height/width of the stamp image
$marge_right = 10;
$marge_bottom = 10;
$sx = imagesx($im);
$sy = imagesy($im);

// Copy the stamp image onto our photo using the margin offsets and the photo 
// width to calculate positioning of the stamp. 
//imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

// Set the tile
imagesettile($im, $stamp);

// Make the image repeat
imagefilledrectangle($im, 0, 0, $sx, $sy, IMG_COLOR_TILED);

// Output and free memory
header('Content-type: image/jpeg');
imagejpeg($im);
imagedestroy($im);
?>