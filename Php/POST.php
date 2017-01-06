<?php

if (isset($_POST['submit'])) {
    $submit = $_POST['submit'];
    $errors = array();
    // Controleert of het wachtwoord is ingevuld
    if (isset($_POST['Wachtwoord1'])) {
        // Controleert of de 2 ingevulde wachtwoorde gelijk zijn aan elkaar
        if ($_POST['Wachtwoord1'] != $_POST['Wachtwoord2']) {
            $errors[1] = 'Wachtwoorden zijn niet evenlang';
        } else {
            // Controleert of de velden NIET leeg zijn
            if (!empty($_POST['Wachtwoord1'])) {
                $Wachtwoord1 = $_POST['Wachtwoord1'];
                if (!preg_match('/^[A-Za-z0-9#@%&-_!?]*$/', $Wachtwoord1)) {
                    $errors[1] = 'Ongeldige tekens';
                }
                // Controleert of het wachtwoord langer is dan 8 tekens
                if (strlen($Wachtwoord1) < 8) {
                    $errors[2] = 'Wachtwoord is te kort';
                }
                // Kijkt of er een getal is gebruikt
                if (preg_match('/\d/', $Wachtwoord1) == 0) {
                    $errors[3] = 'Gebruik minimaal 1 getal';
                }
                // Controleert of de vereisten van de tekens zijn voldaan
                if (preg_match('/[# @ % & \ - _ ! ?]/', $Wachtwoord1) == 0) {
                    $errors[4] = 'Gebruik minimaal 1 van de volgende tekens: <i># @ % & - _ ! ?</i>';
                }
                // Controleert of er één of meerdere hoofdletters zijn gebruikt
                if (preg_match('/[A-Z]/', $Wachtwoord1) == 0) {
                    $errors[5] = 'Gebruik minimaal 1 hoofdletter';
                }
                // Controleert of er één of meerdere kleine letters zijn gebruikt
                if (preg_match('/[a-z]/', $Wachtwoord1) == 0) {
                    $errors[6] = 'Gebruik minimaal 1 kleine letter';
                }
                $Wachtwoord1 = hash('sha256', $Wachtwoord1);
                $_POST['Wachtwoord1']=$Wachtwoord1;
            }
        }
    }
    if (isset($_POST['Wachtwoord2'])) {
        $Wachtwoord2 = hash('sha256', $_POST['Wachtwoord2']); // Hashed de wachtwoorden met sha256
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