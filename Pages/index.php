<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
<<<<<<< HEAD
        <title class="notranslate">Boomkwekerij - Home</title>
=======
        <meta name="google" value="notranslate">
        <title>Boomkwekerij - Home</title>
>>>>>>> 00815263ec37b80e4cafe8c37885018551b92a68
        <!-- Icon Pack -->
        <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">

        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link href="../Css/HomeStyle.css" rel="stylesheet" type="text/css"> 
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        <?php
        session_start();

        include '../Php/DatabaseInformation.php';

        //if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
        print("<link href='../Css/EditableCss.css' rel='stylesheet' type='text/css'>");
        print("<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>");
        print("<script src='../Javascript/InformationEditing.js'></script>");
        // }
        ?>
        <link href="../Css/HomeStyle.css" rel="stylesheet" type="text/css">

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
               
                    <div id="google_translate_element"></div>
                    <script type="text/javascript">
                        function googleTranslateElementInit() {
                            new google.translate.TranslateElement({pageLanguage: 'nl', includedLanguages: 'en,it,nl,sv', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
                        }
                    </script>
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

                    <!-- Hierin moet de tekst van de site, het id moet het TextID bevatten om text op te slaan -->

<<<<<<< HEAD
                    <div>
                        <button class="fa fa-bold" onclick="markupText('bold')"></button>
                        <button class="fa fa-italic" onclick="markupText('italic')"></button>
                        <button class="fa fa-underline" onclick="markupText('underline')"></button>
                        <button class="fa fa-align-left" onclick="markupText('justifyLeft')"></button>
                        <button class="fa fa-align-justify" onclick="markupText('justifyCenter')"></button>
                        <button class="fa fa-align-right" onclick="markupText('justifyRight')"></button>
                        <button class="fa fa-list-ol" onclick="markupText('insertOrderedList')"></button>
                        <button class="fa fa-list-ul" onclick="markupText('insertUnorderedList')"></button>
                        <!--<select class="numberPicker" onchange="setFontSize('textID1', 5)"></select>-->
                        <!--<button class="fa fa-link" onclick="createLink(this)"></button>-->
                    </div>

                    <div class="ContentEditable" id="textID1">
=======
                    <div id="Editor">
                        <div class="fa fa-bold" onclick="markupText('bold')"></div>
                        <div class="fa fa-italic" onclick="markupText('italic')"></div>
                        <div class="fa fa-underline" onclick="markupText('underline')"></div>
                        <div class="fa fa-align-left" onclick="markupText('justifyLeft')"></div>
                        <div class="fa fa-align-justify" onclick="markupText('justifyCenter')"></div>
                        <div class="fa fa-align-right" onclick="markupText('justifyRight')"></div>
                        <div class="fa fa-list-ol" onclick="markupText('insertOrderedList')"></div>
                        <div class="fa fa-list-ul" onclick="markupText('insertUnorderedList')"></div>
                        <!--<button class="fa fa-link" onclick="createLink(this)"></button>-->
                    </div>

                    <div class="ContentEditable" id="textID1" onfocusout="saveSelectorPoint()">
>>>>>>> 00815263ec37b80e4cafe8c37885018551b92a68
                        <?php
                        //Gebruik dit commando met de TextID van de tekst om hem altijd te laten werken
                        print(loadTextFromDB(1));
                        ?>
                    </div>
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
