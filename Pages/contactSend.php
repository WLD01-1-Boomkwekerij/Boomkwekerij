<!DOCTYPE html>
<?php

function SendMail($to, $subject, $message, $Naam, $Email) {
    $headers = 'From: test@boomkwekerij.pe.hu' . "\r\n" .
            'Reply-To: ' . $to . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
    $message = "Naam: " . $Naam . " Website: " . $Email . $message;
    mail($to, $subject, $message, $headers);
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Boomkwekerij - Contact</title>
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
                    <a href="http://www.groen-direkt.nl/home-nl">link</a>
                </section>
                <section id="maincontent">
                    <h1>Dank u wel voor uw verzoek.</h1>
                    <h1>Uw mail is verzonden.</h1>
<?php
echo $_POST['contact_name'];
echo '<br>';
echo $_POST['contact_subject'];
echo '<br>';
echo $_POST['contact_email'];
echo '<br>';
echo $_POST['contact_website'];
echo '<br>';
echo $_POST['contact_content'];
echo '<br>';
SendMail($_POST['contact_email'], $_POST['contact_subject'], $_POST['contact_content'], $_POST['contact_name'], $_POST['contact_website']);
?>
                </section>
            </section>
        </section>
        <section id="footer">
            nog meer sampletekst
        </section>
    </body>
</html>