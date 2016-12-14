
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
            <section id="top">
                <section id="header"></section>
                <?php
                include '../Php/menu.php';
                ?>
            </section>
            <section id="mid">
                <section id="rightmenu">
                    <div id="google_translate_element"></div><script type="text/javascript">
                        function googleTranslateElementInit() {
                            new google.translate.TranslateElement({pageLanguage: 'nl', includedLanguages: 'en,it,nl,sv', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
                        }
                    </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                    <h3>Catalogus</h3>
                    <ul id="catalogus">
                        <?php
                        $sqlCategory = getSQLArray("SELECT * FROM category");
                        while ($row = $sqlCategory->fetch()) {
                            $categoryNaam = $row["CategoryNaam"];
                            $id = $row["CategoryID"];
                            print "<a href='catalog.php?category=$id'><li>$categoryNaam</li></a>";
                        }
                        ?>
                    </ul>
                </section>
                <section id="maincontent">
                    <?php
                    include_once '../Php/DatabaseInformation.php';

                    if (isset($_POST["plantID"])) {
                        deletePlant($_POST["plantID"]);
                    }

                    if (!isset($_GET['category'])) {
                        $category = 1;
                    } else {
                        $category = $_GET['category'];
                    }
                    $sqlCategory = getSQLArray("SELECT * FROM category WHERE CategoryID = $category");
                    $categoryRegel = $sqlCategory->fetch();
                    $categoryNaam = $categoryRegel["CategoryNaam"];
                    echo "<h1>$categoryNaam</h1>";

                    $sqlPrijs = getSQLArray("SELECT * FROM prijs WHERE CategoryID = $category");
                    while ($row = $sqlPrijs->fetch()) {
                        $prijsID = $row["PrijsID"];
                        $potmaat = $row["Potmaat"];
                        $hoogte = $row["Potmaat"];
                        $prijsKwekerij = $row["PrijsKwekerij"];
                        $prijsVBA = $row["PrijsVBA"];
                        $perCC = $row["ProductenCC"];
                        $perLaag = $row["ProductenLaag"];
                        $perTray = $row["ProductenTray"];
                        $sqlPlant = getSQLArray(
                                "SELECT* 
                                 FROM plant 
                                 LEFT JOIN plantfoto pf
                                 ON plant.PlantID=pf.PlantID
                                 WHERE plant.PrijsID = $prijsID AND pf.TypeFoto = 1"
                        );

                        if (isset($_SESSION['logged_in'])) {


                            echo "<div class='item'>
                            <div>
                             <table>
                             <form method='post' action='../php/toevoegen.php'>
                                
                               
                                <td><label>Naam:</label></td>
                                <td><input id='name' name='name'type='tekst' required></td>
                                <tr>
                                <td><label>Groep:</label></td>
                                <td>
                                <select id='groep' name='groep'>";
                            $sqlPrijs = getSQLArray("SELECT * FROM prijs");
                            while ($row = $sqlPrijs->fetch()) {
                                $naamPrijs = $row["Naam"];
                                $IDPrijs = $row["PrijsID"];
                                echo "<option value='$IDPrijs'>$naamPrijs</option>";
                            }
                            echo "</select>
                                </td>
                                <tr>
                                <td>Min.Hoogte:</td>
                                <td><input placeholder='Hoogte (Alleen getal)' name='hoogte_min' type='text' required></td>
                                <tr>
                                <td>Max.Hoogte:</td>
                                <td><input  placeholder='Hoogte (Alleen getal)' name='hoogte_max' type='text'required></td>
                                <tr>
                                <td>Bloeitijd:</td>
                                <td><input  placeholder='Maand' name='bloeitijd' type='text'required> </td>
                                <tr>
                                <td>Bloeiwijze:</td>
                                <td><input placeholder='Bloeiwijze'  name='bloeiwijze' type='text'requires></td>
                                 </table>
                            <button onclick='createManager(" . "false" . ")'>Selecteer Afbeelding</button>  
                            </div>
                               <input type='submit' name='btnvinkje' id='btnvinkje' value='&#x2714'>
                               </form>
                            </div>";
                        }

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

                            echo "<div class='item2' id='plantID$plantId'>
                            <div>
                            <form method='post' action=''>
                            <table>
                                <tr >
                                    <div id='catatitel'> <center><p id='planttitel'>$naam</p></center></div>
                                    <input type='text' name='plantID' value='$plantId' style='visibility:$hidden; position:$position'>
                                    <a href='plant.php?plant=$plantId'><img id='imgtest' src='../Images/Catalogus fotos/$plantFotoUrl'> </a>
                            </table>
                            </div>";

                            if (isset($_SESSION['logged_in'])) {
                                print("<input type='submit' name='btnvinkje' id='btnvinkje' value='&#x2612;'>");
                            }
                            echo"
                            </form>
                            </div>";
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