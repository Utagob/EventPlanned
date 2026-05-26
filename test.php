<?php

echo "Hi, I like my project for practica";
echo "<script>console.log('Help')</script>";

function consoleLog($message){
    echo "<script>console.log('" . $message . "');</script>";
}
consoleLog("My my");
?>