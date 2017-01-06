<?php

// Start de sessie van de captcha
session_start();
//Genereert een 'random' code tussen de 1000 en de 9999
$code=rand(1000,9999);
// Controleert de sessie genaamd 'code' en stelt die in
$_SESSION["code"]=$code;
$im = imagecreatetruecolor(50, 24);
$bg = imagecolorallocate($im, 22, 86, 165); //Blauwe achtergrond van het weergegeven plaatje met de captcha
$fg = imagecolorallocate($im, 255, 255, 255);//Witte achtergrond van de getallen zelf
// Het opmaken van het uiterlijk en properties van de captcha
imagefill($im, 0, 0, $bg);
imagestring($im, 5, 5, 5,  $code, $fg);
header("Cache-Control: no-cache, must-revalidate");
header('Content-type: image/png');
imagepng($im);
// Vernietigt het huidige plaatje om later een nieuwe te genereren
imagedestroy($im);

?>