<?php

session_start();

if (isset($_SESSION['logged_in']))
{
    include 'DatabaseInformation.php';

    //Save Plain text to the Text table
    if (isset($_GET["textID"], $_GET["htmlUpdateText"]))
    {
        saveTextToDB($_GET["textID"], $_GET["htmlUpdateText"]);
    }

    //Saves news Text
    //Inserting
    if (isset($_GET["newsVisibility"], $_GET["newsHtmlInsertText"], $_GET["newsTitle"]))
    {
        insertNewsTextToDB($_GET["newsVisibility"], $_GET["newsHtmlInsertText"], $_GET["newsTitle"]);
    }

    //Updating
    if (isset($_GET["newsID"], $_GET["newsVisibility"], $_GET["newsHtmlUpdateText"], $_GET["newsTitle"]))
    {
        updateNewsTextToDB($_GET["newsID"], $_GET["newsVisibility"], $_GET["newsHtmlUpdateText"], $_GET["newsTitle"]);
    }

    //Deleting
    if (isset($_GET["newsDeleteID"]))
    {
        DeleteNewsTextFromDB($_GET["newsDeleteID"]);
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

        $sql = "INSERT INTO plant (Naam,"
                . "PrijsID, "
                . "Hoogte_Min, "
                . "Hoogte_max, "
                . "Bloeitijd, "
                . "Bloeiwijze) VALUES ("
                . "?, "
                . "?, "
                . "?, "
                . "?, "
                . "?, "
                . "?)";

        ProtectedDoSQL($sql, array($Naam, $PrijsID, $Hoogte_Min, $Hoogte_Max, $bloeitijd, $bloeiwijze));
        $PlantID = ProtectedGetMaxSQL("plant", "PlantID");

        $sql = "INSERT INTO plantfoto (FotoUrl, PlantID, TypeFoto) VALUES (?, ?, 1)";
        ProtectedDoSQL($sql, array($phpImageArray[0], $PlantID));
        if (count($phpImageArray) > 1)
        {
            $amount = 0;

            for ($i = 1; $i < (count($phpImageArray) - 1); $i++)
            {
                $sql = "INSERT INTO plantfoto (FotoUrl, PlantID, TypeFoto) VALUES (?, ? , 2)";
                ProtectedDoSQL($sql, array($phpImageArray[$i], $PlantID));
                $amount += 1;
            }
        }
    }

    if (isset($_GET["CatalogSelectOptionsCategory"]))
    {
        $cat = $_GET["CatalogSelectOptionsCategory"];
        $sqlPrijs = ProtectedGetSQLArray("SELECT Naam, PrijsID FROM prijs WHERE CategoryID=$cat", array());
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
    
    if (isset($_GET["CatalogSelectOptions"]))
    {
        $sqlPrijs = ProtectedGetSQLArray("SELECT Naam, PrijsID FROM prijs", array());
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

    //Add PlantImage
    if (isset($_GET["addPlantImages"], $_GET["plantID"]))
    {
        $phpImageArray = explode("*", $_GET["addPlantImages"]);
        $phpImageArray = str_replace("*", "", $phpImageArray);

        for ($i = 0; $i < count($phpImageArray) - 1; $i++)
        {
            $sql = "INSERT INTO plantfoto (FotoUrl, PlantID, TypeFoto) VALUES ( ?, " . $_GET['plantID'] . ", 2)";
            ProtectedDoSQL($sql, array($phpImageArray[$i]));
        }
    }

    //Delete PlantImage
    if (isset($_GET["deletePlantImages"]))
    {
        $sql = "DELETE FROM plantfoto WHERE FotoID=?";
        ProtectedDoSQL($sql, array($_GET["deletePlantImages"]));
    }
    
    if(isset($_GET["createNewDirectory"]))
    {
        if(!mkdir($_GET["createNewDirectory"]))
        {
            print("Could not create Directoy");
        }
    }
}