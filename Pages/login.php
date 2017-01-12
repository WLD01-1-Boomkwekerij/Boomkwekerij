<?php session_start() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Boomkwekerij - Catalogus</title>
        <?php
            include '../Html/includeHead.html';
        ?>
        <link href="../Css/Logged_inStyle.css" rel="stylesheet" type="text/css">
    </head>
    <body>    
        <section id="wrapper">
            <section id='titlediv' class="notranslate"><p id="imgtitle">FA.P.BOER BOOMKWEKERIJ</p></section>
            <section id="top">
                <section id="header"></section>
                <?php
                include '../Php/menu.php';
                ?>
            </section>
            <section id="mid">
                <section id="maincontent">
                    <div id="loginkader">
                        <h1 id="logintitel">Inloggen</h1>
                        <?php
                        include_once '../Php/Database.php';
                        date_default_timezone_set('Europe/Amsterdam');
                        // Controleren of er ingelogd is met IP adres

                        $query = 'SELECT `Attempts` FROM `loginattempts` WHERE IP = ?';
                        $variable = array($_SERVER['REMOTE_ADDR']);
                        $pogingen = ProtectedGetSQL($query, 'Attempts', $variable);

                        $query = 'SELECT `LastLogin` FROM `loginattempts` WHERE ip = ?';
                        $timestamp = ProtectedGetSQL($query, 'LastLogin', $variable);

                        $tijd = time();
                        $tijdverschil = $tijd - $timestamp;
                        
                        // als er een tijdelijke blokkade is wordt er weergegeven hoeveel seconden er gewacht moet worden tot er weer ingelogd kan worden

                        if ($tijdverschil >= 2 && isset($timestamp) && $pogingen >= 7) {
                            $wachttijd = 300 - $tijdverschil;
                            print('U kunt over ' . $wachttijd . ' seconden inloggen');
                        }
                        ?>
                        <form id="loginform" method="post" action="../Php/verify.php">
                            <table align="center">
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
                            <input class="btn btn-success" type="submit" id="btn2" name="btn2" value="Inloggen">
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