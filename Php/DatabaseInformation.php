<?php

include 'Database.php';

function loadTextFromDB($textID) {

    $connection = connectToDatabase();
    $statement = $connection->prepare("SELECT * FROM tekst WHERE ID=" . $textID);
    $statement->execute();

    while ($row = $statement->fetch()) {
        $text = $row["Tekst"];
        return htmlspecialchars_decode($text);
    }
}

function saveTextToDB($textID, $text) {

    $connection = connectToDatabase();
    $statement = $connection->prepare("UPDATE tekst SET Tekst='" . htmlspecialchars($text) . "' WHERE TEKSTID=" . $textID);
    $statement->execute();
    $connection = null;
}
