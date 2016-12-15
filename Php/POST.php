<?php

if (isset($_POST['submit'])) {
    $submit = $_POST['submit'];
    $errors = array();
    if (isset($_POST['Wachtwoord1'])) {
        if (!empty($_POST['Wachtwoord1'])) {
            $Wachtwoord1 = $_POST['Wachtwoord1'];
            if (!preg_match('/^[A-Za-z0-9#@%&-_]*$/', $Wachtwoord1)) {
                $errors[1] = 'Ongeldige tekens';
            }
            if (strlen($Wachtwoord1) < 8) {
                $errors[2] = 'Wachtwoord is te kort';
            }
            if (preg_match('/\d/', $Wachtwoord1) == 0) {
                $errors[3] = 'Gebruik minimaal 1 getal';
            }
            if (preg_match('/[# @ % & \ - _ ]/', $Wachtwoord1) == 0) {
                $errors[4] = 'Gerbuik minimaal 1 van de volgende tekens: <i># @ % & - _ </i>';
            }
            if (preg_match('/[A-Z]/', $Wachtwoord1) == 0) {
                $errors[5] = 'Gebruik minimaal 1 hoofdletter';
            }
            if (preg_match('/[a-z]/', $Wachtwoord1) == 0) {
                $errors[6] = 'Gebruik minimaal 1 kleine letter';
            }
            $Wachtwoord1 = hash('sha256', $Wachtwoord1);
        }
    }
    if (isset($_POST['Wachtwoord2'])) {
        $Wachtwoord2 = hash('sha256', $_POST['Wachtwoord2']);
    }
    if (isset($_POST['gebruiker'])) {
        $gebruiker = $_POST['gebruiker'];
    }
    if (isset($_POST['gebr_naam'])) {
        $gebr_naam = $_POST['gebr_naam'];
    }
    if (isset($_POST['gebr_mail'])) {
        $gebr_mail = $_POST['gebr_mail'];
    }
     if (isset($_POST['krijgt_mail'])) {
        $krijgt_mail = $_POST['krijgt_mail'];
    }
     if (isset($_POST['rol'])) {
        $rol = $_POST['rol'];
    }
    
}
?>