<?php session_start() ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Boomkwekerij - Catalogus</title>
        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link href="../Css/Logged_inStyle.css" rel="stylesheet" type="text/css">

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
                <section id="maincontent">
                    <div id="loginkader">
                        <h1 id="logintitel">Inloggen</h1>
                        <?php
                        include_once '../Php/Database.php';
                        date_default_timezone_set('Europe/Amsterdam');

                        $query = 'SELECT `Attempts` FROM `LoginAttempts` WHERE IP = ?';
                        $variable = array($_SERVER['REMOTE_ADDR']);
                        $pogingen = BeveiligdGetSQL($query, 'Attempts', $variable);

                        $query = 'SELECT `LastLogin` FROM `LoginAttempts` WHERE ip = ?';
                        $timestamp = BeveiligdGetSQL($query, 'LastLogin', $variable);

                        $tijd = time();
                        $tijdverschil = $tijd - $timestamp;

                        if ($tijdverschil >= 2 && isset($timestamp) && $pogingen >= 7) {
                            $wachttijd = 300 - $tijdverschil;
                            print('U kunt over ' . $wachttijd . ' seconden inloggen');
                        }
                        ?>
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