<?php
// We werken ook hier met sessies 
session_start();

// Controleren of de bezoeker ingelogd is 
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
    header('Location:login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Boomkwekerij - Catalogus</title>
            <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">

            <script>
                function chooseFile() {
                    $("#fileInput").click();
                }
            </script>
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
                            <?php
                            if (isset($_SESSION['logged_in'])) {
                                print("<li><a href='../pages/logged_in.php'>Beheerderspagina</a></li>");
                            }
                            ?>
                        </ul>
                    </section>
                </section>

                <section id="mid">
                    <section id="rightmenu">
                        <h3>Catalogus</h3>
                        <ul id="catalogus">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </section>
                    <section id="maincontent">
                        <button title="Click to show/hide content" type="button" onclick="if (document.getElementById('spoiler1').style.display == 'none') {
                                    document.getElementById('spoiler1').style.display = ''
                                } else {
                                    document.getElementById('spoiler1').style.display = 'none'
                                }">Catalogus bewerken</button>

                        <button title="Click to show/hide content" type="button" onclick="if (document.getElementById('spoiler2').style.display == 'none') {
                                    document.getElementById('spoiler2').style.display = ''
                                } else {
                                    document.getElementById('spoiler2').style.display = 'none'
                                }">Nieuwsartikel toevoegen</button>

                        <section id="editkader">

                            <div id="spoiler1" style="display:none"> 
                                <form method="post" action="../Php/config.php">
                                    <table border="1">
                                        <th>Nr.</th>
                                        <th>Potmaat</th>
                                        <th>Hoogte</th>
                                        <th>Prijs Kwek.</th>
                                        <th>Prijs VBA</th>
                                        <th>Per cc</th>
                                        <th>Per laag</th>
                                        <th>Per tray</th>
                                        <th>Afbeelding</th>
                                        <tr>
                                            <td><input name="nr" type="tekst"></td>
                                            <td><input name="potmaat" type="tekst"></td>
                                            <td><input name="hoogte" type="tekst"></td>
                                            <td><input name="prijskwek" type="tekst"></td>
                                            <td><input name="prijsvba" type="tekst"></td>
                                            <td><input name="percc" type="tekst"></td>
                                            <td><input name="perlaag" type="tekst"></td>
                                            <td><input name="pertray" type="tekst"></td>
                                            <td><button type="button" onclick="chooseFile();">Afbeelding uploaden</button>
                                            </td>


                                    </table>
                                    <br>
                                    <input type="submit" id="btntoevoegen" value="Toevoegen">
                                </form>
                            </div> 


                            <div id="spoiler2" style="display:none"> 
                                <form>
                                    <table border="1">
                                        <th>Test</th>

                                    </table>
                                </form>
                            </div> 

                        </section>
                    </section>
                </section>
            </section>
            <section id="footer">
                <?php
                if (isset($_SESSION['logged_in'])) {
                    print("<li><a href='../Php/loggout.php'>Uitloggen</a></li>");
                } else {
                    print("<li><a href='../pages/login.php'>Inloggen</a></li>");
                }
                ?>
            </section>
        </body>
    </html>