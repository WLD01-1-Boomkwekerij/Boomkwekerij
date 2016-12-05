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
                    <form  action="logged_in.php" method="post">
                        <?php
                        print_r($_POST);
                        $gebruiker = $_POST['gebruiker'];
                        print($gebruiker);
                        ?>
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
                                    <select name="rol"tabindex="6">
                                        <option value="beheerder">Beheerder</option>
                                        <option value="mederwerker">Medewerker</option>
                                        <option value="vertaler">Vertaler</option>
                                    </select> 
                                </td>
                                <td><input type="submit" name="submit" value="Toevoegen" tabindex="7    "/></td>
                            <tr>
                        </table>
                </section>
            </section>
        </section>
        <?php
        include '../Php/footer.php';
        ?>
    </body>
</html>