<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Boomkwekerij - Home</title>
        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link href="../Css/HomeStyle.css" rel="stylesheet" type="text/css"> 
        <?php
        session_start();

        //if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            print("<link href='../Css/EditableCss.css' rel='stylesheet' type='text/css'>");
            print("<script src='../Javascript/InformationEditing.js'></script>");            
       // }
        ?>
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

                    </ul>
                </section>
            </section>
            <section id="mid">
                <section id="rightmenu">
                    <h3>Contact informatie</h3>
                    <ul id="contact_information">
                        <li>Fa. P. Boer</li>
                        <li>Rijneveld 125<br>2771 XV Boskoop</li>
                        <li>B.G.G:<br>0031 (0)172217308</li>
                        <li>Peter Boer:<br>0031 (0)657915055</li>
                        <li>Robert Boer:<br>0031(0)622442190</li>
                        <li>fax:<br>0031 (0)172216827</li>
                        <li>E-mail:<br>info@boomkwekerijpboer.nl</li>
                    </ul>
                    <h3>Groen-Direkt Boskoop</h3>
                    Geen opkomende evenementen<br>
                    <a href="http://www.groen-direkt.nl/home-nl" TARGET="_blank">link</a>
                </section>
                <section id="maincontent">
                    <h1>Welkom op de site</h1>
                    Bku iej fioejfoeifj dsiofjdsif jdsoi j

                    <h2>Lorem ipsum</h2>
                    
                    
                    <div class="ContentEditable" id="textID1">
                    
                       Deck the halls with boughs of holly
                    </div>
                    
                    
                </section>
            </section>
        </section>
        <section id="footer">
            <li><a href="../pageslogin.php">Inloggen</a></li>
        </section>
    </body>
</html>
