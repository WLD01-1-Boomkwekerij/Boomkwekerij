<!DOCTYPE html>
<html>
    <head>
        <script>
            function printDiv() {
                var printContents = document.getElementById("printable").innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }
        </script>
        <meta charset="UTF-8">
        <title class="notranslate">Boomkwekerij - Prijslijst</title>
        <link href="../Css/PricelistStyle.css" rel="stylesheet" type="text/css">
        <link media="print" href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link media="print" href="../Css/PricelistStyle.css" rel="stylesheet" type="text/css">
        <link rel="plant icon" href="../Images/plant_icon.png">
        <?php
        session_start();
        include '../Html/includeHead.html';
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['toegang'] != 3) {
            $loggedIn = true;
            include '../Php/loggedInEditor.php';
        }
        ?>
    </head>
    <body>
        <section id="wrapper">
            <section id='titlediv' class="notranslate"><p id="imgtitle">FA.P.BOER BOOMKWEKERIJ</p></section>
            <section id="top">
                <section id="header"></section>
                <?php
                include '../Php/menu.php';
                ?>
            </section>
            <section id="mid">
                <section id="rightmenu">
                    <button id="printbutton" type="button" value="print" onclick="printDiv()">Print</button>
                    <?php
                    include '../Php/rightmenu.php';
                    ?>
                </section>
                <section id="maincontent">
                    <?php
                    if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3) {
                        //updates a prijsregel if it has been changed
                        if (isset($_POST['regel']) || isset($_POST['OpslaanRegel'])) {
                            $id = $_POST['id'];
                            $potmaat = $_POST['potmaat'];
                            $beschrijving = $_POST['beschrijving'];
                            $percc = $_POST['percc'];
                            $perlaag = $_POST['perlaag'];
                            $pertray = $_POST['pertray'];
                            $prijsKwekerij = money_format('%.2n', $_POST['prijskwekerij']);
                            $prijsVBA = money_format('%.2n', $_POST['prijsvba']);
                            $naam = $_POST['naam'];
                            $hoogteMin = $_POST['HoogteMin'];
                            $hoogteMax = $_POST['HoogteMax'];

                            if (isset($_POST['OpslaanRegel'])) {
                                ProtectedDoSQL("UPDATE prijs SET "
                                        . "PrijsKwekerij=?,"
                                        . " PrijsVBA=?, "
                                        . "ProductenCC=?, "
                                        . "ProductenLaag=?,"
                                        . " ProductenTray=?, "
                                        . "Naam=?,"
                                        . " ExtraBeschrijving=?,"
                                        . " Potmaat=?,"
                                        . " VerkoopHoogteMax = ?,"
                                        . " VerkoopHoogteMin = ?"
                                        . " WHERE PrijsID=?", array($prijsKwekerij, $prijsVBA, $percc, $perlaag, $pertray, $naam, $beschrijving, $potmaat, $hoogteMax, $hoogteMin, $id));
                                if ($pertray == 0) {
                                    ProtectedDoSQL("UPDATE prijs SET ProductenTray = NULL WHERE PrijsID=?", array($id));
                                }
                            }
                            else {
                                if ($_POST['pertray'] != 0) {
                                    ProtectedDoSQL("INSERT INTO prijs (
                                     `PrijsKwekerij`,
                                     `PrijsVBA`,
                                     `ProductenCC`,
                                     `ProductenLaag`,
                                     `ProductenTray`,
                                     `Naam`,
                                     `ExtraBeschrijving`,
                                     `Potmaat`,
                                     `CategoryID`,
                                     `VerkoopHoogteMax`,
                                     `VerkoopHoogteMin`) 
                                     VALUES (
                                         ?,"
                                            . " ?,"
                                            . " ?,"
                                            . " ?,"
                                            . " ?,"
                                            . " ?,"
                                            . " ?,"
                                            . " ?,"
                                            . " ?,"
                                            . " ?,"
                                            . " ?)", array($prijsKwekerij, $prijsVBA, $percc, $perlaag, $pertray, $naam, $beschrijving, $potmaat, $id, $hoogteMax, $hoogteMin)
                                    );
                                }
                                else {
                                    ProtectedDoSQL("INSERT INTO prijs (
                                     `PrijsKwekerij`,
                                     `PrijsVBA`,
                                     `ProductenCC`,
                                     `ProductenLaag`,
                                     `Naam`,
                                     `ExtraBeschrijving`,
                                     `Potmaat`,
                                     `CategoryID`) 
                                     VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)", array($prijsKwekerij, $prijsVBA, $percc, $perlaag, $naam, $beschrijving, $potmaat, $id)
                                    );
                                }
                            }
                        }

                        //deletes a prijsregel
                        if (isset($_POST['verwijderRegel'])) {
                            $id = $_POST['id'];

                            ProtectedDoSQL("DELETE FROM plantfoto WHERE PlantID IN(SELECT PlantID FROM plant WHERE PrijsID=?)", array($id));
                            ProtectedDoSQL("DELETE FROM plant WHERE PrijsID=?", array($id));
                            ProtectedDoSQL("DELETE FROM prijs WHERE PrijsID=?", array($id));
                        }

                        //adds a category
                        if (isset($_POST['category'])) {
                            $naam = $_POST['naam'];

                            ProtectedDoSQL("INSERT INTO category (`CategoryNaam`) VALUES (?)", array($naam));
                        }

                        //updates a category
                        if (isset($_POST['OpslaanCat'])) {
                            $id = $_POST['id'];
                            $naam = $_POST['naam'];
                            ProtectedDoSQL("UPDATE category SET CategoryNaam=? WHERE CategoryID=?", array($naam, $id));
                        }

                        //removes a category
                        if (isset($_POST['verwijderCat'])) {
                            $id = $_POST['id'];

                            ProtectedDoSQL("DELETE FROM plantfoto WHERE PlantID IN(SELECT PlantID FROM plant WHERE PrijsID IN(SELECT PrijsID FROM prijs WHERE CategoryID=?))", array($id));
                            ProtectedDoSQL("DELETE FROM plant WHERE PrijsID IN(SELECT PrijsID FROM prijs WHERE CategoryID=?);", array($id));
                            ProtectedDoSQL("DELETE FROM prijs WHERE CategoryID=?;", array($id));
                            ProtectedDoSQL("DELETE FROM category WHERE CategoryID=?;", array($id));
                        }
                    }
                    ?>

                    <div id='printable'> 

                        <h1>Prijslijst</h1>
                        <table class="pricelist">
                            <colgroup>
                                <col class="name"/>
                                <col class="name"/>
<?php
if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3) {
    echo "<col class='name'/>";
}
?>
                                <col class="blue"/>
                                <col class="white"/>
                                <col class="blue"/>
                                <col class="white"/>
                                <col class="blue"/>
                                <col class="white"/>
                                <col class="blue"/>
                            </colgroup>
                            <tr>
<?php
//Maakt knoppen aan
if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3) {
    print("<th rowspan='2' class='noprint'></th>");
}
?>
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
$result = ProtectedGetSQLArray("SELECT * FROM category", array());
//Nieuwe regel creëren voor elke categorie
while ($row = $result->fetch()) {
    $catID = $row['CategoryID'];
    $catNaam = $row["CategoryNaam"];
    //Maakt knoppen aan
    if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3) {
        if (!(isset($_POST['bewerkCat']) && $catID == $_POST['id'])) {
            print ("<tr  class='notranslate' >");
            echo"<td class='noprint'><form onsubmit='return confirm(`Wilt u dit echt verwijderen?`);' action='pricelist.php' method='post'>"
            . "<input type='hidden' name='id'  value='$catID'>"
            . "<input style='width:30%; background-color:#f44336; border:none; font-size:14px; color:white;' class='noprint' type='submit' name='verwijderCat'  value='X'>"
            . "</form>"
            . "<form  action='pricelist.php' method='post'>"
            . "<input type='hidden' name='id'  value='$catID'>"
            . "<input style='width:69%'  class='btnpricelist-blue' type='submit' name='bewerkCat'  value='Bewerken'>"
            . "</form>"
            . "</td>";
        }
        else {
            echo "<form action='pricelist.php' method='post'>";
            echo "<tr class='notranslate'>";
            echo "<td>"
            . "<input type='submit' class='noprint' name='OpslaanCat'  value='Opslaan'>"
            . "<input type='hidden' name='id'  value='$catID'>"
            . "</td>";
        }
    }


    if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3 && isset($_POST['bewerkCat']) && $catID == $_POST['id']) {
        // displays a input box
        echo "<td class = 'name' colspan = '9'>"
        . "<input required type='text' name='naam' value='$catNaam' ></td>"
        . "</tr></form>";
    }
    else {
        //places the category name
        echo "<td class = 'name' colspan = '9'>"
        . "<h2><a href = '../pages/catalog.php?category=$catID'>$catNaam</a></h2></td>"
        . "</tr>";
    }

    $result2 = ProtectedGetSQLArray("SELECT * FROM prijs WHERE CategoryID=?", array($catID));

    while ($row2 = $result2->fetch()) {
        //Maakt een rij van elke prijsregel
        $regelID = $row2["PrijsID"];
        if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3) {
            //creates buttons 'bewerken' and 'delete'
            if (!(isset($_POST['bewerkRegel']) && $regelID == $_POST['id'])) {
                echo '<tr class="notranslate">';
                echo"<td class='noprint'><form action='pricelist.php' method='post'>"
                . "<input type='hidden' name='id'  value='$regelID'>"
                . "<input style='width:30%; background-color:#f44336; border:none;font-size:14px; color:white;' type='submit' name='verwijderRegel'  value='X'>"
                . "</form>"
                . "<form action='pricelist.php' method='post'>"
                . "<input type='hidden' name='id'  value='$regelID'>"
                . "<input style='width:69%' type='submit' name='bewerkRegel'  class='btnpricelist-blue' value='Bewerken'>"
                . "</form>"
                . "</td>";
            }
            else {
                echo "<form action='pricelist.php' method='post'>";
                echo "<tr class='notranslate'>";
                echo "<td class='noprint'>"
                . "<input type='submit' name='OpslaanRegel' class='btnpricelist-green' value='Opslaan'>"
                . "<input type='hidden' name='id'  value='$regelID'>"
                ;
            }
        }

        $plantNaam = $row2['Naam'];
        $plantExtraBeschrijving = $row2['ExtraBeschrijving'];


        $potmaat = $row2['Potmaat'];
        $prijsKwekerij = money_format('%.2n', $row2['PrijsKwekerij']);
        $prijsVBA = money_format('%.2n', $row2['PrijsVBA']);
        $productenCC = $row2['ProductenCC'];
        $productenLaag = $row2['ProductenLaag'];
        $productenTray = $row2['ProductenTray'];

        $Hoogte_Min = $row2['VerkoopHoogteMin'];
        $Hoogte_Max = $row2['VerkoopHoogteMax'];
        $Hoogte = "";
        if ($Hoogte_Min == $Hoogte_Max) {
            $Hoogte = $Hoogte_Max;
        }
        else {
            $Hoogte = $Hoogte_Min . "/" . $Hoogte_Max;
        }

        if (!(isset($_POST['bewerkRegel']) && $regelID == $_POST['id'])) {
            // Print de data van een regel
            if ($plantExtraBeschrijving != "") {
                print("<td>$plantNaam</td>");
                print("<td>$plantExtraBeschrijving</td>");
            }
            else {
                print("<td colspan = '2' >$plantNaam</td>");
            }
            print("<td>$potmaat</td>");
            print("<td>$Hoogte</td>");
            print("<td>$prijsKwekerij</td>"
                    . "<td>$prijsVBA</td>"
                    . "<td>$productenCC</td>"
                    . "<td>$productenLaag</td>"
                    . "<td>$productenTray</td>"
                    . "</tr>");
        }
        else {
            //Inpuvelden aanmaken om de rijen aan te passen
            echo ""
            . "<td>"
            . "<input required type='text' name='naam' value='$plantNaam'>"
            . "</td>"
            . "<td>"
            . "<input type='text' name='beschrijving' value='$plantExtraBeschrijving' >"
            . "</td> "
            . "<td>"
            . "<input type='text' name='potmaat' value='$potmaat'>"
            . "</td> "
            . "<td>"
            . "<input style='width: 50%' type='text' name='HoogteMin' value='$Hoogte_Min'>"
            . "<input style='width: 50%' type='text' name='HoogteMax' value='$Hoogte_Max'>"
            . "</td> "
            . "<td>"
            . "<input type='number' name='prijskwekerij' value='$prijsKwekerij' step='0.01'>"
            . "</td> "
            . "<td>"
            . "<input type='number' name='prijsvba' value='$prijsVBA' step='0.01'>"
            . "</td> "
            . "<td>"
            . "<input type='number' name='percc' value='$productenCC'>"
            . "</td> "
            . "<td>"
            . "<input type='number' name='perlaag' value='$productenLaag'>"
            . "</td> "
            . "<td>"
            . "<input type='number' name='pertray' value='$productenTray'>"
            . "</td> "
            . "</tr>"
            . "</form>";
        }
    }
    //Creëert een forum voor het aanmaken van nieuwe prijsregels
    if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3) {
        echo "<form action='pricelist.php' method='post'>"
        . "<tr class='notranslate'> "
        . "<td class='noprint'>"
        . "<input type='hidden' name='id'  value='$catID'>"
        . "<input type='submit' class='btnpricelist-green' name='regel'  value='Regel toevoegen'>"
        . "</td>"
        . "<td class='noprint'>"
        . "<input required type='text' name='naam'>"
        . "</td>"
        . "<td class='noprint'>"
        . "<input type='text' name='beschrijving'>"
        . "</td> "
        . "<td class='noprint'>"
        . "<input type='text' name='potmaat'>"
        . "</td> "
        . "<td class='noprint'>"
        . "<input style='width: 50%' type='text' name='HoogteMin'>"
        . "<input style='width: 50%' type='text' name='HoogteMax'>"
        . "</td> "
        . "<td class='noprint'>"
        . "<input type='number' name='prijskwekerij' step='0.01'>"
        . "</td> "
        . "<td class='noprint'>"
        . "<input type='number' name='prijsvba' step='0.01'>"
        . "</td> "
        . "<td class='noprint'>"
        . "<input type='number' name='percc'>"
        . "</td> "
        . "<td class='noprint'>"
        . "<input type='number' name='perlaag'>"
        . "</td> "
        . "<td class='noprint'>"
        . "<input type='number' name='pertray' >"
        . "</td> "
        . "</tr>"
        . "</form>";
    }
}
//Creëert een veld om een nieuwe categorie toe te voegen
if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3) {
    echo "<form action='pricelist.php' method='post'>"
    . "<tr class='notranslate'> "
    . "<td class='noprint'> "
    . "<input type='submit' name='category' class='btnpricelist-green' value='Category toevoegen'>"
    . "</td><td colspan='2' class='noprint'>"
    . "<input required type='text' name='naam'>"
    . "</td> "
    . "</form>";
}
?>
                        </table>
                    </div>
                </section><!DOCTYPE html>
            </section>
        </section>
<?php
include '../Php/footer.php';
?>
    </body>
</html>