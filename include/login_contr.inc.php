<?php

declare(strict_types= 1);

function is_input_empty(string $username, string $pwd){
    if(empty($username) || empty($pwd)){
        return true;
    } else {
        return false;
    }
}

function is_username_correct(bool|array $result){
    if($result){
        return true;
    } else {
        return false;
    }
}

function is_pwd_correct(string $pwd, string $hashedPwd){
    if(password_verify($pwd, $hashedPwd)){
        return true;
    } else {
        return false;
    }
}

function make_avatar($character){
    $filename = md5($character) . ".png";
    $path = "avatar/" . $filename;

    if(!is_readable($path)){
        $canvasWidth = 35;
        $canvasHeight = 35;
        $fontSize = 15;
        $fontPath = getcwd() . "/css/OpenSans.ttf";

        $image = imagecreate($canvasWidth, $canvasHeight); 
        
        $red = rand(0, 255);
        $green = rand(0, 255);
        $blue = rand(0, 255);

        imagecolorallocate($image, $red, $green, $blue);
        $textcolor = imagecolorallocate($image, 255, 255, 255);

        $bbox = imagettfbbox($fontSize, 0, $fontPath, $character);

        $textWidth = $bbox[2] - $bbox[0];
        $textHeight = $bbox[1] - $bbox[7];

        $x = ($canvasWidth - $textWidth) / 2 - $bbox[0];
        $y = ($canvasHeight - $textHeight) / 2 + $textHeight - $bbox[1];

        imagettftext($image, $fontSize, 0, (int)$x, (int)$y, $textcolor, $fontPath, $character);

        imagepng($image, $path);
        unset($image);
    }

    return $path;
}