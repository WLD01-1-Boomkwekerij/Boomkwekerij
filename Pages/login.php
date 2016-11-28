<?php session_start() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Boomkwekerij - Catalogus</title>
            <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
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
                        <h3>Catalogus</h3>
                        <ul id="catalogus">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </section>
                    <section id="maincontent">
                        <center> <form method="post" action="../Php/verify.php">
                                <table border="1">
                                    <td>Gebruikersnaam:</td>
                                    <td><input type="text" id="user" name="user"</td>
                                    <tr>
                                        <td>Wachtwoord:</td>
                                        <td><input type="password" id="pass" name="pass"</td>
                                </table><br>
                                <input type="submit" id="btn2" name="btn2" value="Inloggen">

                            </form>
                        </center>
                    </section>
                </section>
            </section>
            <section id="footer">
                <li><a href="../pages/login.php">Inloggen</a></li>
            </section>
        </body>
    </html>