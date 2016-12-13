<?php
// We werken ook hier met sessies 
session_start();

// Controleren of de bezoeker ingelogd is 
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
    header('Location:login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Boomkwekerij - Beheerderspagina</title>
        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link href="../Css/Logged_inStyle.css" rel="stylesheet" type="text/css">
        <?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {

            include '../Php/loggedInEditor.php';
        }
        ?>
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
                <section id="maincontent">
                    <h1>Beheerderspagina</h1>
                    <h4>Gebruikers beheren</h4> 
                    <h5>Nieuw gebruiker toevoegen</h5>
                    <?php
                    include '../Php/POST.php';
                    if (isset($submit)) {
                        if ($Wachtwoord1 != $Wachtwoord2) {
                            print ('Wachtwoorden zijn niet hetzelfde, probeer het opnieuw.<br>');
                        } else {
                            if (count($errors) > 0) { //laat foutmeldingen zien
                                print_r (implode($errors, '<br>'));
                            } else {
                                print('Wilt u de volgende gebruiker toevoegen?<br>'
                                        . 'Naam: ' . $gebr_naam . '<br>'
                                        . 'Email: ' . $gebr_mail . '<br>'
                                        . 'Krijgt mail: ');
                                if ($krijgt_mail == 0) {
                                    print('nee <br>');
                                } else {
                                    print('ja <br>');
                                }
                                print('Type gebruiker: ' . $rol . '<br>');
                                ?>
                                <form action="../Php/user_add.php" method="post">
                                    <input type='hidden' name='input_name' value="<?php echo htmlentities(serialize($_POST)); ?>" />
                                    <input type="submit" name="submit" value="Toevoegen"/>
                                </form>
                                <form action="../Pages/logged_in.php" method="post">
                                    <input type="submit" name="cancel" value="Annuleren"/>
                                </form> 
                                <?php
                            }
                        }
                        ?>
                        <form  action="../Pages/logged_in.php" method="post">
                            <table>
                                <tr>
                                    <th>Naam</th>
                                    <th>Email</th>
                                    <th>Krijgt notifactie</th>
                                    <th>Wachtwoord</th>
                                    <th>Wachtwoord opnieuw</th>
                                    <th>Rechten</th>
                                    <th>Toevoegen</th>
                                </tr>
                                <tr>
                                    <td><input name="gebr_naam" id="gebr_naam" type="text" tabindex="1" required value="<?php print($gebr_naam); ?>"></td>
                                    <td><input name="gebr_mail" id="gebr_mail" type="email" tabindex="2" required value="<?php print($gebr_mail); ?>"></td>
                                    <td>
                                        <select name="krijgt_mail" tabindex="3">
                                            <?php if ($krijgt_mail == 1) { ?>
                                                <option value="0">Nee</option>
                                                <option value="1" selected="selected">Ja</option>
                                            <?php } else { ?>
                                                <option value="0" selected="selected">Nee</option>
                                                <option value="1">Ja</option>
                                            <?php } ?>
                                        </select> 
                                    </td>
                                    <td><input name="Wachtwoord1" id="Wachtwoord1" type="password" tabindex="4" required></td>
                                    <td><input name="Wachtwoord2" id="Wachtwoord2" type="password" tabindex="5" required></td>
                                    <td> 
                                        <?php
                                        if ($rol == 'beheerder') {
                                            ?>          
                                            <select name="rol" tabindex="6">
                                                <option value="beheerder" selected="selected">Beheerder</option>
                                                <option value="medewerker">Medewerker</option>
                                                <option value="vertaler">Vertaler</option>
                                            </select> 
                                            <?php
                                        } elseif ($rol == 'medewerker') {
                                            ?>          
                                            <select name="rol" tabindex="6">
                                                <option value="beheerder" >Beheerder</option>
                                                <option value="medewerker" selected="selected">Medewerker</option>
                                                <option value="vertaler">Vertaler</option>
                                            </select> 
                                            <?php
                                        } elseif ($rol == 'vertaler') {
                                            ?>             
                                            <select name="rol" tabindex="6">
                                                <option value="beheerder" >Beheerder</option>
                                                <option value="medewerker">Medewerker</option>
                                                <option value="vertaler" selected="selected">Vertaler</option>
                                            </select> 
                                            <?php
                                        }
                                        ?>                                        
                                    </td>
                                    <td><input type="submit" name="submit" value="Toevoegen" tabindex="7"/></td>
                                </tr>
                            </table>
                        </form>
                        <?php
                    } else {
                        ?>
                        <form  action="../Pages/logged_in.php" method="post">
                            <table>
                                <tr>
                                    <th>Naam</th>
                                    <th>Email</th>
                                    <th>Krijgt notifactie</th>
                                    <th>Wachtwoord</th>
                                    <th>Wachtwoord opnieuw</th>
                                    <th>Rechten</th>
                                    <th>Toevoegen</th>
                                </tr>
                                <tr>
                                    <td><input name="gebr_naam" id="gebr_naam" type="text" tabindex="1" required></td>
                                    <td><input name="gebr_mail" id="gebr_mail" type="email" tabindex="2" required></td>
                                    <td>
                                        <select name="krijgt_mail" tabindex="3">
                                            <option value="0">Nee</option>
                                            <option value="1">Ja</option>
                                        </select> 
                                    </td>
                                    <td><input name="Wachtwoord1" id="Wachtwoord1" type="password" tabindex="4" required></td>
                                    <td><input name="Wachtwoord2" id="Wachtwoord2" type="password" tabindex="5" required></td>
                                    <td> 
                                        <select name="rol" tabindex="6">
                                            <option value="beheerder">Beheerder</option>
                                            <option value="medewerker">Medewerker</option>
                                            <option value="vertaler">Vertaler</option>
                                        </select> 
                                    </td>
                                    <td><input type="submit" name="submit" value="Toevoegen" tabindex="7"/></td>
                                </tr>
                            </table>
                        </form>
                        <?php
                    }
                    include_once '../Php/Database.php';
                    $gebruikers = getSQLArray('SELECT GebruikerID, Naam, Rol, Email FROM boomkwekerij.gebruiker');
                    ?>
                    <h5>Gebruikers wijzigen</h5>
                    <?php ?>
                    <table>
                        <tr>
                            <th>Naam</th>
                            <th>Email</th>
                            <th>Rechten</th>
                            <th>Bewerken</th>
                        </tr>
                        <?php
                        while ($rij = $gebruikers->fetch()) {
                            ?>
                            <tr>
                                <td> <?php print($rij['Naam']); ?> </td>
                                <td> <?php print($rij['Email']); ?> </td>
                                <td> <?php
                                    if ($rij['Rol'] == '1') {
                                        $rij['Rol'] = 'Beheerder';
                                    } elseif ($rij['Rol'] == '2') {
                                        $rij['Rol'] = 'Medewerker';
                                    } elseif ($rij['Rol'] == '3') {
                                        $rij['Rol'] = 'Vertaler';
                                    }
                                    print($rij['Rol']);
                                    ?></td>
                                <td><form action="../Pages/user_edit.php" method="POST">
                                        <input type='hidden' name='gebruiker' value="<?php print($rij['GebruikerID']) ?>" />
                                        <input type="submit" name="submit" value="Bewerken"/>
                                    </form></td>
                            <?php } ?>
                        </tr>
                    </table>
                </section>
            </section>
        </section>
        <?php
        include '../Php/footer.php';
        ?>
    </body>
</html>