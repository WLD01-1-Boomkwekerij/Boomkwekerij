<?php include'/../Php/Database.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="notranslate">Boomkwekerij - Catalogus</title>
        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link href="../Css/CatalogStyleBig.css" rel="stylesheet" type="text/css">
        <link rel="plant icon" href="../Images/plant_icon.png">
        <?php
        session_start();

        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            include '../Php/loggedInEditor.php';
        }
        ?>
    </head>
    <body>
        <section id="wrapper">
            <section id='titlediv'><p id="imgtitle">FA.P.BOER BOOMKWEKERIJ</p></section>
            <section id="top">
                <section id="header"></section>
                <?php
                include '../Php/menu.php';
                ?>
            </section>
            <section id="mid">
                <?php
                if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3) {
                    ?>
                    <script>
                        createCatalogAddition();
                    </script>
                    <?php
                }
                ?>
                <section id="rightmenu">
                    <div id="google_translate_element"></div><script type="text/javascript">
                        function googleTranslateElementInit()
                        {
                            new google.translate.TranslateElement({pageLanguage: 'nl', includedLanguages: 'en,it,nl,sv', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
                        }
                    </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                    <h3>Soorten</h3>

                    <ul id="catalogus">
                        <?php
                        //Creates the sidevar category options
                        $sqlCategory = BeveiligGetSQLArray("SELECT * FROM category",array());

                        while ($row = $sqlCategory->fetch()) {
                            $categoryNaam = $row["CategoryNaam"];
                            $id = $row["CategoryID"];
                            echo "<table id='catatabel' border='3'><td> <a href='catalog.php?category=$id'><li>$categoryNaam</li></a></td> </table> ";
                        }
                        ?>
                    </ul>

                </section>

                <section id="maincontent">

                    <?php
                    if (isset($_GET["plantID"])) {
                        deletePlant($_GET["plantID"]);
                    }

                    if (!isset($_GET['category'])) {
                        $category = 1;
                    } else {
                        $category = $_GET['category'];
                    }
                    $sqlCategory = BeveiligGetSQLArray("SELECT * FROM category WHERE CategoryID = ?",array($category));
                    $categoryRegel = $sqlCategory->fetch();
                    $categoryNaam = $categoryRegel["CategoryNaam"];
                    echo "<h1>$categoryNaam</h1>";

                    $sqlPrijs = BeveiligGetSQLArray("SELECT * FROM prijs WHERE CategoryID = ?",array($category));

                    while ($row = $sqlPrijs->fetch()) {
                        $prijsID = $row["PrijsID"];
                        $potmaat = $row["Potmaat"];
                        $hoogte = $row["Potmaat"];
                        $prijsKwekerij = $row["PrijsKwekerij"];
                        $prijsVBA = $row["PrijsVBA"];
                        $perCC = $row["ProductenCC"];
                        $perLaag = $row["ProductenLaag"];
                        $perTray = $row["ProductenTray"];
                        $sqlPlant = BeveiligGetSQLArray(
                                "SELECT * 
                                 FROM plant 
                                 LEFT JOIN plantfoto pf
                                 ON plant.PlantID=pf.PlantID
                                 WHERE plant.PrijsID = ? AND pf.TypeFoto = 1",array($prijsID)
                        );

                        while ($plant = $sqlPlant->fetch()) {
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
                            <div>
                            <form method='get'>
                            <table>
                                <tr >
                                    <div id='catatitel'> <center><p id='planttitel'>$naam</p></center></div>
                                    <input type='text' name='plantID' value='$plantId' style='visibility:$hidden; position:$position'>
                                    <span></span><a href='plant.php?plant=$plantId'><img id='imgtest' src='$plantFotoUrl'> </a>
                            </table>
                            </div>");

                            if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3) {
                                print("<input type='submit' name='btnvinkje' id='btnvinkje' value='&#x2612;'>");
                            }
                            print"</form></div>";
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