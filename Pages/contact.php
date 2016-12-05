<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="notranslate">Boomkwekerij - Contact</title>
        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link href="../Css/ContactStyle.css" rel="stylesheet" type="text/css">
        <link rel="plant icon" href="../Images/plant_icon.png">
        <?php
        session_start();
        include_once '../Php/DatabaseInformation.php';
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
            </section>        <section id="mid">
            <section id="rightmenu">
                <?php
                include '../Php/rightmenu.php';
                ?>
            </section>
            <section id="maincontent">
                <h1>Aanvraag</h1>
                <form action="contactSend.php" method="post">
                    Naam: <br><input class="contact" placeholder="Uw naam" type="text" name="contact_name" required><br>
                    Onderwerp: <br><input  class="contact" placeholder="Onderwerp" type="text" name="contact_subject" required><br>
                    E-mail: <br><input class="contact contact_minWidth" placeholder="Op welke email kunnen we u contacteren?" type="email" name="contact_email" required><br>
                    Website:<br><input class="contact contact_minWidth" placeholder="Optionele website" type="text" name="contact_website"><br>
                    Reactie: <br><textarea class="contact contact_content" placeholder="Vul hier uw aanvraag in" name="contact_content" required></textarea><br>
                    <input type="submit" ID="btn1" name="submit" value="Aanvraag indienen" /> 
                </form>
            </section>
                    </section>
        </section>
        <?php
        include '../Php/footer.php';
        ?>
    </body>
</html>