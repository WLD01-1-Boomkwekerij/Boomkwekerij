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
        include_once '../Php/Database.php';
        $data = unserialize($_POST['input_name']);
        if ($data['rol'] == 'Beheerder') {
            $data['rol'] = 1;
        } elseif ($data['rol'] == 'Medewerker') {
            $data['rol'] = 2;
        } elseif ($data['rol'] == 'Vertaler') {
            $data['rol'] = 3;
        }
        $query = ('INSERT INTO boomkwekerij.gebruiker (Naam, Email, KrijgtEmail, Rol, Wachtwoord) '
                . 'VALUES ("' . $data['gebr_naam'] . '","' . $data['gebr_mail'] . '","' . $data['krijgt_mail'] . '","' . $data['rol'] . '","' . $data['Wachtwoord1'] . '")');
        echo $query;
        doSQL($query);
        ?>
    </body>
</html>