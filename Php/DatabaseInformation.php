<?php

include 'Database.php';

function checkForSpecificItem($connection, $table, $condition, $rowName) {

    $statement = $connection->prepare("SELECT * FROM " . $table . " WHERE " . $condition);
    $statement->execute();

    while ($row = $statement->fetch()) {
        return count($row[$rowName]);
    }
}

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
    
    if (checkForItem($connection, "tekst", "ID=" . $textID, "Tekst") > 0) {

        $statement = $connection->prepare("UPDATE tekst SET Tekst='" . htmlentities($text) . "' WHERE ID=" . $textID);
        $statement->execute();
        $connection = null;
    }
}
