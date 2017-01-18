<?php

// Starts a session with a captcha
session_start();
//Generates a random number between the 1000 and 9999
$code=rand(1000,9999);
// Checks the "code" session and cofigures it
$_SESSION["code"]=$code;
$im = imagecreatetruecolor(50, 24);
$bg = imagecolorallocate($im, 22, 86, 165); //Blue background for the captcha
$fg = imagecolorallocate($im, 255, 255, 255);//White collor for the numbers
// Changes the appearance and the properties of the captcha
imagefill($im, 0, 0, $bg);
imagestring($im, 5, 5, 5,  $code, $fg);
header("Cache-Control: no-cache, must-revalidate");
header('Content-type: image/png');
imagepng($im);
// Destroys the captcha so a new one can be created
imagedestroy($im);

?>