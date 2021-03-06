<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="notranslate">Boomkwekerij - Beheerderspagina</title>
        <link href="../Css/Logged_inStyle.css" rel="stylesheet" type="text/css">

        <?php
        session_start();
        include '../Html/includeHead.html';
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false || $_SESSION['toegang'] != 1) {
            header('Location:login.php');
            exit();
        }
        ?>
    </head>
    <body>
        <section id="wrapper">
            <section id='titlediv' class="notranslate"><p id="imgtitle">FA.P.BOER BOOMKWEKERIJ</p></section>
            <section id="top">
                <section id="header"></section>
                <?php
                include '../Php/menu.php';
                ?>
            </section>
            <section id="mid">
                <section id="maincontent">
                    <h4>Bewerken</h4>
                    <?php
                    if (isset($_POST["submit"])) {
                        include '../Php/POST.php';
                        // Wordt gekeken of er al een poging is gedaan om een account te bewerken, als dat zo is worden deze ook weergegeven
                        if (($submit == 'Opslaan' && count($errors) > 0 ) || $submit == 'Bewerk') {
                            print_r(implode($errors, '<br>'));
                            ?>
                            <form method="post" action="../pages/user_edit.php">
                                <?php
                                include_once '../Php/Database.php';
                                $array = ProtectedGetSQLArray('SELECT * FROM gebruiker WHERE GebruikerID =?', array($gebruiker));
                                while ($data = $array->fetch()) {
                                    print('<h5>' . $data['Naam'] . '</h5>');
                                    ?>
                                    <br>Een wachtwoord moet uit minstens 8 tekens bestaan. Bevat minimaal 1 getal, 1 hoofdletter, 1 kleine letter en 1 van de volgende tekens: <i># @ % & - _ ! ?</i><br>
                                    <table id="gebruikertoevoegen" align="center">
                                        <tr>
                                            <td>Naam</td>
                                            <td><input name="gebr_naam" id="gebr_naam" type="text" tabindex="1" required value="<?php print($data['Naam']); ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td><input name="gebr_mail" id="gebr_mail" type="email" tabindex="2" required value="<?php print($data['Email']); ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Krijgt notifactie</td>
                                            <td>
                                                <?php
                                                if ($data['KrijgtEmail'] == 0) {
                                                    ?>
                                                    <select name="krijgt_mail" tabindex="3">
                                                        <option value="0" selected="selected">Nee</option>
                                                        <option value="1">Ja</option>
                                                    </select> 
                                                    <?php
                                                } else {
                                                    ?>
                                                    <select name="krijgt_mail" tabindex="3">
                                                        <option value="0">Nee</option>
                                                        <option value="1" selected="selected">Ja</option>
                                                    </select> 
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Wachtwoord</td>
                                            <td><input name="Wachtwoord1" id="Wachtwoord1" required type="password" tabindex="4" ></td>
                                        </tr>
                                        <tr>
                                            <td>Wachtwoord opnieuw</td>
                                            <td><input name="Wachtwoord2" id="Wachtwoord2" required type="password" tabindex="5" ></td>
                                        </tr>
                                        <tr>
                                            <td>Rechten</td>
                                            <td> 
                                                <?php
                                                // De onderstaande code zorgt ervoor dat de rol van de gebruiker gewijzigd kan worden
                                                if ($data['Rol'] == '1') {
                                                    ?>          
                                                    <select name="rol" tabindex="6">
                                                        <option value="beheerder" selected="selected">Beheerder</option>
                                                        <option value="medewerker">Medewerker</option>
                                                        <option value="vertaler">Vertaler</option>
                                                    </select> 
                                                    <?php
                                                } elseif ($data['Rol'] == '2') {
                                                    ?>          
                                                    <select name="rol" tabindex="6">
                                                        <option value="beheerder" >Beheerder</option>
                                                        <option value="medewerker" selected="selected">Medewerker</option>
                                                        <option value="vertaler">Vertaler</option>
                                                    </select> 
                                                    <?php
                                                } elseif ($data['Rol'] == '3') {
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
                                        </tr>
                                    </table>
                                    <input type='hidden' name='gebruiker' value="<?php print($gebruiker); ?>" />
                                    <input type="submit" class="button-red" name="submit" value="Verwijderen"/>

                                    <input type='hidden' name='gebruiker' value="<?php print($gebruiker); ?>" />
                                    <input type="submit" class="button-green" name="submit" value="Opslaan"/>

                                </form>
                                <?php
                            }
                            // Print een bevestiging voor de opgedane wijzigingen
                        } elseif ($submit == 'Opslaan' && count($errors) == 0) {
                            print('Wilt u de volgende gebruiker bewerken?<br>'
                                    . 'Naam: ' . $gebr_naam . '<br>'
                                    . 'Email: ' . $gebr_mail . '<br>'
                                    . 'Krijgt mail: ');
                            // De onderstaande code zorgt ervoor dat de optie voor email gewijzigd kan worden
                            if ($krijgt_mail == 0) {
                                print('nee <br>');
                            } else {
                                print('ja <br>');
                            }
                            print('Type gebruiker: ' . $rol . '<br>');
                            ?>
                            <!-- Genereert een formulier voor het bewerken van de gebruiker -->
                            <form action="../Php/user_update_delete.php" method="post">
                                <input type='hidden' name='input_name' value="<?php echo htmlentities(serialize($_POST)); ?>" />
                                <input type="submit" name="submit" value="Bewerken"/>
                            </form>
                            <form action="../pages/logged_in.php" method="post">
                                <input type="submit" name="cancel" value="Annuleren"/>
                            </form>
                            <?php
                            // Bevestigen voor het verwijderen van een gebruiker
                        } elseif ($submit == 'Verwijderen') {
                            print('Weet u zeker dat u ' . $gebr_naam . ' wilt verwijderen? <br>');
                            ?>
                            <form action="../Php/user_update_delete.php" method="post">
                                <input type='hidden' name='input_name' value="<?php echo htmlentities(serialize($_POST)); ?>" />
                                <input type="submit" name="submit" value="Opslaan"/>
                            </form>
                            <form action="../pages/logged_in.php" method="post">
                                <input type="submit" name="cancel" value="Annuleren"/>
                            </form>
                            <?php
                        }
                    }
                    ?>
                </section>
            </section>
        </section>
        <?php
        include '../Php/footer.php';
        ?>
    </body>
</html>