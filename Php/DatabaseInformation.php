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
    $firstStatement = $connection->prepare("DELETE FROM nieuwsbericht WHERE PlantID=$newsID");
    $firstStatement->execute();
    $statement = $connection->prepare("DELETE FROM plant WHERE PlantID=$plantID");
    $statement->execute();
    $connection = null;
}
