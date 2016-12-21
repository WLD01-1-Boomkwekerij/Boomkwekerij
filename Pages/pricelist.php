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
        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link href="../Css/PricelistStyle.css" rel="stylesheet" type="text/css">
        <link media="print" href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link media="print" href="../Css/PricelistStyle.css" rel="stylesheet" type="text/css">
        <link rel="plant icon" href="../Images/plant_icon.png">
        <?php
        session_start();
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['toegang'] != 3) {
            $loggedIn = true;
            include '../Php/loggedInEditor.php';
        }
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
                    <button id="printbutton" type="button" value="print" onclick="printDiv()">Print</button>
                    <?php
                    include '../Php/rightmenu.php';
                    ?>
                </section>
                <section id="maincontent">
                    <?php
                    if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3) {
                        if (isset($_POST['regel']) || isset($_POST['OpslaanRegel'])) {
                            $id = $_POST['id'];
                            $potmaat = $_POST['potmaat'];
                            $beschrijving = $_POST['beschrijving'];
                            $percc = $_POST['percc'];
                            $perlaag = $_POST['perlaag'];
                            $pertray = $_POST['pertray'];
                            $prijsKwekerij = $_POST['prijskwekerij'];
                            $prijsVBA = $_POST['prijsvba'];
                            $naam = $_POST['naam'];

                            if (isset($_POST['OpslaanRegel'])) {
                                doSQL("UPDATE prijs SET "
                                        . "PrijsKwekerij='$prijsKwekerij',"
                                        . " PrijsVBA='$prijsVBA', "
                                        . "ProductenCC='$percc', "
                                        . "ProductenLaag='$perlaag',"
                                        . " ProductenTray='$pertray', "
                                        . "Naam='$naam',"
                                        . " ExtraBeschrijving='$beschrijving',"
                                        . " Potmaat='$potmaat'"
                                        . " WHERE PrijsID=$id");
                                if ($pertray == 0) {
                                    doSQL("UPDATE prijs SET ProductenTray = NULL WHERE PrijsID=$id");
                                }
                            } else {
                                if ($_POST['pertray'] != 0) {
                                    doSQL("INSERT INTO prijs (
                                     `PrijsKwekerij`,
                                     `PrijsVBA`,
                                     `ProductenCC`,
                                     `ProductenLaag`,
                                     `ProductenTray`,
                                     `Naam`,
                                     `ExtraBeschrijving`,
                                     `Potmaat`,
                                     `CategoryID`) 
                                     VALUES (
                                     '$prijsKwekerij',"
                                            . " '$prijsVBA', "
                                            . "'$percc', "
                                            . "'$perlaag',"
                                            . " '$pertray',"
                                            . " '$naam',"
                                            . " '$beschrijving',"
                                            . " '$potmaat',"
                                            . " '$id')");
                                } else {
                                    doSQL("INSERT INTO prijs (
                                     `PrijsKwekerij`,
                                     `PrijsVBA`,
                                     `ProductenCC`,
                                     `ProductenLaag`,
                                     `Naam`,
                                     `ExtraBeschrijving`,
                                     `Potmaat`,
                                     `CategoryID`) 
                                     VALUES (
                                     '$prijsKwekerij',"
                                            . " '$prijsVBA', "
                                            . "'$percc', "
                                            . "'$perlaag',"
                                            . " '$naam',"
                                            . " '$beschrijving',"
                                            . " '$potmaat',"
                                            . " '$id')");
                                }
                            }
                        }
                        if (isset($_POST['verwijderRegel'])) {
                            $id = $_POST['id'];

                            doSQL("DELETE FROM plantfoto WHERE PlantID IN(SELECT PlantID FROM plant WHERE PrijsID='$id')");
                            doSQL("DELETE FROM plant WHERE PrijsID='$id';");
                            doSQL("DELETE FROM prijs WHERE PrijsID='$id';");
                        }


                        if (isset($_POST['category'])) {
                            $naam = $_POST['naam'];

                            doSQL("INSERT INTO category (`CategoryNaam`) VALUES ('$naam')");
                        }

                        if (isset($_POST['OpslaanCat'])) {
                            $id = $_POST['id'];
                            $naam = $_POST['naam'];
                            doSQL("UPDATE category SET CategoryNaam='$naam' WHERE CategoryID=$id");
                        }

                        if (isset($_POST['verwijderCat'])) {
                            $id = $_POST['id'];

                            doSQL("DELETE FROM plantfoto WHERE PlantID IN(SELECT PlantID FROM plant WHERE PrijsID IN(SELECT PrijsID FROM prijs WHERE CategoryID='$id'))");
                            doSQL("DELETE FROM plant WHERE PrijsID IN(SELECT PrijsID FROM prijs WHERE CategoryID='$id');");
                            doSQL("DELETE FROM prijs WHERE CategoryID='$id';");
                            doSQL("DELETE FROM category WHERE CategoryID='$id';");
                        }
                    }
                    ?>

                    <div id="printable"> 
                        <img src="../images/banner.jpg" id="printheader" alt="header">
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
                                if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3) {
                                    print("<th rowspan='2'></th>");
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
                            $result = getSQLArray("SELECT * FROM Category");
                            while ($row = $result->fetch()) {
                                $catID = $row['CategoryID'];
                                $catNaam = $row["CategoryNaam"];
                                if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3) {
                                    if (!(isset($_POST['bewerkCat']) && $catID == $_POST['id'])) {
                                        print ("<tr  class='notranslate' >");
                                        echo"<td><form onsubmit='return confirm(`Wilt u dit echt verwijderen?`);' action='pricelist.php' method='post'>"
                                        . "<input type='hidden' name='id'  value='$catID'>"
                                        . "<input style='width:30%; background-color:red' type='submit' name='verwijderCat'  value='X'>"
                                        . "</form>"
                                        . "<form  action='pricelist.php' method='post'>"
                                        . "<input type='hidden' name='id'  value='$catID'>"
                                        . "<input style='width:69%' type='submit' name='bewerkCat'  value='Bewerken'>"
                                        . "</form>"
                                        . "</td>";
                                    } else {
                                        echo "<form action='pricelist.php' method='post'>";
                                        echo "<tr class='notranslate'>";
                                        echo "<td>"
                                        . "<input type='submit' name='OpslaanCat'  value='Opslaan'>"
                                        . "<input type='hidden' name='id'  value='$catID'>"
                                        . "</td>";
                                    }
                                }
                                if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3 && isset($_POST['bewerkCat']) && $catID == $_POST['id']) {
                                    echo "<td class = 'name' colspan = '9'>"
                                    . "<input required type='text' name='naam' value='$catNaam' ></td>"
                                    . "</tr></form>";
                                } else {
                                    echo "<td class = 'name' colspan = '9'>"
                                    . "<h2><a href = '../Pages/catalog.php?category=$catID'>$catNaam</a></h2></td>"
                                    . "</tr>";
                                }

                                $result2 = getSQLArray("SELECT * FROM prijs WHERE CategoryID=" . $catID);

                                while ($row2 = $result2->fetch()) {

                                    $regelID = $row2["PrijsID"];
                                    if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3) {

                                        if (!(isset($_POST['bewerkRegel']) && $regelID == $_POST['id'])) {
                                            echo '<tr class="notranslate">';
                                            echo"<td><form action='pricelist.php' method='post'>"
                                            . "<input type='hidden' name='id'  value='$regelID'>"
                                            . "<input style='width:30%' type='submit' name='verwijderRegel'  value='X'>"
                                            . "</form>"
                                            . "<form action='pricelist.php' method='post'>"
                                            . "<input type='hidden' name='id'  value='$regelID'>"
                                            . "<input style='width:69%' type='submit' name='bewerkRegel'  value='Bewerken'>"
                                            . "</form>"
                                            . "</td>";
                                        } else {
                                            echo "<form action='pricelist.php' method='post'>";
                                            echo "<tr class='notranslate'>";
                                            echo "<td>"
                                            . "<input type='submit' name='OpslaanRegel'  value='Opslaan'>"
                                            . "<input type='hidden' name='id'  value='$regelID'>"
                                            ;
                                        }
                                    }

                                    $plantNaam = $row2['Naam'];
                                    $plantExtraBeschrijving = $row2['ExtraBeschrijving'];


                                    $potmaat = $row2['Potmaat'];
                                    $prijsKwekerij = $row2['PrijsKwekerij'];
                                    $prijsVBA = $row2['PrijsVBA'];
                                    $productenCC = $row2['ProductenCC'];
                                    $productenLaag = $row2['ProductenLaag'];
                                    $productenTray = $row2['ProductenTray'];

                                    $result3 = getSQLArray("SELECT Hoogte_min, Hoogte_max FROM plant WHERE PrijsID=" . $row2['PrijsID']);
                                    $plantHoogte = $result3->fetch();
                                    $Hoogte_Min = $plantHoogte['Hoogte_min'];
                                    $Hoogte_Max = $plantHoogte['Hoogte_max'];

                                    if (!(isset($_POST['bewerkRegel']) && $regelID == $_POST['id'])) {

                                        if ($plantExtraBeschrijving != "") {
                                            print("<td>$plantNaam</td>");
                                            print("<td>$plantExtraBeschrijving</td>");
                                        } else {
                                            print("<td colspan = '2' >$plantNaam</td>");
                                        }

                                        print("<td>$potmaat </td>");
                                        if ($Hoogte_Min == 0 && $Hoogte_Min == 0) {
                                            print("<td></td>");
                                        } elseif ($Hoogte_Min == $Hoogte_Max) {
                                            print("<td>$Hoogte_Min</td>");
                                        } else {
                                            print("<td>$Hoogte_Min/$Hoogte_Max</td>");
                                        }
                                        print("<td>$prijsKwekerij</td>"
                                                . "<td>$prijsVBA</td>"
                                                . "<td>$productenCC</td>"
                                                . "<td>$productenLaag</td>"
                                                . "<td>$productenTray</td>"
                                                . "</tr>");
                                    } else {

                                        $plantNaam = $row2['Naam'];
                                        $plantExtraBeschrijving = $row2['ExtraBeschrijving'];


                                        $potmaat = $row2['Potmaat'];
                                        $prijsKwekerij = $row2['PrijsKwekerij'];
                                        $prijsVBA = $row2['PrijsVBA'];
                                        $productenCC = $row2['ProductenCC'];
                                        $productenLaag = $row2['ProductenLaag'];
                                        $productenTray = $row2['ProductenTray'];

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
                                if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3) {
                                    echo "<form action='pricelist.php' method='post'>"
                                    . "<tr class='notranslate'> "
                                    . "<td>"
                                    . "<input type='hidden' name='id'  value='$catID'>"
                                    . "<input type='submit' name='regel'  value='Regel toevoegen'>"
                                    . "</td>"
                                    . "<td>"
                                    . "<input required type='text' name='naam'>"
                                    . "</td>"
                                    . "<td>"
                                    . "<input type='text' name='beschrijving'>"
                                    . "</td> "
                                    . "<td>"
                                    . "<input type='text' name='potmaat'>"
                                    . "</td> "
                                    . "<td>"
                                    . "</td> "
                                    . "<td>"
                                    . "<input type='number' name='prijskwekerij' step='0.01'>"
                                    . "</td> "
                                    . "<td>"
                                    . "<input type='number' name='prijsvba' step='0.01'>"
                                    . "</td> "
                                    . "<td>"
                                    . "<input type='number' name='percc'>"
                                    . "</td> "
                                    . "<td>"
                                    . "<input type='number' name='perlaag'>"
                                    . "</td> "
                                    . "<td>"
                                    . "<input type='number' name='pertray' >"
                                    . "</td> "
                                    . "</tr>"
                                    . "</form>";
                                }
                            }
                            if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] != 3) {
                                echo "<form action='pricelist.php' method='post'>"
                                . "<tr class='notranslate'> "
                                . "<td> "
                                . "<input type='submit' name='category'  value='Category toevoegen'>"
                                . "</td><td colspan='2'>"
                                . "<input required type='text' name='naam'>"
                                . "</td> "
                                . "</form>";
                            }
                            ?>
                        </table>
                    </div>
                </section>
            </section>
        </section>
        <?php
        include '../Php/footer.php';
        ?>
    </body>
</html>