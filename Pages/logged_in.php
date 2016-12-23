<?php
session_start();

// Controleren of de bezoeker ingelogd is 
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false || $_SESSION['toegang'] != 1) {
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
        
    
    </head>
    <body>
        <section id="wrapper">
            <section id='titlediv'><p id="imgtitle">FA.P.BOER BOOMKWEKERIJ</p></section>
            <section id="top">
                <section id="header"></section>
                <?php
                include '../Php/menu.php';
                ?>
            </section>
            <section id="mid">
                <section id="maincontent">
                    <center><h1>Beheerderspagina</h1></center>

                    <div class="WidthFix"> <br>                   
                        <center><h4>Gebruikers beheren</h4> </center><br>
                        <center><h5>Nieuw gebruiker toevoegen</h5></center>
                        <?php
                        include '../Php/POST.php';
                        // Eerst wordt er gekeken of er al een aanpassing geverivïeerd moet worden, als dat niet zo is zie de 'else'                        
                        if (isset($submit)) {
                            if (count($errors) > 0) {
                                //laat foutmeldingen zien
                                print_r(implode($errors, '<br>'));
                            } else {
                                // Als er geen fouten zijn moet de informatie getoond worden te bevesting van de gegevens.
                                print('<center>Wilt u de volgende gebruiker toevoegen?</center><br>'
                                        . '<table id=usertableconfirm border=1><td>Naam:</td><td><input disabled id=gebr_naam1 type=tekst value=' . $gebr_naam . ' </td><tr>'
                                        . '<td>Email:</td> <td><input disabled id=gebr_mail1 type=tekst value=' . $gebr_mail . ' </td><tr>'
                                        . '<td>Krijgt mail: </td><td>');
                                if ($krijgt_mail == 0) {
                                    print('<input disabled id=krijgt_mail1 type=testk value=nee> <tr>');
                                } else {
                                    print('<input disabled  id=krijgt_mail1 type=tekst value=ja </td><tr>');
                                }
                                print('<td>Type gebruiker: </td><td><input disabled id=rol1 type=tekst value=' . $rol . ' </td><tr></table> ');
                                ?>
                                <form action="../Php/user_add.php" method="post">
                                    <!--Toevoeg knop met informatie wordt geserialiseerd-->
                                    <input type='hidden' name='input_name' value="<?php echo htmlentities(serialize($_POST)); ?>" />
                                    <input type="submit" class ="button-green" id="userconfirm" name="submit" value="Bevestigen"/>
                                </form>
                                <form action="../Pages/logged_in.php" method="post">
                                    <!--Annuleer knop-->
                                    <input class="button-redr" id="usercancel" type="submit" name="cancel" value="Annuleren"/>
                                </form> <br><br><br>
                                <?php
                            }
                            ?>
                            <form  action="../Pages/logged_in.php" method="post">
                                <!--formulier voor het aanmaken van nieuwe gebruikers
                                Deze is al ingevuld mocht het wachtwoord niet aan de eisen voldoen of niet hezelfde is-->
                                <table border="1">

                                    <td>Naam</td>
                                    <td><input name="gebr_naam" id="gebr_naam" type="text" tabindex="1" required value="<?php print($gebr_naam); ?>"></td><!--Naam van de gebruiker-->
                                    <tr>
                                        <td>Email</td>
                                        <td><input name="gebr_mail" id="gebr_mail" type="email" tabindex="2" required value="<?php print($gebr_mail); ?>"></td><!--emailadres-->
                                    <tr>
                                        <td>Krijgt notifactie</td>
                                        <td> <!--uitrolmenu voor krijgt mail keuze-->
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
                                    <tr>
                                        <td>Wachtwoord</td>
                                        <td><input name="Wachtwoord1" id="Wachtwoord1" type="password" tabindex="4" required></td><!--Wachtwoord 1 en 2 moeten hetzelfde zijn-->
                                    <tr>
                                        <td>Wachtwoord opnieuw</td>
                                        <td><input name="Wachtwoord2" id="Wachtwoord2" type="password" tabindex="5" required></td>
                                    <tr>
                                        <td>Rechten</td>
                                        <td> <!--Rol van de gebruiker-->
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

                                </table>
                                <br>
                                   <input type="submit" name="submit" class="button-green" value="Toevoegen" tabindex="7"/> <!--toevoegknop--> 
                            </form>
                            <?php
                        } else {
                            ?>
                            <div id='voorwaarden'><i>Een wachtwoord moet uit minstens 8 tekens bestaan. Bevat minimaal 1 getal, 1 hoofdletter, 1 kleine letter en 1 van de volgende tekens:# @ % & - _ ! ?</i></div>
                            <!--Vereisten van het wachtwoord weergeven-->
                            <center><form  action="../Pages/logged_in.php" method="post">
                                    <table id="gebruikertoevoegen">

                                        <td><b>Naam</b></td>
                                        <td><input name="gebr_naam" id="gebr_naam" type="text" tabindex="1" required></td><!--gebruikersnaam-->
                                        <tr>
                                            <td><b>Email</b></td>
                                            <td><input name="gebr_mail" id="gebr_mail" type="email" tabindex="2" required></td><!--emailadres voor notificaties-->
                                        <tr>

                                            <td><b>Krijgt notifactie</b></td>
                                            <td>
                                                <select name="krijgt_mail" tabindex="3"><!--krijgt mail optie-->
                                                    <option value="0">Nee</option>
                                                    <option value="1">Ja</option>
                                                </select> 
                                            </td>
                                        <tr>
                                            <td><b>Wachtwoord</b></td>
                                            <td><input name="Wachtwoord1" id="Wachtwoord1" type="password" tabindex="4" required></td><!--beiden wachtwoorden moeten hetzelfde zijn om typo's te verkomen-->
                                        <tr>
                                            <td><b>Wachtwoord opnieuw</b></td>
                                            <td><input name="Wachtwoord2" id="Wachtwoord2" type="password" tabindex="5" required></td>
                                        <tr>
                                            <td><b>Rechten</b></td>
                                            <td> 
                                                <select name="rol" tabindex="6"> <!--de rechten van de nieuwe gebruiker-->
                                                    <option value="beheerder">Beheerder</option>
                                                    <option value="medewerker" selected="selected">Medewerker</option><!--medewerker is de standaard om te verkomen dat er per ongeluk een nieuwe beheerder aangemaakt wordt-->
                                                    <option value="vertaler">Vertaler</option>
                                                </select> 
                                            </td>
                                    </table><br>
                                    <td><input type="submit" class="button-green" id='submit' name="submit" value="Toevoegen" tabindex="7"/></td>
                                </form></center>
                            <?php
                        }
                        include_once '../Php/Database.php';
                        // het laden van alle gebruikers
                        $gebruikers = BeveiligGetSQLArray('SELECT GebruikerID, Naam, Rol, Email FROM boomkwekerij.gebruiker', array());
                        ?><br>
                        <center>  <h5>Gebruikers wijzigen</h5>
                            <?php ?>
                            <table>
                                <tr>
                                    <th>Naam</th>
                                    <th>Email</th>
                                    <th>Rechten</th>
                                    <th>Bewerken</th>
                                    <th>Verwijder</th>
                                </tr>
                                <?php
                                while ($rij = $gebruikers->fetch()) {
                                    ?>
                                    <tr>
                                        <td> <?php print($rij['Naam']); ?> </td><!--naam van de gebruiker-->
                                        <td> <?php print($rij['Email']); ?> </td><!--email van gebruiker-->
                                        <td> 
                                            <?php
                                            // Het weergeven van de juiste gebruikersrol ipv getal
                                            if ($rij['Rol'] == '1') {
                                                $rij['Rol'] = 'Beheerder';
                                            } elseif ($rij['Rol'] == '2') {
                                                $rij['Rol'] = 'Medewerker';
                                            } elseif ($rij['Rol'] == '3') {
                                                $rij['Rol'] = 'Vertaler';
                                            }
                                            print($rij['Rol']);
                                            ?>
                                        </td>
                                        <td>
                                            <form action="../Pages/user_edit.php" method="POST"> <!--doorsturen naar aanpaspagina-->
                                                <input type='hidden' name='gebruiker' value="<?php print($rij['GebruikerID']) ?>" />
                                                <input type="submit" class="button-blue" name="submit" value="Bewerk"/>
                                            </form>
                                        </td>

                                        <td id="verwijdertd"> <input type="submit"  class="button-red" name="submit" value="X"/></td>
                                            <?php
                                        }
                                        ?>
                                </tr>
                            </table></center>
                    </div>
                </section>
            </section>
        </section>
        <?php
        include '../Php/footer.php';
        ?>
    </body>
</html>