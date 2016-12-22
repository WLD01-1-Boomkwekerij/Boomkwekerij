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
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $connection->prepare($sqlCode);
    $statement->execute();

    while ($row = $statement->fetch()) {
        $text = $row[$rowName];
        return $text;
    }
}

function getMaxSQL($table, $maxRow) {
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
    echo $sqlCode;
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

function doSQL($sqlCode) {
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
