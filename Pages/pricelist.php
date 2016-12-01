<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="notranslate">Boomkwekerij - Prijslijst</title>
        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link href="../Css/PricelistStyle.css" rel="stylesheet" type="text/css">
        <?php
        session_start();
        include '../Php/DatabaseInformation.php';
        //if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
        print("<link href='../Css/EditableCss.css' rel='stylesheet' type='text/css'>");
        print("<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>");
        print("<script src='../Javascript/InformationEditing.js'></script>");
        // }
        ?>
    </head>
    <body>
        <section id="wrapper">
            <section id="top">
                <section id="header"></section>
                <?php
                include '../Php/menu.php';
                ?>
            </section>
            <section id="mid">
                <section id="rightmenu">
                    <div id="google_translate_element"></div>
                    <script type="text/javascript">
                        function googleTranslateElementInit() {
                            new google.translate.TranslateElement({pageLanguage: 'nl', includedLanguages: 'en,it,nl,sv', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
                        }
                    </script>
                    <h3>Contact informatie</h3>
                    <?php
                    //Gebruik dit commando met de TextID van de tekst om hem altijd te laten werken
                    print("<div ");
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
                        print("class='ContentEditable'");
                    }
                    print("id = 'textID1'>");
                    print(loadTextFromDB(2));
                    print("</div>");
                    ?>
                    <h3>Groen-Direkt Boskoop</h3>
                    Geen opkomende evenementen<br>
                    <a href="http://www.groen-direkt.nl/home-nl" TARGET="_blank">link</a>
                </section>
                <section id="maincontent">
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "usbw";
                    $dbname = "boomkwekerij";
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $sql = "SELECT * FROM Category WHERE CategoryID IN(SELECT distinct CategoryID FROM prijs)";
                    $result = $conn->query($sql);
                    ?>
                    <h1>Prijslijst</h1>

                    <table class="pricelist">
                        <colgroup>
                            <col class="name"/>
                            <col class="name"/>
                            <col class="blue"/>
                            <col class="white"/>
                            <col class="blue"/>
                            <col class="white"/>
                            <col class="blue"/>
                            <col class="white"/>
                            <col class="blue"/>
                        </colgroup>
                        <tr>
                            <th rowspan="2" colspan="2"><h2>Plantnaam</h2></th>
                            <th rowspan="2">potmaat</th>
                            <th>hoogte</th>
                            <th colspan="2" class="white">prijs (€)</th>
                            <th>per</th>
                            <th>per</th>
                            <th>per</th>
                        </tr>
                        <tr> 
                            <td>(cm)</td>
                            <td>af<br>kwekerij</td>
                            <td>via VBA</td>
                            <td>cc</td>
                            <td>laag</td>
                            <td>tray</td>
                        </tr>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            $CategoryID = $row['CategoryID'];
                            print ("<tr  class='notranslate' ><td class = 'name' colspan = '9'><h2><a href = '../Pages/catalog.php?category=$CategoryID'>" . $row["CategoryNaam"] . "</a></h2></td></tr>");
                            
                            $sql2 = "SELECT * FROM prijs WHERE CategoryID=" . $row['CategoryID'];
                            $result2 = $conn->query($sql2);
                            
                            while ($row2 = $result2->fetch_assoc()) {
                                ?>
                                <tr class="notranslate">
                                    <?php
                                    if (isset($row2['ExtraBeschrijving'])) {
                                        print("<td>" . $row2['Naam'] . "</td>");
                                        print("<td>" . $row2['ExtraBeschrijving'] . "</td>");
                                    } else {
                                        print("<td colspan = '2'>" . $row2['Naam'] . "</td>");
                                    }
                                    print("<td>" . $row2['Potmaat'] . "</td>");
                                    if ($row2['Hoogte_min'] == 0 && $row2['Hoogte_min'] == 0) {
                                        print("<td></td>");
                                    } elseif ($row2['Hoogte_min'] == $row2['Hoogte_max']) {
                                        print("<td>" . $row2['Hoogte_min'] . "</td>");
                                    } else {
                                        print("<td>" . $row2['Hoogte_min'] . "/" . $row2['Hoogte_max'] . "</td>");
                                    }
                                    print("<td>" . $row2['PrijsKwekerij'] . "</td>
                                    <td>" . $row2['PrijsVBA'] . "</td>
                                    <td>" . $row2['ProductenCC'] . "</td>
                                    <td>" . $row2['ProductenLaag'] . "</td>
                                    <td>" . $row2['ProductenTray'] . "</td>
                                </tr>");
                                }
                            }
                            $conn->close();
                            ?>
                    </table>
                </section>
            </section>
        </section>
        <?php
        include '../Php/footer.php';
        ?>
    </body>
</html>