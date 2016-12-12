<?php

function connectToDatabase() {

    $username = "root";
    $password = "usbw";
    $servername = "mysql:host=localhost;dbname=boomkwekerij;port=3307";
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

function getSQLArray($sqlCode) {

    $connection = connectToDatabase();
    $statement = $connection->prepare($sqlCode);
    $statement->execute();
   
    return $statement;
}

function doSQL($sqlCode) {
try {
    $connection = connectToDatabase();
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $connection->prepare($sqlCode);
    $statement->execute();
}catch(PDOException $e)
    {
    echo $sqlCode . "<br>" . $e->getMessage();
    echo '<br><br>';
    }

}
