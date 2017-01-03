<html>
    <head>
        <title>Redirecting...</title>
        <meta http-equiv="refresh" content="0; url=../Pages/logged_in.php">
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
        include_once '../Php/Database.php';
        $data = unserialize($_POST['input_name']);
        $Wachtwoord = hash('sha256', $data['Wachtwoord1']);
        if ($data['rol'] == 'beheerder') {
            $data['rol'] = 1;
        } elseif ($data['rol'] == 'medewerker') {
            $data['rol'] = 2;
        } elseif ($data['rol'] == 'vertaler') {
            $data['rol'] = 3;
        }
        $query = ('INSERT INTO boomkwekerij.gebruiker (Naam, Email, KrijgtEmail, Rol, Wachtwoord) VALUES (?,?,?,?,?)');
        ProtectedDoSQL($query, array($data['gebr_naam'],$data['gebr_mail'],$data['krijgt_mail'],$data['rol'],$Wachtwoord ))
        ?>
    </body>
</html>