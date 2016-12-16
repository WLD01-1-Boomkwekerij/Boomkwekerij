<!DOCTYPE html>
<?php
include '../Php/Database.php';

function SendMail($sender, $subject, $message, $Naam, $Website)
{
    $sendEmailTo = getSQLArray("SELECT Email FROM gebruiker WHERE KrijgtEmail = 1");
    while ($row = $sendEmailTo->fetch()){
        print('send');
        $receiver = $row['Email'];
        $headers = 'From: test@boomkwekerij.pe.hu' . "\r\n" .
            'Reply-To: ' . $sender . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        $message = "Naam: " . $Naam . " Website: " . $Website . $message;
        mail($sender, $subject, $message, $headers);
}   }
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