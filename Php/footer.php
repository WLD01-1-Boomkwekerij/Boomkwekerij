<html>
    <head><link a href="mainstyle.css" rel="stylesheet" type="text/css"></head>
</html>


<section  class="notranslate" id="footer">
    <?php
    // Controleert of de gebruiker is ingelogd.
    // ls de gebruiker al is ingelogd dan word er "Uitloggen" weergeven
    if (isset($_SESSION['logged_in'])) {
        print("<li><a href='../Php/loggout.php'>Uitloggen</a></li>");
    } else {
        // Als de gebruiker nog niet is ingelogd, dan word er "Inloggen" weergeven.
        print("<nav><li><a href='login.php'>Inloggen</a></li></nav>");
    }
    ?>
</section>

