<?php

include_once 'Database.php';

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

function insertNewsTextToDB($visibility, $text, $title)
{
    $connection = connectToDatabase();

    $statement = $connection->prepare("INSERT INTO tekst (tekst) VALUES('" . htmlspecialchars($text) . "')");
    $statement->execute();

    $lastTekstID = getMaxSQL("text", "TekstID");

    $statement = $connection->prepare("INSERT INTO aanbieding (Zichtbaar, TekstID, Titel) VALUES($visibility, $lastTekstID, $title)");
    $statement->execute();
    $connection = null;
}

function saveTextToDB($textID, $text)
{
    $connection = connectToDatabase();
    $statement = $connection->prepare("UPDATE tekst SET Tekst='" . htmlspecialchars($text) . "' WHERE TEKSTID=" . $textID);
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
