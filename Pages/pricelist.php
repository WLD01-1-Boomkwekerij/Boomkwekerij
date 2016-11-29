<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="notranslate">Boomkwekerij - Prijslijst</title>
        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link href="../Css/PricelistStyle.css" rel="stylesheet" type="text/css">
        <?php
        session_start();
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
                <section id="topmenu">
                    <ul>
                        <li><a href="../pages/index.php">Home</a></li>
                        <li><a href="../pages/news.php">Nieuws</a></li>
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
            </section>
            <section id="mid">
                <section id="rightmenu">
                    <div id="google_translate_element"></div><script type="text/javascript">
                        function googleTranslateElementInit() {
                            new google.translate.TranslateElement({pageLanguage: 'nl', includedLanguages: 'en,it,nl,sv', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
                        }
                    </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                    <h3>Contact informatie</h3>
                    <ul class="notranslate" id="contact_information">
                        <li>Fa. P. Boer</li>
                        <li>Rijneveld 125<br>2771 XV Boskoop</li>
                        <li>B.G.G:<br>0031 (0)172217308</li>
                        <li>Peter Boer:<br>0031 (0)657915055</li>
                        <li>Robert Boer:<br>0031(0)622442190</li>
                        <li>fax:<br>0031 (0)172216827</li>
                        <li>E-mail:<br>info@boomkwekerijpboer.nl</li>
                    </ul>
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
                            print ("<tr  class='notranslate' ><td class = 'name' colspan = '9'><h2><a href = '../Pages/catalog.php'>" . $row["CategoryNaam"] . "</a></h2></td></tr>");
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
        <section  class="notranslate" id="footer">
            <?php
            if (isset($_SESSION['logged_in'])) {
                print("<li><a href='../Php/loggout.php'>Uitloggen</a></li>");
            } else {
                print("<li><a href='../pages/login.php'>Inloggen</a></li>");
            }
            ?>
        </h1>
    </section>
</body>
</html>