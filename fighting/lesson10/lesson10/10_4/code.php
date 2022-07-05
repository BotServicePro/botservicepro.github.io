<?php

if ( !empty($_GET['code']) ){
   $code  = $_GET['code'];
}

Header("Pragma: no-cache");

$pic = ImageCreateFromgif("img/code.gif");
Header("Content-type: image/gif");
$color=ImageColorAllocate($pic, 255, 125, 255);
ImageString($pic,4,12,1,$code,$color);
Imagegif($pic);
ImageDestroy($pic);
?>
