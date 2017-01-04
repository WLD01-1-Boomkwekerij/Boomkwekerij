<?php
include'/../Php/Database.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="notranslate">Boomkwekerij - Catalogus</title>
        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link href="../Css/CatalogStyle.css" rel="stylesheet" type="text/css">
        <link rel="plant icon" href="../Images/plant_icon.png">
        <?php
        session_start();

        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
        {
            include '../Php/loggedInEditor.php';
            print("<script src='../Javascript/Catalog.js'></script>");
        }
        ?>
    </head>
    <body>
        <?php
        if (isset($_GET["category"]))
        {
            $cat = $_GET["category"];
            echo "<div style='display:none;' id='category'>$cat</div>";
        }
        ?>

        <section id="wrapper">
            <section id='titlediv'><p id="imgtitle">FA.P. BOER BOOMKWEKERIJ</p></section>
            <section id="top">
                <section id="header"></section>
                <?php
                include '../Php/menu.php';
                ?>
            </section>
            <section id="mid">
                <?php
                if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3)
                {
                    if (isset($_GET["category"]))
                    {
                        print("<script>createCatalogAddition();</script>");
                    }
                }
                ?>
                <section id="rightmenu">
                    <div id="google_translate_element">
                        <script type="text/javascript">
                            function googleTranslateElementInit()
                            {
                                new google.translate.TranslateElement({pageLanguage: 'nl', includedLanguages: 'en,it,nl,sv', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
                            }
                        </script>
                        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
                        </script>
                    </div>
                    <h3 id="a">Soorten</h3>

                    <ul id="catalogus">
                        <?php
                        //Creates the sidevar category options
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
                    if (isset($_GET["plantID"]))
                    {
                        deletePlant($_GET["plantID"]);
                    }

                    if (!isset($_GET['category']))
                    {
                        $sqlCategory = ProtectedGetSQLArray("SELECT * FROM category", array());
                        $categoryRegel = $sqlCategory->fetch();
                        $categoryNaam = $categoryRegel["CategoryNaam"];
                        echo "<h1 id='catalogustitle2'>$categoryNaam</h1>";

                        $sqlPrijs = ProtectedGetSQLArray("SELECT * FROM prijs", array());

                        while ($row = $sqlPrijs->fetch())
                        {
                            $prijsID = $row["PrijsID"];
                            $potmaat = $row["Potmaat"];
                            $hoogte = $row["Potmaat"];
                            $prijsKwekerij = $row["PrijsKwekerij"];
                            $prijsVBA = $row["PrijsVBA"];
                            $perCC = $row["ProductenCC"];
                            $perLaag = $row["ProductenLaag"];
                            $perTray = $row["ProductenTray"];
                            $sqlPlant = ProtectedGetSQLArray(
                                    "SELECT * 
                                 FROM plant 
                                 LEFT JOIN plantfoto pf
                                 ON plant.PlantID=pf.PlantID
                                 WHERE plant.PrijsID = ? AND pf.TypeFoto = 1", array($prijsID)
                            );

                            while ($plant = $sqlPlant->fetch())
                            {
                                $plantId = $plant['PlantID'];
                                $naam = $plant['Naam'];
                                $Hoogte_min = $plant['Hoogte_min'];
                                $Hoogte_max = $plant['Hoogte_max'];
                                $bloeiwijze = $plant['Bloeiwijze'];
                                $bloeitijd = $plant['Bloeitijd'];
                                $plantFotoUrl = $plant['FotoUrl'];

                                $hidden = "hidden";
                                $position = "absolute";

                                print("<div class='item2' id='plantID$plantId'>
                                    <form method='get'>
                                    <div>
                                
                                        <div id='catatitel'> 
                                            <center><p id='planttitel'>$naam</p></center>
                                        </div>
                                    <input type='text' name='plantID' value='$plantId' style='visibility:$hidden; position:$position'>
                                    <a href='plant.php?plant=$plantId'><img id='imgtest' src='$plantFotoUrl'> </a>
                                    </div>");

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
                        $category = $_GET['category'];

                        $sqlCategory = ProtectedGetSQLArray("SELECT * FROM category WHERE CategoryID = ?", array($category));
                        $categoryRegel = $sqlCategory->fetch();
                        $categoryNaam = html_entity_decode($categoryRegel["CategoryNaam"], ENT_QUOTES);
                        echo "<h1>$categoryNaam</h1>";

                        $sqlPrijs = ProtectedGetSQLArray("SELECT * FROM prijs WHERE CategoryID = ?", array($category));

                        while ($row = $sqlPrijs->fetch())
                        {
                            $prijsID = html_entity_decode($row["PrijsID"], ENT_QUOTES);
                            $potmaat = html_entity_decode($row["Potmaat"], ENT_QUOTES);
                            $hoogte = html_entity_decode($row["Potmaat"], ENT_QUOTES);
                            $prijsKwekerij = html_entity_decode($row["PrijsKwekerij"], ENT_QUOTES);
                            $prijsVBA = html_entity_decode($row["PrijsVBA"], ENT_QUOTES);
                            $perCC = html_entity_decode($row["ProductenCC"], ENT_QUOTES);
                            $perLaag = html_entity_decode($row["ProductenLaag"], ENT_QUOTES);
                            $perTray = html_entity_decode($row["ProductenTray"], ENT_QUOTES);
                            $sqlPlant = ProtectedGetSQLArray(
                                    "SELECT * 
                                 FROM plant 
                                 LEFT JOIN plantfoto pf
                                 ON plant.PlantID=pf.PlantID
                                 WHERE plant.PrijsID = ? AND pf.TypeFoto = 1", array($prijsID)
                            );

                            while ($plant = $sqlPlant->fetch())
                            {
                                $plantId = html_entity_decode($plant['PlantID'], ENT_QUOTES);
                                $naam = html_entity_decode($plant['Naam'], ENT_QUOTES);
                                $Hoogte_min = html_entity_decode($plant['Hoogte_min'], ENT_QUOTES);
                                $Hoogte_max = html_entity_decode($plant['Hoogte_max'], ENT_QUOTES);
                                $bloeiwijze = html_entity_decode($plant['Bloeiwijze'], ENT_QUOTES);
                                $bloeitijd = html_entity_decode($plant['Bloeitijd'], ENT_QUOTES);
                                $plantFotoUrl = html_entity_decode($plant['FotoUrl']);
                                $hidden = "hidden";
                                $position = "absolute";

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