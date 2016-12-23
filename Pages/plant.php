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
        }
        ?>
        <script type="text/javascript">
            function ChangeImage()
            {
                document.getElementById('ImageFrame').src = event.target.src;
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
                            BeveiligDoSQL("UPDATE plant SET hoogte_min = ?, hoogte_max = ?, bloeitijd = '?', bloeiwijze = '?' WHERE PlantID = ? ",array($Hoogtemin,$Hoogtemax,$Bloeitijd,$plant));
                        }
                    }
                    $sqlPrijs = BeveiligGetSQLArray("SELECT * FROM prijs WHERE PrijsID = (SELECT PrijsID FROM plant WHERE PlantID = ?)",array($plant));
                    $row = $sqlPrijs->fetch();
                    $prijsID = $row["PrijsID"];
                    $potmaat = $row["Potmaat"];
                    $prijsKwekerij = $row["PrijsKwekerij"];
                    $prijsVBA = $row["PrijsVBA"];
                    $perCC = $row["ProductenCC"];
                    $perLaag = $row["ProductenLaag"];
                    $perTray = $row["ProductenTray"];
                    $sqlPlant = BeveiligGetSQLArray("SELECT * FROM plant WHERE PlantID = ?",array($plant));
                    $plantRegel = $sqlPlant->fetch();
                    $naam = $plantRegel['Naam'];
                    $hoogte = $plantRegel['Hoogte_min'] . "/" . $plantRegel['Hoogte_max'];
                    ;
                    if ($plantRegel['Hoogte_min'] == $plantRegel['Hoogte_max'])
                    {
                        $hoogte = $plantRegel['Hoogte_min'];
                    }
                    $bloeitijd = $plantRegel['Bloeitijd'];
                    $bloeiwijze = $plantRegel['Bloeiwijze'];

                    echo "<div class='item'>
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
                    $sqlPrijs = BeveiligGetSQLArray("SELECT * FROM prijs WHERE PrijsID = (SELECT PrijsID FROM plant WHERE PlantID = ?)",array($plant));
                    $row = $sqlPrijs->fetch();
                    $prijsID = $row["PrijsID"];
                    $potmaat = $row["Potmaat"];
                    $prijsKwekerij = $row["PrijsKwekerij"];
                    $prijsVBA = $row["PrijsVBA"];
                    $perCC = $row["ProductenCC"];
                    $perLaag = $row["ProductenLaag"];
                    $perTray = $row["ProductenTray"];
                    $sqlPlant = BeveiligGetSQLArray("SELECT * FROM plant WHERE PlantID = ?",array($plant));
                    $plantRegel = $sqlPlant->fetch();
                    $naam = $plantRegel['Naam'];
                    $hoogte = $plantRegel['Hoogte_min'] . "/" . $plantRegel['Hoogte_max'];
                    $hoogtemin = $plantRegel['Hoogte_min'];
                    $hoogtemax = $plantRegel['Hoogte_max'];
                    if ($plantRegel['Hoogte_min'] == $plantRegel['Hoogte_max'])
                    {
                        $hoogte = $plantRegel['Hoogte_min'];
                    }
                    $bloeitijd = $plantRegel['Bloeitijd'];
                    $bloeiwijze = $plantRegel['Bloeiwijze'];

                    echo "<div class='item'>
                            <form action='Plant.php' method='get'>
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
                                    <td>hoogte:</td>
                                    <td><input type='number' name='Hoogtemin' value='$hoogtemin'></td>
                                    <td><input type='number' name='Hoogtemax' value='$hoogtemax'></td>
                                </tr>

                            </table>
                            <input type='hidden' name='plant' value='$plant'>
                            <input type='submit' name='PlantBewerken' value='Opslaan'>
                            </form>
                        </div>";
                }
                echo "</section>";
                ?>

                <section id="maincontent">
                    <br>
                    <div id="plantnaamfoto"><center><?php echo $naam; ?></center></div>
                    <section id="PhotoFrame">
                        <?php
                        $EersteFoto = BeveiligGetSQLArray("SELECT * FROM plantfoto WHERE PlantID = ? AND TypeFoto = 1",array($plant));
                        $EersteFotoRegel = $EersteFoto->fetch();
                        $EersteFotoUrl = $EersteFotoRegel["FotoUrl"];
                        print("<img id='ImageFrame' src='$EersteFotoUrl'>");
                        ?>
                        <div id="Positioner">
                            <?php
                            $Fotoos = BeveiligGetSQLArray("SELECT * FROM plantfoto  WHERE PlantID = ?",array($plant));
                            while ($row = $Fotoos->fetch())
                            {
                                $url = $row["FotoUrl"];
                                print("<img id='fotoos' onclick='ChangeImage()' class='UnderImage' src='$url'> " . " ");
                            }
                            ?>
                            <br>
                            <img class="icon-image-add" style="width: 50px">

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
