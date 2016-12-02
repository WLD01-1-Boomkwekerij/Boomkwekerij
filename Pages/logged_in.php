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
            print("<link href='../Css/EditableStyle.css' rel='stylesheet' type='text/css'>");
            print("<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>");
            print("<script src='../Javascript/InformationEditing.js'></script>");
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
                    <?php
                    if (isset($_POST['submit'])) {
                        if ($_POST['Wachtwoord1'] != $_POST['Wachtwoord2']) {
                            print ('Wachtwoorden zijn niet hetzelfde, probeer het opnieuw.');
                        } else {
                            print('Wilt u de volgende gebruiker toevoegen?<br>'
                                    . 'Naam: ' . $_POST['gebr_naam'] . '<br>'
                                    . 'Email: ' . $_POST['gebr_mail'] . '<br>'
                                    . 'Krijgt mail: ');
                            if ($_POST['krijgt_mail'] == 0) {
                                print('nee <br>');
                            } else {
                                print('ja <br>');
                            }
                            print('Type gebruiker: ' . $_POST['rol'] . '<br>');
                        }
                        ?>
                        <form action="add.php" method="post">
                            <input type='hidden' name='input_name' value="<?php echo htmlentities(serialize($_POST)); ?>" />
                            <input type="submit" name="submit" value="Toevoegen"/>
                        </form>
                        <form action="logged_in.php" method="post">
                            <input type="submit" name="cancel" value="Annuleren"/>
                        </form>  
                        <?php
                    }
                    ?>

                    <h4>Gebruikers beheren</h4> 
                    <h5>Nieuw gebruiker toevoegen</h5>
                    <form  action="logged_in.php" method="post">
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
                                        <option value="mederwerker">Medewerker</option>
                                        <option value="vertaler">Vertaler</option>
                                    </select> 
                                </td>
                                <td><input type="submit" name="submit" value="Toevoegen" tabindex="7"/></td>
                            </tr>
                        </table>
                    </form>
                    <?php
                    include_once '../Php/Database.php';
                    $gebruikers = getSQLArray('SELECT GebruikerID, Naam, Rol, Email FROM boomkwekerij.gebruiker');
                    ?>
                    <h5>Gebruikers wijzigen</h5>
                    <?php
                    ?>
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
                                <td><form action="edit.php" method="POST">
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