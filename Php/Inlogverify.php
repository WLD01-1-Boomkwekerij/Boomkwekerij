<?php

function confirmIP($ip)
{
    include_once '../Php/Database.php';
    // Tijdzone instellen
    date_default_timezone_set('Europe/Amsterdam');
    $tijd = time();
    $query = 'SELECT `Attempts` FROM `loginattempts` WHERE IP = ?';
    $variable = array($ip);
    $data = ProtectedGetSQL($query, 'Attempts', $variable);

    //Kijkt wanneer de gebruiker voor het laatst is ingelogd
    $query = 'SELECT `LastLogin` FROM `loginattempts` WHERE IP = ?';
    $timestamp = ProtectedGetSQL($query, 'LastLogin', $variable);

    $tijdverschil = ($tijd - $timestamp);
    // Voert de inlogpogingen in, in de database
    if ($data == 0)
    {
        $query = 'INSERT INTO `loginattempts`(`IP`, `Attempts`, `LastLogin`) VALUES (?, 1, ?)';
        $variable = array($ip, $tijd);
        ProtectedDoSQL($query, $variable);
        $data = 1;
    }
    // Kijkt of er 300 seconden (5 minuten) zijn verstreken
    elseif ($tijdverschil >= 300)
    {
        $data = 1;
        $query = 'UPDATE `loginattempts` SET `Attempts` = ?, LastLogin = ? WHERE ip = ?';
        $variable = array($data, $tijd, $ip);
        ProtectedDoSQL($query, $variable);
    }
    // Als de 5 minuten niet verstreken zijn -> voer een nieuw poging to in de database
    else
    {
        $data = $data + 1;
        $query = 'UPDATE `loginattempts` SET `Attempts` = ?, LastLogin = ? WHERE ip = ?';
        $variable = array($data, $tijd, $ip);
        ProtectedDoSQL($query, $variable);
    }
    return $data;  //geeft het aantal pogingen.
}
