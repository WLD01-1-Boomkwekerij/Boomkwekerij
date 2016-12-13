<html>
    <head>
        <title>Redirecting...</title>
        <meta http-equiv="refresh" content="0; url=../Pages/logged_in.php">
    </head>
    <body>
        <?php
//        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in']) {
//            exit();
//        }
        ?>
        You are being automatically redirected to a new location.<br />
        If your browser does not redirect you in few seconds, or you do
        not wish to wait, <a href="../Pages/logged_in.php">click here</a>.<br>
        <?php
        $submit = $_POST['submit'];
        $rol = $_POST['rol'];
        $gebruiker = $_POST['gebruiker'];
        $gebr_naam = $_POST['gebr_naam'];
        $gebr_mail = $_POST['gebr_mail'];
        $krijgt_mail = $_POST['krijgt_mail'];
        include '../Php/Database.php';
        $array = getSQLArray('SELECT Wachtwoord FROM boomkwekerij.gebruiker WHERE GebruikerID =' . $gebruiker);
        while ($pass = $array->fetch()) {
            if ($submit == 'Bewerken') {

                if ($rol == 'beheerder') {
                    $rol = 1;
                } elseif ($rol == 'medewerker') {
                    $rol = 2;
                } elseif ($rol == 'vertaler') {
                    $rol = 3;
                }
                $query = ('UPDATE `boomkwekerij`.`gebruiker`'
                        . ' SET `Naam` ="' . $gebr_naam . '",'
                        . ' `Email` = "' . $gebr_mail . '",'
                        . ' `KrijgtEmail` = "' . $krijgt_mail . '",'
                        . ' `Rol` = "' . $rol . '"'
                        . ' WHERE `GebruikerID` =' . $gebruiker);
                doSQL($query);
                print($query);
            } elseif ($submit == 'Verwijderen') {

                if ($rol == 'beheerder') {
                    $rol = 1;
                } elseif ($rol == 'medewerker') {
                    $rol = 2;
                } elseif ($rol == 'vertaler') {
                    $rol = 3;
                }
                $query = ('DELETE FROM boomkwekerij.gebruiker WHERE GebruikerID =' . $gebruiker);
                doSQL($query);
            }
        }
        ?>
    </body>
</html>