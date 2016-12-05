<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="notranslate">Boomkwekerij - Home</title>
        <!-- Icon Pack -->
        <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">

        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link href="../Css/PlantStyle.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
        <?php
        session_start();

        include_once '../Php/DatabaseInformation.php';

        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            
            include '../Php/loggedInEditor.php';
        }
        ?>
        <link href="../Css/HomeStyle.css" rel="stylesheet" type="text/css">
        <script type="text/javascript">
            function ChangeImage() {
                document.getElementById('ImageFrame').src = event.target.src;
            }
        </script>
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
                    <?php
                    if (isset($_GET["plant"])) {
                        $plant = $_GET["plant"];
                    } else {
                        $plant = 3;
                    }
                    $sqlPrijs = getSQLArray("SELECT * FROM prijs WHERE PrijsID = (SELECT PrijsID FROM plant WHERE PlantID = $plant)");
                    while ($row = $sqlPrijs->fetch()) {
                        $prijsID = $row["PrijsID"];
                        $potmaat = $row["Potmaat"];
                        $hoogte = $row["Potmaat"];
                        $prijsKwekerij = $row["PrijsKwekerij"];
                        $prijsVBA = $row["PrijsVBA"];
                        $perCC = $row["ProductenCC"];
                        $perLaag = $row["ProductenLaag"];
                        $perTray = $row["ProductenTray"];
                        $sqlPlant = getSQLArray("SELECT * FROM plant WHERE PlantID = $plant");
                        $plantRegel = $sqlPlant->fetch();
                        $naam = $plantRegel['Naam'];
                        echo "<div class='item'>
                            <table>
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
                    }
                    ?>
                </section>
                <section id="maincontent">
                    <?php echo $naam; ?>
                    <section id="PhotoFrame">
                        <?php
                        $EersteFoto = getSQLArray("SELECT * FROM plantfoto WHERE PlantenID = $plant AND TypeFoto = 1");
                        $EersteFotoRegel = $EersteFoto->fetch();
                        $EersteFotoUrl = $EersteFotoRegel["FotoUrl"];
                        echo "<img id='ImageFrame' src='../Catalogus fotos/$EersteFotoUrl'>";
                        ?>
                        <div id="Positioner">             
                            <?php
                            $Fotoos = getSQLArray("SELECT * FROM plantfoto  WHERE PlantenID = $plant");
                            while ($row = $Fotoos->fetch()) {
                                $url = $row["FotoUrl"];
                                echo "<img onclick='ChangeImage()' class='UnderImage' src='../Catalogus fotos/$url'>";
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
