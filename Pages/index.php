<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="notranslate">Boomkwekerij - Aanbiedingen</title>
        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
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
                    include '../Php/rightmenu.php';
                    ?>
                </section>
                <section id="maincontent">
                    <h1>Boomkwekerij - Familie P. Boer</h1>
                    <?php
                    //Gebruik dit commando met de TextID van de tekst om hem altijd te laten werken
                    print("<div class='clearFix WidthFix' id='tekstDIV' style='position: relative'>");
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
                    {
                        print("<div class='ContentEditable' style='width: 100%; height: 100%; position: absolute; z-index: 1000'></div>");
                    }
                    print("<div id='textID1' class='editContent'>");
                    loadTextFromDB(1);
                    print("</div>");
                    
                    print("<div id='images'></div>");
                    
                    print("</div");
                    ?>
                    <br>
                    <div class="downPositioner"></div>
                </section>
            </section>
        </section>


        <?php
        include '../Php/footer.php';
        ?>
    </body>
</html>