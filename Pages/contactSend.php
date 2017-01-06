<?php
session_start();
// Controleert of de captcha correct is ingevuld
if (isset($_POST["captcha"]) && $_POST["captcha"] != "" && $_SESSION["code"] == $_POST["captcha"]) {
    include '../Php/Database.php';

    /**
     * This sends an email
     * 
     * @param string $sender
     * @param string $subject
     * @param string $message
     * @param string $Naam
     * @param string $Website
     */
    
    // Functie voor het verzenden van de email
    // Bepalen welke gegevens moeten worden verzonden
    function SendMail($sender, $subject, $message, $Naam, $Website) {
        $sendEmailTo = ProtectedGetSQLArray("SELECT Email FROM gebruiker WHERE KrijgtEmail = 1",array());
        while ($row = $sendEmailTo->fetch()) {
            print('send');
            $receiver = $row['Email'];
            $headers = 'From: test@boomkwekerij.pe.hu' . "\r\n" .
                    'Reply-To: ' . $sender . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
            $message = "Naam: " . $Naam . " Website: " . $Website . $message;
            mail($sender, $subject, $message, $headers);
        }
    }
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Boomkwekerij - Contact</title>
            <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
            <link href="../Css/ContactStyle.css" rel="stylesheet" type="text/css">
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
                        <!-- Bevestigingsbericht -->
                        <h2>Dank u wel voor uw verzoek.</h2>
                        <h2>Uw mail is verzonden.</h2>
                        <?php
                        // Verzend email
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
    <?php
} else {
    header('Refresh: 5; url=../Pages/Contact.php');
echo "
   <html>
        <head>
            <meta charset='UTF-8'>
            <title>Boomkwekerij - Contact</title>
            <link href='../Css/MainStyle.css' rel='stylesheet' type='text/css'>
            <link href='../Css/ContactStyle.css' rel='stylesheet' type='text/css'>
        </head>
        <body>
            <section id='wrapper'>
                <section id='top'>
                    <section id='header'></section>
                    ";
                    include '../Php/menu.php';
                 echo "
                </section>
                <section id='mid'>
                    <section id='rightmenu'>;
                        
                        
                       
             ";     include '../Php/rightmenu.php';
     echo"
   
                    </section>
                    <section id='maincontent'><br>
                       <div id='capthaerror'>
                        <center> <h4> U heeft uw captcha niet correct ingevuld!</h4>
                        <h4>U wordt doorverwezen.</h4></center>
                       </div>
                    </section>
                </section>
            </section>

</html>";}
?>