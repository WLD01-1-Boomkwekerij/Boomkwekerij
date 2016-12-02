<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="notranslate">Boomkwekerij - Aanbiedingen</title>
        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <?php
        session_start();
        //if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
        print("<link href='../Css/EditableCss.css' rel='stylesheet' type='text/css'>");
        print("<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>");
        print("<script src='../Javascript/InformationEditing.js'></script>");
        // }
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
                    //Gebruik dit commando met de TextID van de tekst om hem altijd te laten werken
                    print("<div ");
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
                        print("class='ContentEditable'");
                    }
                    print("id = 'textID1'>");
                    print(loadTextFromDB(1));
                    print("</div>");
                    ?>
                </section>
            </section>
        </section>
        <?php
        include '../Php/footer.php';
        ?>
    </body>
</html>