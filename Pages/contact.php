<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="notranslate">Boomkwekerij - Contact</title>
        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link href="../Css/ContactStyle.css" rel="stylesheet" type="text/css">
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
                    <div id="google_translate_element"></div><script type="text/javascript">
                        function googleTranslateElementInit() {
                            new google.translate.TranslateElement({pageLanguage: 'nl', includedLanguages: 'en,it,nl,sv', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
                        }
                    </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                    <h3>Contact informatie</h3>
                    <ul class="notranslate" id="contact_information">
                        <li>Fa. P. Boer</li>
                        <li>Rijneveld 125<br>2771 XV Boskoop</li>
                        <li>B.G.G:<br>0031 (0)172217308</li>
                        <li>Peter Boer:<br>0031 (0)657915055</li>
                        <li>Robert Boer:<br>0031(0)622442190</li>
                        <li>fax:<br>0031 (0)172216827</li>
                        <li>E-mail:<br>info@boomkwekerijpboer.nl</li>
                    </ul>
                    <h3>Groen-Direkt Boskoop</h3>
                    Geen opkomende evenementen<br>
                    <a href="http://www.groen-direkt.nl/home-nl" TARGET="_blank">link</a>
                </section>
                <section id="maincontent">
                    <h1>Aanvraag</h1>
                    <form action="contactSend.php" method="post">
                        Naam: <br><input class="contact" placeholder="Uw naam" type="text" name="contact_name" required><br>
                        Onderwerp: <br><input  class="contact" placeholder="Onderwerp" type="text" name="contact_subject" required><br>
                        E-mail: <br><input class="contact contact_minWidth" placeholder="Op welke email kunnen we u contacteren?" type="tekst" name="contact_email" required><br>
                        Website:<br><input class="contact contact_minWidth" placeholder="Optionele website" type="text" name="contact_website"><br>
                        Reactie: <br><textarea class="contact contact_content" placeholder="Vul hier uw aanvraag in" name="contact_content" required></textarea><br>
                        <input type="submit" ID="btn1" name="submit" value="Aanvraag indienen" /> 
                    </form>
                </section>
            </section>
        </section>
        <section  class="notranslate" id="footer">
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