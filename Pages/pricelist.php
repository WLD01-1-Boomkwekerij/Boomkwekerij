<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="notranslate">Boomkwekerij - Prijslijst</title>
        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link href="../Css/PricelistStyle.css" rel="stylesheet" type="text/css">
        <link rel="plant icon" href="../Images/plant_icon.png">
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
                <?php
                include '../Php/menu.php';
                ?>
            </section>
            <section id="mid">
                <section id="rightmenu">
                    
                    <?php
                    include '../Php/rightmenu.php';
                    ?>
                </section>
                <section id="maincontent">
                    <?php
                    $result = getSQLArray("SELECT * FROM Category WHERE CategoryID IN(SELECT distinct CategoryID FROM prijs)");
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
                            <th colspan="3">per</th>
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
                        while ($row = $result->fetch()) {
                            $catID = $row['CategoryID'];
                            print ("<tr  class='notranslate' >"
                                    . "<td class = 'name' colspan = '9'>"
                                    . "<h2><a href = '../Pages/catalog.php?category=$catID'>" . $row["CategoryNaam"] . "</a></h2></td>"
                                    . "</tr>");
                            $result2 = getSQLArray("SELECT * FROM prijs WHERE CategoryID=" . $catID);
                            
                            while ($row2 = $result2->fetch()) {
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
                                    
                                    $result3 = getSQLArray("SELECT Hoogte_min, Hoogte_max FROM plant WHERE PrijsID=" . $row2['PrijsID']);
                                    $plantHoogte = $result3->fetch();
                                    if ($plantHoogte['Hoogte_min'] == 0 && $plantHoogte['Hoogte_min'] == 0) {
                                        print("<td></td>");
                                    } elseif ($plantHoogte['Hoogte_min'] == $plantHoogte['Hoogte_max']) {
                                        print("<td>" . $plantHoogte['Hoogte_min'] . "</td>");
                                    } else {
                                        print("<td>" . $plantHoogte['Hoogte_min'] . "/" . $plantHoogte['Hoogte_max'] . "</td>");
                                    }
                                    print("<td>" . $row2['PrijsKwekerij'] . "</td>
                                    <td>" . $row2['PrijsVBA'] . "</td>
                                    <td>" . $row2['ProductenCC'] . "</td>
                                    <td>" . $row2['ProductenLaag'] . "</td>
                                    <td>" . $row2['ProductenTray'] . "</td>
                                </tr>");
                                }
                            }
                            
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