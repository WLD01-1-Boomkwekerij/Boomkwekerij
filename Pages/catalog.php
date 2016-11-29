<!DOCTYPE html>
<?php include'/../Php/Database.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Boomkwekerij - Catalogus</title>
        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link media="screen and (max-width:1288px)" href="../Css/CatalogStyleSmall.css" rel="stylesheet" type="text/css">
        <link media="screen and (min-width:1288px)" href="../Css/CatalogStyleBig.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <section id="wrapper">
            <section id="top">
                <section id="header"></section>
                <section id="topmenu">
                    <ul>
                        <li><a href="../pages/index.php">Home</a></li>
                        <li><a href="../pages/news.php">Nieuws</a></li>
                        <li><a href="../pages/catalog.php">Catalogus</a></li>
                        <li><a href="../pages/pricelist.php">Prijslijst</a></li> 
                        <li><a href="../pages/contact.php">Contact</a></li>
                    </ul>
                </section>
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
                        <li>Plant1</li>
                        <li>Plant2</li>
                        <li>plant3</li>
                        <li>plant4</li>
                    </ul>
                </section>
                <section id="maincontent">
                    <?php
                    $sql = getSQLArray("SELECT * FROM prijs");

                          
                    while ($row = $sql->fetch()) {
                        $potmaat = $row["Potmaat"];
                        $hoogte = $row["Potmaat"];
                        $prijsKwekerij = $row["PrijsKwekerij"];
                        $prijsVBA = $row["PrijsVBA"];
                        $perCC = $row["ProductenCC"];
                        $perLaag = $row["ProductenLaag"];
                        $perTray = $row["ProductenTray"];
                        echo "<div class='item'>
                        <div>
                            <img src='/Catalogus fotos/Heesters/aucuba tray p13.jpg'>  
                        </div>
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
            </section>
        </section>
        <section id="footer">
            <li><a href="../pages/login.php">Inloggen</a></li>
        </section>
    </body>
</html>