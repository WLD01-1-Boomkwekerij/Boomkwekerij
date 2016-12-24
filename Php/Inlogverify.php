<?php

function confirmIP($ip)
{
    include_once '../Php/Database.php';
    date_default_timezone_set('Europe/Amsterdam');
    $tijd = time();
    $query = 'SELECT `Attempts` FROM `LoginAttempts` WHERE IP = ?';
    $variable = array($ip);
    $data = ProtectedGetSQL($query, 'Attempts', $variable);

    $query = 'SELECT `LastLogin` FROM `LoginAttempts` WHERE IP = ?';
    $timestamp = ProtectedGetSQL($query, 'LastLogin', $variable);

    $tijdverschil = ($tijd - $timestamp);
    if ($data == 0)
    {
        $query = 'INSERT INTO `LoginAttempts`(`IP`, `Attempts`, `LastLogin`) VALUES (?, 1, ?)';
        $variable = array($ip, $tijd);
        ProtectedDoSQL($query, $variable);
        $data = 1;
    }
    elseif ($tijdverschil >= 300)
    {
        $data = 1;
        $query = 'UPDATE `LoginAttempts` SET `Attempts` = ?, LastLogin = ? WHERE ip = ?';
        $variable = array($data, $tijd, $ip);
        ProtectedDoSQL($query, $variable);
    }
    else
    {
        $data = $data + 1;
        $query = 'UPDATE `LoginAttempts` SET `Attempts` = ?, LastLogin = ? WHERE ip = ?';
        $variable = array($data, $tijd, $ip);
        ProtectedDoSQL($query, $variable);
    }
    return $data;  //geeft het aantal pogingen.
}
