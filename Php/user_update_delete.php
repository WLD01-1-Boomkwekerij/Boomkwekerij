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
        if ($submit == 'Opslaan') { // Checks if it is a Deletion or Update of a user
            if ($rol == 'beheerder') { // Change Rol variable to a number
                $rol = 1;
            } elseif ($rol == 'medewerker') {
                $rol = 2;
            } elseif ($rol == 'vertaler') {
                $rol = 3;
            }
            if (isset($Wachtwoord)) { // If the password is changed a SQL query starts whitout a password
                $query = ('UPDATE `boomkwekerij`.`gebruiker`'
                        . ' SET `Naam` =?,'
                        . ' `Email` = ?,'
                        . ' `KrijgtEmail` = ?,'
                        . ' `Wachtwoord` =?,'
                        . ' `Rol` = ?'
                        . ' WHERE `GebruikerID` =?');
                    ProtectedDoSQL($query, array($data["gebr_naam"],$data["gebr_mail"],$data["krijgt_mail"],$Wachtwoord,$rol,$data["gebruiker"]));
            } else {
                $query = ('UPDATE `boomkwekerij`.`gebruiker`'
                        . ' SET `Naam` =?,'
                        . ' `Email` = ?,'
                        . ' `KrijgtEmail` = ?,'
                        . ' `Rol` = ?'
                        . ' WHERE `GebruikerID` =?');
                
                    ProtectedDoSQL($query, array($data["gebr_naam"],$data["gebr_mail"],$data["krijgt_mail"],$rol,$data["gebruiker"]));
            }
            header('Refresh: 0; url=../Pages/logged_in.php'); //Back to the "beheerderspagina"
        } elseif ($submit == 'Verwijderen') { //Generate Delete SQL query
            $query = ('DELETE FROM boomkwekerij.gebruiker WHERE GebruikerID =?');
            ProtectedDoSQL($query,array($data["gebruiker"]));
            header('Refresh: 0; url=../Pages/logged_in.php'); // Back to the "beheerderspagina"
        }
        ?>
    </body>
</html>