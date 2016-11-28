<?php

include 'Database.php';

function loadTextFromDB($textID) {
    
    $connection = connectToDatabase();
    $statement = $connection->prepare("SELECT * FROM PaginaTekst WHERE ID=" . $textID);
    $statement->execute();

    while ($row = $statement->fetch()) {
        $text = $row["Text"];
        return htmlspecialchars_decode($text);
    }
}

function saveTextToDB($textID, $text){
    
    $connection = connectToDatabase();
    $statement = $connection->prepare("UPDATE PaginaTekst SET Text='".  htmlentities($text)."' WHERE ID=".$textID);
    $statement->execute();
    $connection = null;
    
}