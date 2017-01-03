<?php

function connectToDatabase() {
    $username = "root";
    $password = "usbw";
    $servername = "mysql:host=localhost;dbname=boomkwekerij;port=3307";
    $connection = new PDO($servername, $username, $password);
    return $connection;
}

function ProtectedGetMaxSQL($table, $maxRow)
{
    try
    {
        $connection = connectToDatabase();
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare("SELECT MAX($maxRow) FROM $table");
        $statement->execute(); //array($maxRow, $table)
        return $statement->fetchColumn();
    }
    catch (PDOException $e)
    {
        print($e->getMessage());
    }
}

function ProtectedGetSQL($sqlCode, $rowName, $variables)
{
    $connection = connectToDatabase();
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $connection->prepare($sqlCode);
    $statement->execute($variables);

    while ($row = $statement->fetch())
    {
        $text = $row[$rowName];
        return $text;
    }
}

function ProtectedGetSQLArray($sqlCode, $variables)
{
    try
    {
        $connection = connectToDatabase();
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sqlCode);
        $statement->execute($variables);
    }
    catch (PDOException $e)
    {
        print($e->getMessage());
    }
    return $statement;
}

function ProtectedDoSQL($sqlCode, $variables)
{
    try
    {
        $connection = connectToDatabase();
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sqlCode);
        $statement->execute($variables);
    }
    catch (PDOException $e)
    {
        print($e->getMessage());
    }
}

//http://localhost:8080/pages/catalog.php?category=1 OR 1=1#

