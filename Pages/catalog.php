<?php
include'/../Php/Database.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="notranslate">Boomkwekerij - Catalogus</title>
        <link href="../Css/CatalogStyle.css" rel="stylesheet" type="text/css">
        <link rel="plant icon" href="../Images/plant_icon.png">
        <?php
        session_start();
        
        include '../Html/includeHead.html';
        
        //If logged in then enable the editor
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
        {
            include '../Php/loggedInEditor.php';
            print("<script src='../Javascript/Catalog.js'></script>");
        }
        ?>
    </head>
    <body>
        <?php
        //Zet een categorie
        if (isset($_GET["category"]))
        {
            $cat = $_GET["category"];
            //Zet een categorie in een DIV-tag (Javascript)
            echo "<div style='display:none;' id='category'>$cat</div>";
        }
        ?>

        <section id="wrapper">
            <section id='titlediv' class="notranslate"><p id="imgtitle">FA.P. BOER BOOMKWEKERIJ</p></section>
            <section id="top">
                <section id="header"></section>
                <?php
                include '../Php/menu.php';
                ?>
            </section>
            <section id="mid">
                <?php
                //Het toevoegen van een javascript functie. Het toevoegmenu word weergeven, mits de rol overeenkomst met de rechten
                if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3)
                {
                    if (isset($_GET["category"]))
                    {
                        print("<script>createCatalogAddition();</script>");
                    }
                }
                ?>
                
                <section id="rightmenu">
                    <h3 id="a">Soorten</h3>

                    <ul id="catalogus">
                        <?php
                        //Creëert categorie optie
                        $sqlCategory = ProtectedGetSQLArray("SELECT * FROM category", array());

                        while ($row = $sqlCategory->fetch())
                        {
                            $categoryNaam = $row["CategoryNaam"];
                            $id = $row["CategoryID"];
                            echo "<table id='catatabel' border='3'><td> <a href='catalog.php?category=$id'><li>$categoryNaam</li></a></td> </table> ";
                        }
                        ?>
                    </ul>

                </section>

                <section id="maincontent">

                    <?php
                    // Plant verwijderen, plantID ophalen en controleren voordat het word verwijderd
                    if (isset($_GET["plantID"]))
                    {
                        deletePlant($_GET["plantID"]);
                    }

                    if (!isset($_GET['category']))
                    {
                        //Pagina met alle planten
                        $sqlCategory = ProtectedGetSQLArray("SELECT * FROM category", array());
                        $categoryRegel = $sqlCategory->fetch();
                        $categoryNaam = $categoryRegel["CategoryNaam"];
                        echo "<h1 id='catalogustitle2'>$categoryNaam</h1>";

                        $sqlPrijs = ProtectedGetSQLArray("SELECT * FROM prijs", array());
                        //Dit word voor elke prijsregel uitgevoerd
                        while ($row = $sqlPrijs->fetch())
                        {
                            $prijsID = $row["PrijsID"];
                            $sqlPlant = ProtectedGetSQLArray(
                                    "SELECT * 
                                 FROM plant 
                                 LEFT JOIN plantfoto pf
                                 ON plant.PlantID=pf.PlantID
                                 WHERE plant.PrijsID = ? AND pf.TypeFoto = 1", array($prijsID)
                            );
                            //Alle planten van een prijsregel opvragen van de database

                            while ($plant = $sqlPlant->fetch())
                            {
                                $plantId = $plant['PlantID'];
                                $naam = $plant['Naam'];
                                $plantFotoUrl = $plant['FotoUrl'];

                                $hidden = "hidden";
                                $position = "absolute";
                                //Plant weergeven met de daarbijhorende attributen

                                print("<div class='item2' id='plantID$plantId'>
                                    <form method='get'>
                                    <div>
                                
                                        <div id='catatitel'> 
                                            <center><p id='planttitel'>$naam</p></center>
                                        </div>
                                    <input type='text' name='plantID' value='$plantId' style='visibility:$hidden; position:$position'>
                                    <a href='plant.php?plant=$plantId'><img id='imgtest' src='$plantFotoUrl'> </a>
                                    </div>");

                                //Als de gebruiker de rechten heeft om te verwijderen, word er een 'delete knop' weergeven
                                if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3)
                                {
                                    print("<input type='submit' name='btnvinkje' id='btnvinkje' class= 'btnpricelist-red' style='font-size:12px' value='&#x2612;'>");
                                }
                                print"</form></div>";
                            }
                        }
                    }
                    else
                    {
                        //Make a page with the plants from one category
                        $category = $_GET['category'];

                        $sqlCategory = ProtectedGetSQLArray("SELECT * FROM category WHERE CategoryID = ?", array($category));
                        $categoryRegel = $sqlCategory->fetch();
                        $categoryNaam = html_entity_decode($categoryRegel["CategoryNaam"], ENT_QUOTES);
                        echo "<h1>$categoryNaam</h1>";

                        $sqlPrijs = ProtectedGetSQLArray("SELECT * FROM prijs WHERE CategoryID = ?", array($category));
                        //Do this for each prijsregel in the category 
                        while ($row = $sqlPrijs->fetch())
                        {
                            $prijsID = html_entity_decode($row["PrijsID"], ENT_QUOTES);
                            $sqlPlant = ProtectedGetSQLArray(
                                    "SELECT * 
                                 FROM plant 
                                 LEFT JOIN plantfoto pf
                                 ON plant.PlantID=pf.PlantID
                                 WHERE plant.PrijsID = ? AND pf.TypeFoto = 1", array($prijsID)
                            );

                            //Get all of the plants from prijsregel
                            while ($plant = $sqlPlant->fetch())
                            {
                                $plantId = html_entity_decode($plant['PlantID'], ENT_QUOTES);
                                $naam = html_entity_decode($plant['Naam'], ENT_QUOTES);
                                $plantFotoUrl = html_entity_decode($plant['FotoUrl']);
                                $hidden = "hidden";
                                $position = "absolute";

                                //print a plant with the atributes
                                print("<div class='item2' id='plantID$plantId'>
                            <div>
                            <form method='get'>
                            <table>
                                <tr >
                                    <div id='catatitel'> <center><p id='planttitel'>$naam</p></center></div>
                                    <input type='text' name='plantID' value='$plantId' style='visibility:$hidden; position:$position'>
                                    <span></span><a href='plant.php?plant=$plantId'><img id='imgtest' src='$plantFotoUrl'> </a>
                            </table>
                            </div>");
                                
                                //If the user has the right permissions, a delete button is created.
                                if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3)
                                {
                                    print("<input type='submit' name='btnvinkje' id='btnvinkje' value='&#x2612;'>");
                                }
                                print"</form></div>";
                            }
                        }
                    }
                    ?>
                </section>
            </section>
        </section>
        <?php
        include '../Php/footer.php';
        ?>
    </body>
</html>