<section  class="notranslate" id="footer">
    <?php
    if (isset($_SESSION['logged_in'])) {
        print("<li><a href='../Php/loggout.php'>Uitloggen</a></li>");
    } else {
        print("<li><a href='login.php'>Inloggen</a></li>");
    }
    
    print("<p onclick='createManager(true)'>Upload</p>");
    ?>
</section>

