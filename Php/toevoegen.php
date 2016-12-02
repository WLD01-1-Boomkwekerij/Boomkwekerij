<?php

include'/../Php/Database.php';
$Naam = $_POST['name'];
$PrijsID = $_POST['groep'];
$sql = "INSERT INTO plant (Naam, PrijsID, PlantGroepID) VALUES ('$Naam', $PrijsID,1)";

// prepare sql and bind parameters
echo $sql;
doSQL($sql);
    
?>