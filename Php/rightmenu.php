
<div id="google_translate_element"></div><script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({pageLanguage: 'nl', includedLanguages: 'en,it,nl,sv', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
    }
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<h3>Contact informatie</h3>
<div class="notranslate">
    <?php
    include_once '../Php/DatabaseInformation.php';
    print("<div ");
    if (isset($_SESSION['logged_in'])) {
        print("class='ContentEditable'");
    }
    print("<id = 'textID2'>" . loadTextFromDB(2) . "</div>");
    ?>
</div>