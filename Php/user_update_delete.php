<html>
    <head>
        <title>Redirecting...</title>
    </head>
    <body>
        <?php
        session_start();
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false || $_SESSION['toegang'] != 1) {
            exit();
        }
        ?>
        U wordt automatisch omgeleid, als u niet wilt wachten, <a href="../Pages/logged_in.php">klik dan hier</a>.<br>
        <?php
        include '../Php/Database.php';
        if (isset($_POST['submit'])) {
            $submit = $_POST['submit'];
            $rol= $_POST['Rol'];
        }
        $data = unserialize($_POST['input_name']);
        $Wachtwoord = $data['Wachtwoord1'];
        if ($submit == 'Bewerken') {
            if ($rol == 'beheerder') {
                $rol = 1;
            } elseif ($rol == 'medewerker') {
                $rol = 2;
            } elseif ($rol == 'vertaler') {
                $rol = 3;
            }
            if (isset($Wachtwoord1)) {
                $query = ('UPDATE `boomkwekerij`.`gebruiker`'
                        . ' SET `Naam` ="' . $data["gebr_naam"] . '",'
                        . ' `Email` = "' . $data["gebr_mail"] . '",'
                        . ' `KrijgtEmail` = "' . $data["krijgt_mail"] . '",'
                        . ' `Wachtwoord` ="' . $data["Wachtwoord1"] . '"'
                        . ' `Rol` = ' . $rol . ''
                        . ' WHERE `GebruikerID` =' . $data["gebruiker"]);
            } else {
                $query = ('UPDATE `boomkwekerij`.`gebruiker`'
                        . ' SET `Naam` ="' . $data["gebr_naam"] . '",'
                        . ' `Email` = "' . $data["gebr_mail"] . '",'
                        . ' `KrijgtEmail` = "' . $data["krijgt_mail"] . '",'
                        . ' `Rol` = ' . $rol . ''
                        . ' WHERE `GebruikerID` =' . $data["gebruiker"]);
                            print($query);

            }
            doSQL($query);
            header('Refresh: 0; url=../Pages/logged_in.php');
        } elseif ($submit == 'Verwijderen') {
            $query = ('DELETE FROM boomkwekerij.gebruiker WHERE GebruikerID =' . $gebruiker);
            doSQL($query);
            header('Refresh: 0; url=../Pages/logged_in.php');
        }
        ?>
    </body>
</html>