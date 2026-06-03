<?php
function make_avater($char){
    $path = "../image/" . time() .".png";
    $image = imagecreate(200, 200);
    $red = rand(0, 255);
    $green = rand(0, 255);
    $blue = rand(0, 255);
    imagecolorallocate($image, $red, $green, $blue);
    $textcolor = imagecolorallocate($image, $red, $green, $blue);
    imagettftext($image, 100, 0, 55, 150, $textcolor, "../font/altsans.otf", $char);
    imagepng($image, $path);
    imagedestroy($image);
    return $path;
}