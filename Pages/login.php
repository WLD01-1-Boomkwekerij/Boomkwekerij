<?php session_start() ?>
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
                <?php
                include '../Php/menu.php';
                ?>
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
                    <center> <div id="loginkader">
                            <div id="logintitel">
                                <p>Inloggen</p>
                            </div>
                            <form id="loggiforum" method="post" action="../Php/verify.php">
                                <table border="1">
                                    <tr>
                                        <td>Gebruikersnaam:</td>
                                        <td><input type="text" id="user" name="user"></td>
                                    </tr>
                                    <tr>
                                        <td>Wachtwoord:</td>
                                        <td><input type="password" id="pass" name="pass"></td>
                                    </tr>
                                </table>
                                <br>
                                <input type="submit" id="btn2" name="btn2" value="Inloggen">

                            </form>

                        </div></center>
                </section>
            </section>
        </section>
        <?php
        include '../Php/footer.php';
        ?>
    </body>
</html>