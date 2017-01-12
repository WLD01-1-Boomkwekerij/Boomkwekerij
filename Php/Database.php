<?php

/**
 * Makes a connection to the database
 * @return \PDO
 */
function connectToDatabase()
{
    if ($_SERVER["SERVER_ADDR"] == "::1")
    {
        $username = "root";
        $password = "usbw";
        $servername = "mysql:host=localhost;dbname=boomkwekerij;port=3307";
    }
    else
    {
        $username = "Boomkweek";
        $password = "wlgF0?52";
        $servername = "mysql:host=localhost;dbname=boomkwe1_;port=3306";
    }

    $connection = new PDO($servername, $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $connection;
}

/**
 * Gets the maximum value of inserted row
 * @param string $table
 * @param string $maxRow
 * @return int Max
 */
function ProtectedGetMaxSQL($table, $maxRow)
{
    try
    {
        $connection = connectToDatabase();
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
    $statement = $connection->prepare($sqlCode);
    $statement->execute($variables);

    while ($row = $statement->fetch())
    {
        $text = $row[$rowName];
        return html_entity_decode($text, ENT_QUOTES);
    }
}

function ProtectedGetSQLArray($sqlCode, $variables)
{
    try
    {
        $connection = connectToDatabase();
        $statement = $connection->prepare($sqlCode);
        $statement->execute($variables);
    }
    catch (PDOException $e)
    {
        print($e->getMessage());
    }
    return $statement;
}

function ProtectedDoSQL($sqlCode, $parameter)
{
    try
    {
        $newArray = [];

        foreach ($parameter as $variables)
        {
            $newArray[count($newArray)] = htmlentities($variables, ENT_QUOTES);
        }

        $connection = connectToDatabase();
        $statement = $connection->prepare($sqlCode);
        $statement->execute($newArray);
    }
    catch (PDOException $e)
    {
        print($e->getMessage());
    }
}

//http://localhost:8080/pages/catalog.php?category=1 OR 1=1#

