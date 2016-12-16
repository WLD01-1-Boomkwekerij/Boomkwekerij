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
                <section id="maincontent" style="overflow-y: scroll">
                    <?php
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
                    {
                        print("<div class='newsDiv ContentEditable'><div class='newsTop'>Nieuw Bericht toevoegen</div><div style='padding 5px; min-height: 140px;'></div></div>");
                    }


                    $sql = "SELECT t.Tekst, a.AanbiedingID, a.Titel
                            FROM aanbieding a
                            JOIN tekst t
                            ON a.TekstID = t.TekstID";

                    $connection = connectToDatabase();
                    $statement = $connection->prepare($sql);
                    $statement->execute();

                    while ($row = $statement->fetch())
                    {
                        $text = $row["Tekst"];
                        $aanBiedingID = $row["AanbiedingID"];
                        $Title = $row["Titel"];

                        print ("<div class='newsDiv'>"
                                . "<div class='newsTop'> $Title"
                        );
                        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
                        {
                            print("<button class='fa fa-trash-o' onclick='deleteArticle($aanBiedingID)'></button>");
                        }
                        print("</div><div style=' padding: 5px;'>"
                                . htmlspecialchars_decode($text)
                                . "</div></div>");
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