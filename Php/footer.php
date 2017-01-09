<section  class="notranslate" id="footer">
    <?php
    // Controleert of de gebruiker is ingelogd.
    // ls de gebruiker al is ingelogd dan word er "Uitloggen" weergeven
    if (isset($_SESSION['logged_in'])) {
        print("<a class='logInText' href='../Php/loggout.php'>Uitloggen</a>");
    } else {
        // Als de gebruiker nog niet is ingelogd, dan word er "Inloggen" weergeven.
        print("<nav><a class='logInText' href='login.php'>Inloggen</a></nav>");
    }
    ?>
</section>

