<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="notranslate">&#127795; Boomkwekerij - Aanbiedingen</title>
        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link href="../Css/Logged_inStyle.css" rel="stylesheet" type="text/css">
        <?php
        session_start();
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
                    <h4>Bewerken</h4>
                    <form  action="update_delete.php" method="post">
                        <?php
                        $gebruiker=$_POST["gebruiker"];
                        include_once '../Php/Database.php';
                        $array = getSQLArray('SELECT * FROM boomkwekerij.gebruiker WHERE GebruikerID =' . $gebruiker);
                        while ($data = $array->fetch()) {
                            print('<h5>' . $data['Naam'] . '</h5>');
                            ?>
                            <table>
                                <tr>
                                    <th>Naam</th>
                                    <th>Email</th>
                                    <th>Krijgt notifactie</th>
                                    <th>Rechten</th>
                                    <th>Bewerken</th>
                                    <th>Verwijderen</th>
                                </tr>
                                <tr>
                                    <td><input name="gebr_naam" id="gebr_naam" type="text" tabindex="1" required value="<?php print($data['Naam']); ?>"></td>
                                    <td><input name="gebr_mail" id="gebr_mail" type="email" tabindex="2" required value="<?php print($data['Email']); ?>"></td>
                                    <td>
                                        <?php
                                        if ($data['KrijgtEmail'] = 0) {
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
                                    <td> 
                                        <?php
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
                                    <td><input type='hidden' name='gebruiker' value="<?php print($gebruiker); ?>" /><input type="submit" name="submit" value="Bewerken"/></td>
                                    <td><input type='hidden' name='gebruiker' value="<?php print($gebruiker); ?>" /><input type="submit" name="submit" value="Verwijderen"/></td>
                                </tr>
                            </table>
                        <?php } ?>
                    </form>
                </section>
            </section>
        </section>
        <?php
        include '../Php/footer.php';
        ?>
    </body>
</html>