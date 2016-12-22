<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="notranslate">Boomkwekerij - Aanbiedingen</title>
        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link href="../Css/NewsStyle.css" rel="stylesheet" type="text/css">
        <link rel="plant icon" href="../Images/plant_icon.png">
        <?php
        session_start();
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
        {
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
                    <?php
                    include '../Php/rightmenu.php'; 
                    ?>
                </section>
                <section id="maincontent">
                    <?php
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
                    {
                        print("<div class='newsDiv WidthFix' id='newNews' style='position: relative'>"
                                . "<div class='ContentEditable' style='width: 100%; height: 100%; position: absolute; z-index: 1000'></div>"
                                . "<div class='newsTop'>Nieuw Bericht toevoegen</div>"
                                . "<div style='padding 5px; min-height: 140px;'></div></div>");
                    }

                    $sql = "SELECT t.Tekst, a.AanbiedingID, a.Titel, a.DatumGeplaatst, t.TekstID
                            FROM aanbieding a
                            JOIN tekst t
                            ON a.TekstID = t.TekstID
                            ORDER BY a.DatumGeplaatst DESC";

                  
                    $statement=  BeveiligGetSQL($sql, array());

                    while ($row = $statement->fetch())
                    {
                        $text = $row["Tekst"];
                        $aanBiedingID = $row["AanbiedingID"];
                        $textID = $row["TekstID"];
                        $Title = $row["Titel"];
                        $Datum = $row["DatumGeplaatst"];

                        print ("<div class='newsDiv clearFix WidthFix' id='newsID$aanBiedingID' style='position: relative'>"
                                . "<div class='ContentEditable' style='width: 100%; height: 100%; position: absolute; z-index: 1000'><div style='float: right'><p id='timestamp'>$Datum</p></div></div>"
                                 . "<div class='newsTop'> $Title </div>"
                                . ""
                                . "<div id='textID$textID' style=' padding: 5px;'>"
                                . htmlspecialchars_decode($text) . "</div>");
                        print("</div>");
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