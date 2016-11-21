<?php
//$to      = 'test@boomkwekerij.pe.hu';
//$subject = 'the subject';
//$message = 'hello';
//$headers = 'From: test@boomkwekerij.pe.hu' . "\r\n" .
//    'Reply-To: test@boomkwekerij.pe.hu' . "\r\n" .
//    'X-Mailer: PHP/' . phpversion();
//
//mail($to, $subject, $message, $headers);

function SendMail($to,$subject,$message,$Naam,$Email){
$headers = 'From: test@boomkwekerij.pe.hu' . "\r\n" .
    'Reply-To: '.$to . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
$message = "Naam: ".$Naam." Website: " . $Email . $message;
mail($to, $subject, $message, $headers); 
}

