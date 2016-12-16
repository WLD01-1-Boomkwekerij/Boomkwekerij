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
                    $row = $sqlPrijs->fetch();
                        $prijsID = $row["PrijsID"];
                        $potmaat = $row["Potmaat"];
                        $prijsKwekerij = $row["PrijsKwekerij"];
                        $prijsVBA = $row["PrijsVBA"];
                        $perCC = $row["ProductenCC"];
                        $perLaag = $row["ProductenLaag"];
                        $perTray = $row["ProductenTray"];
                        $sqlPlant = getSQLArray("SELECT * FROM plant WHERE PlantID = $plant");
                        $plantRegel = $sqlPlant->fetch();
                        $naam = $plantRegel['Naam'];
                        $hoogte = $plantRegel['Hoogte_min'] . "/" .  $plantRegel['Hoogte_max'];   ;
                        if( $plantRegel['Hoogte_min'] == $plantRegel['Hoogte_max'] ){
                            $hoogte =  $plantRegel['Hoogte_min']; 
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
                <section id="maincontent">
                    <div id="plantnaamfoto"><center><?php echo $naam; ?></center></div>
                    <section id="PhotoFrame">
                        <?php
                        $EersteFoto = getSQLArray("SELECT * FROM plantfoto WHERE PlantID = $plant AND TypeFoto = 1");
                        $EersteFotoRegel = $EersteFoto->fetch();
                        $EersteFotoUrl = $EersteFotoRegel["FotoUrl"];
                        echo "<img id='ImageFrame' src='$EersteFotoUrl'>";
                        ?>
                        <div id="Positioner">             
                       <?php
                            $Fotoos = getSQLArray("SELECT * FROM plantfoto  WHERE PlantID = $plant");
                            while ($row = $Fotoos->fetch()) {
                                $url = $row["FotoUrl"];
                                echo "<img id='fotoos' onclick='ChangeImage()' class='UnderImage' src='$url'> " . " ";
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
