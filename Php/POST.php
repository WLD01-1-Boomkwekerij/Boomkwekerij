<?php

if (isset($_POST['submit'])) {
    $submit = $_POST['submit'];
    
    $Wachtwoord1 = hash('sha256', $_POST['Wachtwoord1']);
    $Wachtwoord2 = hash('sha256', $_POST['Wachtwoord2']);
    $gebr_naam = trim($_POST['gebr_naam']);
    $gebr_mail = trim($_POST['gebr_mail']);
    $krijgt_mail = trim($_POST['krijgt_mail']);
    $rol = $_POST['rol'];
}
?>