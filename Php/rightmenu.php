
<div id="google_translate_element"></div><script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({pageLanguage: 'nl', includedLanguages: 'en,it,nl,sv', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
    }
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<h3>Contact informatie</h3>
<div class="notranslate">
    <?php
<<<<<<< HEAD
    print("<div ");
    if (isset($_SESSION['logged_in'])) {
        include_once '../Php/DatabaseInformation.php';
        print("class='ContentEditable'");
=======
    include_once '../Php/DatabaseInformation.php';
    
    print("<div class='clearFix' id='tekstDIV' style='position: relative'>");
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
        print("<div class='ContentEditable' style='width: 100%; height: 100%; position: absolute; z-index: 1000'></div>");
>>>>>>> ebe338a4e420e452319bdefb42ad5fc13855779a
    }
    print("<div id='textID2'>");
    loadTextFromDB(2);
    print("</div>");
    ?>
</div>