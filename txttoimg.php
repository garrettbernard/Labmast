<?php

header("Content-type: image/png");
$string = $_GET['text'];
$im     = imagecreatefrompng("./sample.png");
$orange = imagecolorallocate($im, 255, 255, 255);
$px     = (imagesx($im) - 9 * strlen($string)) / 2;
$font	= "Arimo.ttf";
// imagestring($im, 6, $px, 30, stripslashes($string), $orange);
imagettftext ($im,13,0,$px,50,$orange,$font,stripslashes($string));
imagepng($im);
imagedestroy($im);

?>