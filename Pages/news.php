<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="notranslate">Boomkwekerij - Aanbiedingen</title>
        <?php
        session_start();
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
        {
            include '../Html/includeHead.html';
            include '../Php/loggedInEditor.php';
        }
        ?>
        <link href="../Css/NewsStyle.css" rel="stylesheet" type="text/css">
        <link rel="plant icon" href="../Images/plant_icon.png">
    </head>
    <body>
        <section id="wrapper">
            <section id='titlediv' class="notranslate"><p id="imgtitle">FA.P.BOER BOOMKWEKERIJ</p></section>
            <section id="top">
                <section id="header"></section>
                <?php
                include '../Php/menu.php';
                ?>
            </section>
            <section id="mid">
                <section id="rightmenu">
                    <?php
                    include '../Php/rightmenu.php';
                    ?>
                </section>
                <section id="maincontent">
                    <h1>Aanbiedingen/Nieuws & Updates</h1>
                    <?php
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
                    {
                        // Nieuwsartikel toevoegen
                        print("<div class='newsDiv WidthFix' id='newNews' style='position: relative'>"
                                . "<div class='ContentEditable' style='width: 100%; height: 100%; position: absolute; z-index: 1000'></div>"
                                . "<div class='newsTop'>Nieuw Bericht toevoegen</div>"
                                . "<div style='padding 5px; min-height: 140px;'></div></div>");
                    }

                    $sql = "SELECT t.Tekst, a.AanbiedingID, a.Titel, a.DatumGeplaatst, t.TekstID, a.Zichtbaar
                            FROM aanbieding a
                            JOIN tekst t
                            ON a.TekstID = t.TekstID
                            ORDER BY a.DatumGeplaatst DESC";

                    $statement = ProtectedGetSQLArray($sql, array());

                    while ($row = $statement->fetch())
                    {
                        //Laad alle bestaande nieuwsartikelen
                        $text = $row["Tekst"];
                        $aanBiedingID = $row["AanbiedingID"];
                        $textID = $row["TekstID"];
                        $Title = $row["Titel"];
                        $Datum = $row["DatumGeplaatst"];
                        $visibility = $row["Zichtbaar"];
                        
                        //Controleert of de sessie van de gebruiker actief is
                        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
                        {
                            print ("<div class='newsDiv clearFix WidthFix' id='newsID$aanBiedingID' style='position: relative'>"
                                    . "<div class='ContentEditable' style='width: 100%; height: 100%; position: absolute; z-index: 1000'><div style='float: right'><p id='timestamp'>$Datum</p></div></div>"
                                    . "<div id='$visibility' class='newsTop'> $Title </div>"
                                    . ""
                                    . "<div id='textID$textID' style=' padding: 5px;'>"
                                    . htmlspecialchars_decode($text) . "</div>");
                            print("</div>");
                        }
                        else
                        {
                            //Controleert of de zichbaarheid van het betreffende nieuwsbericht is aangevinkt, zo ja -> voert de onderstaande code uit
                            if($visibility == 1)
                            {
                                print ("<div class='newsDiv clearFix WidthFix' id='newsID$aanBiedingID' style='position: relative'>"
                                    . "<div class='ContentEditable' style='width: 100%; height: 100%; position: absolute; z-index: 1000'><div style='float: right'><p id='timestamp'>$Datum</p></div></div>"
                                    . "<div class='newsTop'> $Title </div>"
                                    . ""
                                    . "<div id='textID$textID' style=' padding: 5px;'>"
                                    . htmlspecialchars_decode($text) . "</div>");
                            print("</div>");
                            }
                        }
                    }

                    print("<div class='downPositioner'></div>");
                    ?>
                </section>
            </section>
        </section>
<?php
include '../Php/footer.php';
?>
    </body>
</html>