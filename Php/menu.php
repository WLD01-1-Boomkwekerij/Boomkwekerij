<section id="topmenu">
    <ul>
        <li><a href="../pages/index.php">Home</a></li>
        <li><a href="../pages/news.php">Aanbiedingen</a></li>
        <li><a href="../pages/catalog.php">Catalogus</a></li>
        <li><a href="../pages/pricelist.php">Prijslijst</a></li> 
        <li><a href="../pages/contact.php">Contact</a></li>
        <?php
        if (isset($_SESSION['logged_in'])) {
            print("<li><a href='../pages/logged_in.php'>Beheerderspagina</a></li>");
        }
        ?>
    </ul>
</section>
