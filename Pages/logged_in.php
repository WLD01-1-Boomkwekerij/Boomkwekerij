<?php 
// We werken ook hier met sessies 
session_start(); 

// Controleren of de bezoeker ingelogd is 
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) 
{ 
    header('Location:login.php'); 
    exit(); 
} 

// Een welkomst tekst weergeven 
echo 'Welkom '.$_SESSION['gebruiker'].' wat leuk dat je er weer bent.'; 
?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
            <li><a href="../pages/loggout.php">Uitloggen</a></li>
        </section>
    </body>
</html>



    </body>
</html>
