<?php

include_once 'Database.php';

//Plain Text
function saveTextToDB($textID, $text)
{
    $connection = connectToDatabase();
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try
    {
        $statement = $connection->prepare("UPDATE tekst SET Tekst='" . htmlspecialchars($text) . "' WHERE TekstID=" . $textID);
        $statement->execute();
        $connection = null;
    }
    catch (PDOException $ex)
    {
        print($ex->getMessage());
    }
}

function loadTextFromDB($textID)
{
    $connection = connectToDatabase();
    $statement = $connection->prepare("SELECT * FROM tekst WHERE TEKSTID=" . $textID);
    $statement->execute();

    while ($row = $statement->fetch())
    {
        $text = $row["Tekst"];
        print htmlspecialchars_decode($text) . "<br>";
    }
}

//News (Title + text)

function getTextIDFromNewsID($connection, $newsID)
{
    $sqlSelect = "SELECT t.TekstID "
            . "FROM aanbieding a "
            . "JOIN tekst t "
            . "ON a.TekstID = t.TekstID "
            . "WHERE a.aanbiedingID = $newsID";

    $statement = $connection->prepare($sqlSelect);
    $statement->execute();

    $row = $statement->fetch();
    $textID = $row["TekstID"];
    return $textID;
}

//Inserting
function insertNewsTextToDB($visibility, $text, $title)
{
    $connection = connectToDatabase();
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try
    {
        $sql1 = "INSERT INTO tekst (tekst) VALUES('" . htmlspecialchars($text) . "');";

        $statement = $connection->prepare($sql1);
        $statement->execute();

        $lastTextID = getMaxSQL("tekst", "TekstID");
        $sql2 = "INSERT INTO aanbieding (AanbiedingID, Zichtbaar, DatumGeplaatst, TekstID, Titel) VALUES(NULL, $visibility, CURRENT_TIMESTAMP, $lastTextID, '$title')";

        $statement = $connection->prepare($sql2);
        $statement->execute();

        $connection = null;
    }
    catch (PDOException $ex)
    {
        print($ex->getMessage());
    }
}

//Updating
function updateNewsTextToDB($newsID, $visibility, $text, $title)
{
    $connection = connectToDatabase();
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try
    {
        
        $textID = getTextIDFromNewsID($connection, $newsID);

        $sql1 = "UPDATE tekst "
                . "SET Tekst='" . htmlspecialchars($text) . "' "
                . "WHERE TekstID=$textID;";

        $statement = $connection->prepare($sql1);
        $statement->execute();

        $sql2 = "UPDATE aanbieding SET zichtbaar=$visibility, Titel='$title' WHERE aanbiedingID = $newsID";

        $statement = $connection->prepare($sql2);
        $statement->execute();

        $connection = null;
    }
    catch (PDOException $ex)
    {
        print($ex->getMessage());
    }
}

function DeleteNewsTextFromDB($newsID)
{
    $connection = connectToDatabase();
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $textID = getTextIDFromNewsID($connection, $newsID);
    
    $firstStatement = $connection->prepare("DELETE FROM aanbieding WHERE AanbiedingID=$newsID");
    $firstStatement->execute();
    
    $statement = $connection->prepare("DELETE FROM tekst WHERE TekstID=$textID");
    $statement->execute();
    $connection = null;
}

function deletePlant($plantID)
{
    $connection = connectToDatabase();
    $firstStatement = $connection->prepare("DELETE FROM plantfoto WHERE PlantID=$plantID");
    $firstStatement->execute();
    $statement = $connection->prepare("DELETE FROM plant WHERE PlantID=$plantID");
    $statement->execute();
    $connection = null;
}

function deleteArticle($newsID)
{
    $connection = connectToDatabase();
    $firstStatement = $connection->prepare("DELETE FROM aanbieding WHERE AanbiedingID=$newsID");
    $firstStatement->execute();
    $connection = null;
}
