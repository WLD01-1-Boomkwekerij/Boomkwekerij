<?php

include_once 'Database.php';

function loadTextFromDB($textID)
{
    $statement = ProtectedGetSQLArray("SELECT * FROM tekst WHERE TEKSTID=?", array($textID));
    while ($row = $statement->fetch())
    {
        $text = $row["Tekst"];
        print html_entity_decode($text, ENT_QUOTES) . "<br>";
    }
}

//Plain Text
function saveTextToDB($textID, $text)
{
    $statement = "UPDATE tekst SET Tekst=? WHERE TekstID=?";
    ProtectedDoSQL($statement , array($text, $textID));
}

function getTextIDFromNewsID($newsID)
{
    $sqlSelect = "SELECT t.TekstID FROM aanbieding a JOIN tekst t ON a.TekstID = t.TekstID WHERE a.aanbiedingID = ?";
    $statement = ProtectedGetSQLArray($sqlSelect, array($newsID));
    $row = $statement->fetch();
    $textID = $row["TekstID"];
    return $textID;
}

//Inserting
function insertNewsTextToDB($visibility, $text, $title)
{
    $sql1 = "INSERT INTO tekst (tekst) VALUES(?);";
    ProtectedDoSQL($sql1, array($text));
    $lastTextID = ProtectedGetMaxSQL("tekst", "TekstID");
    $sql2 = "INSERT INTO aanbieding (AanbiedingID, Zichtbaar, DatumGeplaatst, TekstID, Titel) VALUES(NULL, ?, CURRENT_TIMESTAMP, ?, ?)";
    ProtectedDoSQL($sql2, array($visibility, $lastTextID, $title));
}

//Updating
function updateNewsTextToDB($newsID, $visibility, $text, $title)
{
    $textID = getTextIDFromNewsID($newsID);
    $sql1 = "UPDATE tekst SET Tekst=? WHERE TekstID=?;";
    ProtectedDoSQL($sql1, array($text, $textID));
    $sql2 = "UPDATE aanbieding SET zichtbaar=?, Titel=? WHERE aanbiedingID = ?";
    ProtectedDoSQL($sql2, array($visibility, $title, $newsID));
}

function DeleteNewsTextFromDB($newsID)
{
    $textID = getTextIDFromNewsID($newsID);
    ProtectedDoSQL("DELETE FROM aanbieding WHERE AanbiedingID=?", array($newsID));
    ProtectedDoSQL("DELETE FROM tekst WHERE TekstID=?", array($textID));
}

function deletePlant($plantID)
{
    ProtectedDoSQL("DELETE FROM plantfoto WHERE PlantID=?", array($plantID));
    ProtectedDoSQL("DELETE FROM plant WHERE PlantID=?", array($plantID));
}

function deleteArticle($newsID)
{
    $connection = connectToDatabase();
    $firstStatement = $connection->prepare("DELETE FROM aanbieding WHERE AanbiedingID=?");
    ProtectedDoSQL($firstStatement, array($newsID));
}
