<?php

function connectToDatabase() {

    $username = "root";
    $password = "usbw";
    $servername = "mysql:host=localhost;dbname=boomkwekerij;port=3307";
    $connection = new PDO($servername, $username, $password);
    return $connection;
}

//-----------Depracted

function doSQL($sqlCode) {
    //trigger_error("Deprecated function called.", E_USER_NOTICE);
    try {
        $connection = connectToDatabase();
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sqlCode);
        $statement->execute();
    } catch (PDOException $e) {
        echo $sqlCode . "<br>" . $e->getMessage();
        echo '<br><br>';
    }
}


function getSQL($sqlCode, $rowName) {
    //trigger_error("Deprecated function called.", E_USER_NOTICE);

    $connection = connectToDatabase();
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $connection->prepare($sqlCode);
    $statement->execute();

    while ($row = $statement->fetch()) {
        $text = $row[$rowName];
        return $text;
    }
}

function getMaxSQL($table, $maxRow) {
    //trigger_error("Deprecated function called.", E_USER_NOTICE);
    try {
        $connection = connectToDatabase();
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare("SELECT MAX($maxRow) FROM $table");
        $statement->execute();
        return $statement->fetchColumn();
    } catch (PDOException $e) {
        echo $sqlCode . "<br>" . $e->getMessage();
        echo '<br><br>';
    }
}

function getSQLArray($sqlCode) {
    //trigger_error("Deprecated function called.", E_USER_NOTICE);
    try {
        $connection = connectToDatabase();
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sqlCode);
        $statement->execute();
    } catch (PDOException $e) {
        echo $sqlCode . "<br>" . $e->getMessage();
        echo '<br><br>';
    }
    return $statement;
}

//----------------beveiligd

function BeveiligdGetMaxSQL($table, $maxRow) {
    try {
        $connection = connectToDatabase();
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare("SELECT MAX(?) FROM ?");
        $statement->execute(array($table,$maxRow));
        return $statement->fetchColumn();
    } catch (PDOException $e) {
        echo $sqlCode . "<br>" . $e->getMessage();
        echo '<br><br>';
    }
}


function BeveiligdGetSQL($sqlCode, $rowName, $variables) {
    $connection = connectToDatabase();
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $connection->prepare($sqlCode);
    $statement->execute($variables);

    while ($row = $statement->fetch()) {
        $text = $row[$rowName];
        return $text;
    }
}

function BeveiligGetSQLArray($sqlCode, $variables) {
    try {
        $connection = connectToDatabase();
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sqlCode);
        $statement->execute($variables);
    } catch (PDOException $e) {
        echo $sqlCode . "<br>" . $e->getMessage();
        echo '<br><br>';
    }
    return $statement;
}

function BeveiligDoSQL($sqlCode, $variables) {
    try {
        $connection = connectToDatabase();
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sqlCode);
        $statement->execute($variables);
    } catch (PDOException $e) {
        echo $sqlCode . "<br>" . $e->getMessage();
        echo '<br><br>';
    }
}

//http://localhost:8080/pages/catalog.php?category=1 OR 1=1#

