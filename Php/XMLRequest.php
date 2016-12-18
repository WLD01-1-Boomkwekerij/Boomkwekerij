<?php

include 'DatabaseInformation.php';

//Save text to the Text table
if (isset($_GET["htmlUpdateText"], $_GET["textID"]))
{
    saveTextToDB($_GET["textID"], $_GET["htmlUpdateText"]);
}

if (isset($_GET["newsVisibility"], $_GET["htmlInsertText"], $_GET["newsTitle"]))
{
    insertNewsTextToDB($_GET["newsVisibility"], $_GET["htmlInsertText"], $_GET["newsTitle"]);
}

//Gets all the files
if (isset($_GET["fileDirectory"]))
{
    $dir = $_GET["fileDirectory"];
    $files1 = scandir($dir);

    for ($i = 2; $i < sizeof($files1); $i++)
    {

        print($files1[$i] . "*");
    }
}

//Adds a plant to the 
if (isset($_GET['name']))
{
    $Naam = $_GET['name'];
    $PrijsID = $_GET['groep'];
    $Hoogte_Min = $_GET['hoogte_min'];
    $Hoogte_Max = $_GET['hoogte_max'];
    $bloeitijd1 = $_GET['bloeitijd1'];
    $bloeitijd2 = $_GET['bloeitijd2'];
    $bloeiwijze = $_GET['bloeiwijze'];
    $photoUrlArray = $_GET['imageUrl'];

    $phpImageArray = explode("*", $photoUrlArray);
    $phpImageArray = str_replace("*", "", $phpImageArray);



    $bloeitijd = $bloeitijd1 . "-" . $bloeitijd2;

    print($bloeitijd1);

    $sql = "INSERT INTO plant (Naam, PrijsID, Hoogte_Min, Hoogte_max, Bloeitijd, Bloeiwijze) VALUES ('$Naam', $PrijsID, $Hoogte_Min, $Hoogte_Max, '$bloeitijd', '$bloeiwijze')";
    doSQL($sql);
    $PlantID = getMaxSQL("plant", "PlantID");

    $sql = "INSERT INTO plantfoto (FotoUrl, PlantID, TypeFoto) VALUES ('$phpImageArray[0]', $PlantID, 1)";
    doSQL($sql);
    if (count($phpImageArray) > 1)
    {

        $amount = 0;

        for ($i = 1; $i < (count($phpImageArray) - 1); $i++)
        {
            $sql = "INSERT INTO plantfoto (FotoUrl, PlantID, TypeFoto) VALUES ('$phpImageArray[$i]', $PlantID, 2)";
            doSQL($sql);
            $amount += 1;
        }
    }
}

if (isset($_GET["CatalogSelectOptions"]))
{
    $sqlPrijs = getSQLArray("SELECT Naam, PrijsID FROM prijs");
    $row = $sqlPrijs->fetchAll(PDO::FETCH_ASSOC);


    foreach ($row as $i)
    {
        foreach ($i as $j)
        {
            print($j . "*");
        }
        // print($i . "*");
    }

    for ($i = 0; $i < sizeof($row); $i++)
    {

        //print($row[$i] . "*");
    }
}

if (isset($_GET["DeleteArticle"]))
{
    deleteArticle($_GET["DeleteArticle"]);
}
