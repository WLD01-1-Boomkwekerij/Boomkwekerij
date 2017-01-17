<?php

function confirmIP($ip)
{
    include_once '../Php/Database.php';
    // configure timezones
    date_default_timezone_set('Europe/Amsterdam');
    $tijd = time();
    $query = 'SELECT `Attempts` FROM `loginattempts` WHERE IP = ?';
    $variable = array($ip);
    $data = ProtectedGetSQL($query, 'Attempts', $variable);

    //inspects the last time the user has logged in
    $query = 'SELECT `LastLogin` FROM `loginattempts` WHERE IP = ?';
    $timestamp = ProtectedGetSQL($query, 'LastLogin', $variable);

    $tijdverschil = ($tijd - $timestamp);
    // registers the login attempts into the database
    if ($data == 0)
    {
        $query = 'INSERT INTO `loginattempts`(`IP`, `Attempts`, `LastLogin`) VALUES (?, 1, ?)';
        $variable = array($ip, $tijd);
        ProtectedDoSQL($query, $variable);
        $data = 1;
    }
    // checks if the 5 minute wait time is over
    elseif ($tijdverschil >= 300)
    {
        $data = 1;
        $query = 'UPDATE `loginattempts` SET `Attempts` = ?, LastLogin = ? WHERE ip = ?';
        $variable = array($data, $tijd, $ip);
        ProtectedDoSQL($query, $variable);
    }
    // if the 5 minutes are not over the attempts will be reset
    else
    {
        $data = $data + 1;
        $query = 'UPDATE `loginattempts` SET `Attempts` = ?, LastLogin = ? WHERE ip = ?';
        $variable = array($data, $tijd, $ip);
        ProtectedDoSQL($query, $variable);
    }
    return $data;  //shows the ammount of tries
}
