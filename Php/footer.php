<section  class="notranslate" id="footer">
    <?php
    if (isset($_SESSION['logged_in'])) {
        print("<li><a href='../Php/loggout.php'>Uitloggen</a></li>");
    } else {
        print("<li><a href='login.php'>Inloggen</a></li>");
    }
    
    print(" 
        <form action='../Upload.php' method='POST' enctype='multipart/form-data'>
            <input type='file' name='bestand'>
            <input type='submit' value='upload' name='submit'>
        </form>
        ");
    
    ?>
</section>

