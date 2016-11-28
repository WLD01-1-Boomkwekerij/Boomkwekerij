<?php

function connectToDatabase() {

    $username = "root";
    $password = "usbw";
    $servername = "mysql:host=localhost;dbname=Boomkwekerij;port=3307";
    $connection = new PDO($servername, $username, $password);
    return $connection;
}

function getSQL($sqlCode, $rowName) {

    $connection = connectToDatabase();
    $statement = $connection->prepare($sqlCode);
    $statement->execute();

    while ($row = $statement->fetch()) {
        $text = $row[$rowName];
        return $text;
    }
}

function doSQL($sqlCode) {

    $connection = connectToDatabase();
    $statement = $connection->prepare($sqlCode);
    $statement->execute();
}
