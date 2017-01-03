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
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
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
            </section>        <section id="mid">
                <section id="rightmenu">
                    <?php
                    include '../Php/rightmenu.php';
                    ?>
                </section>
                <section id="maincontent">
                    <h1>Contactformulier</h1>
                    <div class="WidthFix">                    
                    <br>
                    <div id="divlogo"> <img id="logo" src="../Images/SiteImages/image001.png"></div>
                    <form action="contactSend.php" method="post">
                        Naam: <br>      <input required class="contact" placeholder="Uw naam" type="text" name="contact_name" ><br>
                        Onderwerp: <br> <input required class="contact" placeholder="Onderwerp" type="text" name="contact_subject" ><br>
                        E-mail: <br>    <input required class="contact contact_minWidth" placeholder="Op welke email kunnen we u contacteren?" type="email" name="contact_email" ><br>
                        Website:<br>    <input class="contact contact_minWidth" placeholder="Optionele website" type="text" name="contact_website"><br>
                        Reactie: <br>   <textarea required class="contact contact_content" placeholder="Vul hier uw aanvraag in" name="contact_content" ></textarea><br>
                        <br> 

                        <br>
                        <img id='captcha' src="../Php/captha.php" />

                        <input name="captcha" required id='captchatekst' placeholder="Voer de 4 getallen in" type="text">
                        <br><br>
                        <input type="submit" I name="submit" style="border-radius:8px;margin-bottom:5px;" class="button-green" value="Aanvraag indienen" /> 

                    </form>
                    </div>
                </section>
            </section>
        </section>
        <?php
        include '../Php/footer.php';
        ?>
    </body>
</html>



