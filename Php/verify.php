<?php

// We gaan sessies gebruiken 
session_start();
// Controle of het formulier verzonden is 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Controle of benodigde velden wel ingevuld zijn 
    include_once '../Php/Database.php';
    $sGebruikerControle = trim($_POST['user']);
    $sWachtwoordControle = getSQL('SELECT Wachtwoord FROM gebruiker WHERE Naam="' . $sGebruikerControle . '"', 'Wachtwoord');
    // Gebruikersnaam en wachtwoord instellen
    if (isset($_POST['user'], $_POST['pass'])) {
        // Overbodige spaties verwijderen 
        $sGebruiker = htmlentities(trim($_POST['user']));
        $sWachtwoord = hash('sha256', htmlentities(trim($_POST['pass'])));
        // Gebruikersnaam en wachtwoord controleren 
        if ($sGebruiker == $sGebruikerControle && $sWachtwoord == $sWachtwoordControle) {
            // Juiste gebruikersnaam en wachtwoord: inloggen! 
            $_SESSION['logged_in'] = true;
            $_SESSION['gebruiker'] = $sGebruiker;
            $_SESSION['toegang'] = getSQL('SELECT Rol FROM gebruiker WHERE Naam="' . $sGebruikerControle . '"', 'Rol');
            // Doorsturen en melding geven 
            if ($_SESSION['toegang'] == 1) {
                header('Refresh: 0; url=../Pages/logged_in.php');
                print('U wordt automtisch doorgestuurd, mocht dit niet gebeuren, <a href="../Pages/logged_in.php">klik dan hier</a>');
            } else {
                header('Refresh: 0; url=../Pages/index.php');
                print('U wordt automtisch doorgestuurd, mocht dit niet gebeuren, <a href="../Pages/index.php">klik dan hier</a>');
            }
        } else {
            // Terugsturen en foutmelding geven 
            header('Refresh: 2; url=../Pages/login.php');
            echo 'Deze combinatie van gebruikersnaam en wachtwoord is niet juist!';
        }
    } else {
        header('Refresh: 2; url=login.php');
        echo 'Een vereist veld bestaat niet!';
    }
} else {
    // Terug naar het formulier 
    header('Location: login.php');
    exit();
}
?>