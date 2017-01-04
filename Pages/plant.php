<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="notranslate">Boomkwekerij - Home</title>
        <!-- Icon Pack -->
        <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="plant icon" href="../Images/plant_icon.png">
        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link href="../Css/PlantStyle.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
        <?php
        session_start();

        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['toegang'] != 3)
        {

            include '../Php/loggedInEditor.php';
            print("<script type='text/javascript' src='../Javascript/PlantPage.js'></script>");
            print("<link href='../Css/LoggedIn/PlantPageStyle.css' rel='stylesheet' type='text/css'>");
        }
        ?>
        <script type="text/javascript">

            function ChangeImage()
            {
                var imageParent = document.getElementById('ImageFrame').parentNode;

                var smallParent = event.target.parentNode;

                if ($(imageParent).hasClass("1"))
                {
                    $(imageParent).removeClass("1");
                }
                else if ($(imageParent).hasClass("2"))
                {
                    $(imageParent).removeClass("2");
                }

                var className = $(smallParent).attr("class");
                $(imageParent).addClass(className);

                document.getElementById('ImageFrame').className = smallParent.id;
                document.getElementById('ImageFrame').src = event.target.src;

                deleteEditing();
                loadEditing();
            }
        </script>
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
                <section id="rightmenu">
                    <?php
                    if (isset($_GET["plant"]))
                    {
                        $plant = $_GET["plant"];
                    }
                    else
                    {
                        $plant = 3;
                    }
                    if (isset($_GET["PlantBewerken"]))
                    {
                        if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3)
                        {
                            $Hoogtemax = $_GET["Hoogtemax"];
                            $Hoogtemin = $_GET["Hoogtemin"];
                            $Bloeitijd = $_GET["Bloeitijd"];
                            $Bloeiwijze = $_GET["Bloeiwijze"];
                            ProtectedDoSQL("UPDATE plant SET hoogte_min = ?, hoogte_max = ?, bloeitijd = ?, bloeiwijze = ? WHERE PlantID = ? ",
                                    array($Hoogtemin, $Hoogtemax, $Bloeitijd, $Bloeiwijze, $plant));
                        }
                    }
                    $sqlPrijs = ProtectedGetSQLArray("SELECT * FROM prijs WHERE PrijsID = (SELECT PrijsID FROM plant WHERE PlantID = ?)", array($plant));
                    $row = $sqlPrijs->fetch();
                    $prijsID = html_entity_decode($row["PrijsID"], ENT_QUOTES);
                    $potmaat = html_entity_decode($row["Potmaat"], ENT_QUOTES);
                    $prijsKwekerij = html_entity_decode($row["PrijsKwekerij"], ENT_QUOTES);
                    $prijsVBA = html_entity_decode($row["PrijsVBA"], ENT_QUOTES);
                    $perCC = html_entity_decode($row["ProductenCC"], ENT_QUOTES);
                    $perLaag = html_entity_decode($row["ProductenLaag"], ENT_QUOTES);
                    $perTray = html_entity_decode($row["ProductenTray"], ENT_QUOTES);
                    $sqlPlant = ProtectedGetSQLArray("SELECT * FROM plant WHERE PlantID = ?", array($plant));
                    $plantRegel = $sqlPlant->fetch();
                    $naam = html_entity_decode($plantRegel['Naam'], ENT_QUOTES);
                    $hoogte = html_entity_decode($plantRegel['Hoogte_min'], ENT_QUOTES) . "/" . html_entity_decode($plantRegel['Hoogte_max'], ENT_QUOTES);
                    
                    
                    if ($plantRegel['Hoogte_min'] == $plantRegel['Hoogte_max'])
                    {
                        $hoogte = html_entity_decode($plantRegel['Hoogte_min'], ENT_QUOTES);
                    }
                    $bloeitijd = html_entity_decode($plantRegel['Bloeitijd'], ENT_QUOTES);
                    $bloeiwijze = html_entity_decode($plantRegel['Bloeiwijze'], ENT_QUOTES);

                    echo "<div class='item'>
                        <h6>Informatie</h6>
                            <table>
                                <tr>
                                    <td>Bloeitijd:</td>
                                    <td>$bloeitijd</td>
                                </tr>
                                <tr>
                                    <td>Bloeiwijze:</td>
                                    <td>$bloeiwijze</td>
                                </tr>
                                <tr>
                                    <td>potmaat:</td>
                                    <td>$potmaat</td>
                                </tr>
                                <tr>
                                    <td>hoogte:</td>
                                    <td>$hoogte</td>
                                </tr>
                                <tr>
                                    <td>prijs kwekerij:</td>
                                    <td>$prijsKwekerij</td>
                                </tr>
                                <tr>
                                    <td>prijs VBA:</td>
                                    <td>$prijsVBA</td>
                                </tr>
                                <tr>
                                    <td>per cc:</td>
                                    <td>$perCC</td>
                                </tr>
                                <tr>
                                    <td>per laag:</td>
                                    <td>$perLaag</td>
                                </tr>
                                <tr>
                                    <td>per tray:</td>
                                    <td>$perTray</td>
                                </tr>
                            </table>
                        </div>";
                    ?>
                </section>

                <?php
                if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3)
                {
                    echo "<section id='PlantUpdateMenu'>";

                    if (isset($_GET["plant"]))
                    {
                        $plant = $_GET["plant"];
                    }
                    else
                    {
                        $plant = 3;
                    }
                    $sqlPrijs = ProtectedGetSQLArray("SELECT * FROM prijs WHERE PrijsID = (SELECT PrijsID FROM plant WHERE PlantID = ?)", array($plant));
                    $row = $sqlPrijs->fetch();
                    $prijsID = html_entity_decode($row["PrijsID"], ENT_QUOTES);
                    $potmaat = html_entity_decode($row["Potmaat"], ENT_QUOTES);
                    $prijsKwekerij = html_entity_decode($row["PrijsKwekerij"], ENT_QUOTES);
                    $prijsVBA = html_entity_decode($row["PrijsVBA"], ENT_QUOTES);
                    $perCC = html_entity_decode($row["ProductenCC"], ENT_QUOTES);
                    $perLaag = html_entity_decode($row["ProductenLaag"], ENT_QUOTES);
                    $perTray = html_entity_decode($row["ProductenTray"], ENT_QUOTES);
                    $sqlPlant = ProtectedGetSQLArray("SELECT * FROM plant WHERE PlantID = ?", array($plant));
                    $plantRegel = $sqlPlant->fetch();
                    $naam = html_entity_decode($plantRegel['Naam'], ENT_QUOTES);
                    $hoogte = html_entity_decode($plantRegel['Hoogte_min'], ENT_QUOTES) . "/" . $plantRegel['Hoogte_max'];
                    $hoogtemin = html_entity_decode($plantRegel['Hoogte_min'], ENT_QUOTES);
                    $hoogtemax = html_entity_decode($plantRegel['Hoogte_max'], ENT_QUOTES);
                    if ($hoogtemin == $hoogtemax)
                    {
                        $hoogte = html_entity_decode($plantRegel['Hoogte_min'], ENT_QUOTES);
                    }
                    $bloeitijd = html_entity_decode($plantRegel['Bloeitijd'], ENT_QUOTES);
                    $bloeiwijze = html_entity_decode($plantRegel['Bloeiwijze'], ENT_QUOTES);

                    echo "<div class='item'>
                            <form action='Plant.php' method='get'>
                            <h6>Bewerken</h6>
                            <table>
                                <tr>
                                    <td>Bloeitijd:</td>
                                    <td><input type='text' name='Bloeitijd' value='$bloeitijd'> </td>
                                </tr>
                                <tr>
                                    <td>Bloeiwijze:</td>
                                    <td><input type='text' name='Bloeiwijze' value='$bloeiwijze'></td>
                                </tr>
                                <tr>
                                    <td>Hoogte:</td>
                                    <td><input type='number' placeholder='Minimale Hoogte'  name='Hoogtemin' value='$hoogtemin'></td>
                                    <tr>
                                    <td></td>
                                    <td><input type='number' placeholder='Maximale Hoogte' name='Hoogtemax' value='$hoogtemax'></td>
                                </tr>

                            </table>
                            <input type='hidden' name='plant' value='$plant'>
                            <input type='submit' id='opslaan2' name='PlantBewerken' class='button-green' value='Opslaan'>
                            </form>
                        </div>";
                }
                echo "</section>";
                ?>

                <section id="maincontent">
                    <br>
                    <div id="plantnaamfoto">
                        <center>
                            <?php echo $naam; ?>
                        </center>
                    </div>
                    <section id="PhotoFrame">
                        <?php
                        $EersteFoto = ProtectedGetSQLArray("SELECT * FROM plantfoto WHERE PlantID = ? AND TypeFoto = 1", array($plant));
                        $EersteFotoRegel = $EersteFoto->fetch();
                        $EersteFotoUrl = html_entity_decode($EersteFotoRegel["FotoUrl"], ENT_QUOTES);

                        print("<div id='ImageContainer' class=''>");
                        print("<img id='ImageFrame' src='$EersteFotoUrl'>");
                        print("</div>");
                        ?>
                        <div id="Positioner">
                            <?php
                            $Fotoos = ProtectedGetSQLArray("SELECT * FROM plantfoto  WHERE PlantID = ?", array($plant));
                            while ($row = $Fotoos->fetch())
                            {
                                $url = html_entity_decode($row["FotoUrl"]);
                                $type = html_entity_decode($row["TypeFoto"], ENT_QUOTES);
                                $fotoId = html_entity_decode($row["FotoID"], ENT_QUOTES);
                                print("<div id='$fotoId' class='$type' style='display: inline-block'>");
                                print("<img id='fotoos' onclick='ChangeImage()' class='UnderImage' src='$url'></div>");
                            }

                            if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3)
                            {
                                $plantID = $_GET['plant'];
                                print("<img id='$plantID' class='icon-image-add' style='width: 50px; cursor: pointer' onclick='addPlantImage(this)'>");
                            } 
                            ?>
                        </div>
                    </section>
                </section>
            </section>
        </section>
        <?php
        include '../Php/footer.php';
        ?>
    </body>
</html>
