<div id="google_translate_element"></div>
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({pageLanguage: 'nl', includedLanguages: 'en,it,nl,sv', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
    }
</script>
<h3>Contact informatie</h3>
<?php
include_once '../Php/DatabaseInformation.php';
print("<div ");
if (isset($_SESSION['logged_in'])) {
    print("class='ContentEditable'");
}
print("id = 'textID2'>".loadTextFromDB(2)."</div>");
?>
<h3>Groen-Direkt Boskoop</h3>
Geen opkomende evenementen<br>
<a href="http://www.groen-direkt.nl/home-nl" TARGET="_blank">link</a>

