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
        <title></title>
    </head>
    <body>
        <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Boomkwekerij - Catalogus</title>
            <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
            
        </head>
        <body>
            <section id="wrapper">
                <section id="top">
                    <section id="header"></section>
                     <section id="topmenu">
                        <ul>
                            <li><a href="../pages/index.php">Home</a></li>
                            <li><a href="../pages/news.php">Nieuws</a></li>
                            <li><a href="../pages/catalog.php">Catalogus</a></li>
                            <li><a href="../pages/pricelist.php">Prijslijst</a></li> 
                            <li><a href="../pages/contact.php">Contact</a></li>
                        <?php
                        if(isset($_SESSION['logged_in'])){
                            print("<li><a href='../pages/logged_in.php'>Beheerderspagina</a></li>");
                        }
                         ?>
                        </ul>
                    </section>
                </section>
                
                <section id="mid">
                    <section id="rightmenu">
                        <h3>Catalogus</h3>
                        <ul id="catalogus">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </section>
                    <section id="maincontent">
                        <?php echo "Je bent ingelogd!" ?>
                    </section>
                </section>
            </section>
            <section id="footer">
                  <?php
            if(isset($_SESSION['logged_in'])){
                print("<li><a href='../Php/loggout.php'>Uitloggen</a></li>");
            }else{
                print("<li><a href='../pages/login.php'>Inloggen</a></li>");
            }
            ?>
            </section>
        </body>
    </html>