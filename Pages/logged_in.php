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
        <?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            print("<link href='../Css/EditableStyle.css' rel='stylesheet' type='text/css'>");
            print("<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>");
            print("<script src='../Javascript/InformationEditing.js'></script>");
        }
        ?>
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
                    <?php
                    include '../Php/menu.php';
                    ?>
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
                    <button title="Click to show/hide content" type="button" onclick="if (document.getElementById('spoiler1').style.display === 'none') {
                                document.getElementById('spoiler1').style.display = '';
                            } else {
                                document.getElementById('spoiler1').style.display = 'none';
                            }">Catalogusproduct toevoegen</button>

                    <button title="Click to show/hide content" type="button" onclick="if (document.getElementById('spoiler2').style.display === 'none') {
                                document.getElementById('spoiler2').style.display = '';
                            } else {
                                document.getElementById('spoiler2').style.display = 'none';
                            }">Catalogusproduct verwijderen</button>

                    <button title="Click to show/hide content" type="button" onclick="if (document.getElementById('spoiler3').style.display === 'none') {
                                document.getElementById('spoiler3').style.display = '';
                            } else {
                                document.getElementById('spoiler3').style.display = 'none';
                            }">Nieuwsartikel toevoegen</button>

                    <button title="Click to show/hide content" type="button" onclick="if (document.getElementById('spoiler4').style.display === 'none') {
                                document.getElementById('spoiler4').style.display = '';
                            } else {
                                document.getElementById('spoiler4').style.display = 'none';
                            }">Gebruikers beheren</button>



                    <section id="editkader">

                        <div id="spoiler1" style="display:none"> 
                            <center> <h4><u>Catalogusproduct toevoegen</u></h4>
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
                                            <td><input name="nr" id="nr" type="tekst"></td>
                                            <td><input name="potmaat"  id="potmaat" type="tekst"></td>
                                            <td><input name="hoogte" id="hoogte" type="tekst"></td>
                                            <td><input name="prijskwek" id="prijskwek" type="tekst"></td>
                                            <td><input name="prijsvba" id="prijsvba" type="tekst"></td>
                                            <td><input name="percc" id="percc" type="tekst"></td>
                                            <td><input name="perlaag" id="perlaag" type="tekst"></td>
                                            <td><input name="pertray" id="pertray" type="tekst"></td>
                                            <td><button type="button"  onclick="chooseFile();">Afbeelding uploaden</button>
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

                        <div id="spoiler3" style="display:none"> 

                        </div>

                        <div id="spoiler4" style="display:none"> 
                            <center><h4><u>Gebruikers beheren</u></h4>  
                                <forum>
                                    <table border="1">
                                        <th class="ContentEditable">ID</th>
                                        <th>Naam</th>
                                        <th>Email</th>
                                        <th>Type</th>
                                        <th>Verwijderen</th>
                                        <tr>
                                            <td><input name="gebr_id" id="gebr_id" type="tekst"></td>
                                            <td><input name="gebr_naam" id="gebr_naam" type="tekst"></td>
                                            <td><input name="gebr_email" id="gebr_email" type="tekst"></td>
                                            <td><input name="gebr_type" id="gebr_type" type="tekst"></td>

                                    </table>    
                                </forum>
                            </center>
                        </div>

                    </section>
                </section>
            </section>
            <?php
            include '../Php/footer.php';
            ?>
        </body>
    </html>