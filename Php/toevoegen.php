<?php

include'/../Php/Database.php';
$Naam = $_POST['name'];
$PrijsID = $_POST['groep'];
$Hoogte_Min = $_POST['hoogte_min'];
$Hoogte_Max = $_POST['hoogte_max'];
$bloeitijd = $_POST['bloeitijd'];
$bloeiwijze = $_POST['bloeiwijze'];
$sql = "INSERT INTO plant (Naam, PrijsID, Hoogte_Min, Hoogte_max, Bloeitijd, Bloeiwijze) VALUES ('$Naam', $PrijsID, $Hoogte_Min, $Hoogte_Max, '$bloeitijd', '$bloeiwijze')";


// prepare sql and bind parameters
doSQL($sql);

header('Refresh: 0; url=/pages/catalog.php');



    
?>