<!DOCTYPE html>
<?php

function SendMail($receiver, $subject, $message, $Naam, $Email)
{
    $headers = 'From: test@boomkwekerij.pe.hu' . "\r\n" .
            'Reply-To: ' . $receiver . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
    $message = "Naam: " . $Naam . " Website: " . $Email . $message;
    mail($receiver, $subject, $message, $headers);
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
                <?php
                include '../Php/menu.php';
                ?>
            </section>
            <section id="mid">
                <section id="rightmenu">
                    <?php
                    include '../Php/rightmenu.php';
                    ?>
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
        <?php
        include '../Php/footer.php';
        ?>
    </body>
</html>