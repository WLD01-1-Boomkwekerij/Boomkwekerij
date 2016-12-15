<?php

include 'DatabaseInformation.php';

//Save text to the Text table
if (isset($_GET["htmlText"]) && isset($_GET["textID"])) {
    saveTextToDB($_GET["textID"], $_GET["htmlText"]);
}

//Gets all the files
if (isset($_GET["fileDirectory"])) {
    $dir = $_GET["fileDirectory"];
    $files1 = scandir($dir);

    for ($i = 2; $i < sizeof($files1); $i++) {

        print($files1[$i] . "*");
    }
}

//Adds a plant to the 
if (isset($_GET['name'])) {

    $Naam = $_GET['name'];
    $PrijsID = $_GET['groep'];
    $Hoogte_Min = $_GET['hoogte_min'];
    $Hoogte_Max = $_GET['hoogte_max'];
    $bloeitijd = $_GET['bloeitijd'];
    $bloeiwijze = $_GET['bloeiwijze'];
    $photoUrl = $_GET['catalogPhotoUrl'];

    $sql = "INSERT INTO plant (Naam, PrijsID, Hoogte_Min, Hoogte_max, Bloeitijd, Bloeiwijze) VALUES ('$Naam', $PrijsID, $Hoogte_Min, $Hoogte_Max, '$bloeitijd', '$bloeiwijze')";
    doSQL($sql);

    $PlantID = getMaxSQL("plant", "PlantID");
    $sql = "INSERT INTO plantfoto (FotoUrl, PlantID, TypeFoto) VALUES ('$photoUrl', $PlantID, 1)";
    doSQL($sql);
    
    print("done");
}

if (isset($_GET["CatalogSelectOptions"])) {
    $sqlPrijs = getSQLArray("SELECT Naam, PrijsID FROM prijs");
    $row = $sqlPrijs->fetchAll(PDO::FETCH_ASSOC);
    
    
    foreach($row as $i){
        foreach($i as $j){
            print($j . "*");
        }
       // print($i . "*");
    }
    
    for ($i = 0; $i < sizeof($row); $i++) {

        //print($row[$i] . "*");
    }
    
}
