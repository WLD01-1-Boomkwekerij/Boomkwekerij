<section  class="notranslate" id="footer">
    <?php
    // Checks if the user is logged in
    // If the user is logged in the footer will display "uitloggen"
    if (isset($_SESSION['logged_in'])) {
        print("<a class='logInText' href='../Php/loggout.php'>Uitloggen</a>");
    } else {
        // If he is logged out the footer will display "inloggen"
        print("<nav><a class='logInText' href='login.php'>Inloggen</a></nav>");
    }
    ?>
</section>

