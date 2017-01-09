
<h3>Contact informatie</h3>
<div class="notranslate">
    <?php
    print("<div class='clearFix' id='tekstDIV' style='position: relative'>");
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
    {
        print("<div class='ContentEditable' style='width: 100%; height: 100%; position: absolute; z-index: 1000'></div>");
    }
    print("<div id='textID2'>");
    loadTextFromDB(2);
    print("</div>");
    ?>
</div>