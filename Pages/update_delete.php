<html>
    <head>
        <title>Redirecting...</title>
        <meta http-equiv="refresh" content="0; url=logged_in.php">
    </head>
    <body>
        You are being automatically redirected to a new location.<br />
        If your browser does not redirect you in few seconds, or you do
        not wish to wait, <a href="../Pages/logged_in.php">click here</a>.
        <?php
        include '../Php/Database.php';
        $array = getSQLArray('SELECT Wachtwoord FROM boomkwekerij.gebruiker WHERE GebruikerID =' . $_POST["gebruiker"]);
        while ($pass = $array->fetch()) {
            if ($_POST['submit'] == 'Bewerken') {

                if ($_POST['rol'] == 'beheerder') {
                    $_POST['rol'] = 1;
                } elseif ($_POST['rol'] == 'medewerker') {
                    $_POST['rol'] = 2;
                } elseif ($_POST['rol'] == 'vertaler') {
                    $_POST['rol'] = 3;
                }
                $query = ('UPDATE boomkwekerij.gebruiker  SET Naam ="' . $_POST['gebr_naam'] . '",'
                        . 'Email = "' . $_POST['gebr_mail'] . '",'
                        . 'KrijgtEmail= "' . $_POST['krijgt_mail'] . '",'
                        . 'Rol= "' . $_POST['rol'] . '"'
                        . 'WHERE GebruikerID =' . $_POST['gebruiker']);
                doSQL($query);
            } elseif ($_POST['submit'] == 'Verwijderen') {

                if ($_POST['rol'] == 'beheerder') {
                    $_POST['rol'] = 1;
                } elseif ($_POST['rol'] == 'medewerker') {
                    $_POST['rol'] = 2;
                } elseif ($_POST['rol'] == 'vertaler') {
                    $_POST['rol'] = 3;
                }
                $query = ('DELETE FROM boomkwekerij.gebruiker WHERE GebruikerID =' . $_POST['gebruiker']);
                doSQL($query);
            }
        }
        ?>
    </body>
</html>