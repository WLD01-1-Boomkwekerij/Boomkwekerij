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
        $data = unserialize($_POST['input_name']); //Het uitelkaar halen van gegevens
        $Wachtwoord = $data['Wachtwoord1'];
        $submit = $data['submit']; 
        $rol = $data['rol'];
        if ($submit == 'Bewerken') { // Kijken of het een bewerk verwijder is
            if ($rol == 'beheerder') { // rol variabele weer omzetten in getal
                $rol = 1;
            } elseif ($rol == 'medewerker') {
                $rol = 2;
            } elseif ($rol == 'vertaler') {
                $rol = 3;
            }
            if (isset($Wachtwoord1)) { // als er geen wachtwoord is veranderd wordt een SQL query gegenereerd zonder wachtwoord
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
            }
            doSQL($query);
            header('Refresh: 0; url=../Pages/logged_in.php'); //terug naar beheerderspagina
        } elseif ($submit == 'Verwijderen') { //verwijder SQL code genereren
            $query = ('DELETE FROM boomkwekerij.gebruiker WHERE GebruikerID =' . $data["gebruiker"]);
            doSQL($query);
            header('Refresh: 0; url=../Pages/logged_in.php'); // terug naar beheerderspagina
        }
        ?>
    </body>
</html>