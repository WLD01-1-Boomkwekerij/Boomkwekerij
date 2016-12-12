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
        <link rel="plant icon" href="../Images/plant_icon.png">
        <?php
        session_start();
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
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

                    <?php
                    include '../Php/rightmenu.php';
                    ?>
                </section>
                <section id="maincontent">
                    <?php
                    include '../Php/AddRegel.php';
                    include '../Php/AddCategory.php';
<<<<<<< HEAD
                    include '../Php/DeleteRegel.php';
                    include '../Php/DeleteCategory.php';
                    $result = getSQLArray("SELECT * FROM Category");
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
                            <?php 
                            if (isset($_SESSION['logged_in'])) {
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
                            <?php 
                            if (isset($_SESSION['logged_in'])) {
                                print("<td></td>");
                            }      
                            ?>
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
                            if (isset($_SESSION['logged_in'])) {
                            print ("<tr  class='notranslate' >");
                            echo"<td><form action='pricelist.php' method='post'>"
                                        . "<input type='hidden' name='id'  value='$catID'>"
                                        . "<input style='width:10px' type='submit' name='verwijderCat'  value='X'>"
                                        . "</form>"
                                        . "<form action='pricelist.php' method='post'>"
                                        . "<input type='hidden' name='id'  value='$catID'>"
                                        . "<input style='width:30px' type='submit' name='bewerkCat'  value='Bewerken'>"
                                        . "</form>"
                                        . "</td>";
                            }
                            print ("<td class = 'name' colspan = '9'>"
                                    . "<h2><a href = '../Pages/catalog.php?category=$catID'>" . $row["CategoryNaam"] . "</a></h2></td>"
                                    . "</tr>");
                            $result2 = getSQLArray("SELECT * FROM prijs WHERE CategoryID=" . $catID);

                            while ($row2 = $result2->fetch()) {
                                ?>
                                <tr class="notranslate">
                                    <?php
                                    $regelID = $row2["PrijsID"];
                                    if (isset($_SESSION['logged_in'])) {
                                        echo"<td><form action='pricelist.php' method='post'>"
                                        . "<input type='hidden' name='id'  value='$regelID'>"
                                        . "<input style='width:10px' type='submit' name='verwijderRegel'  value='X'>"
                                        . "</form>"
                                        . "<form action='pricelist.php' method='post'>"
                                        . "<input type='hidden' name='id'  value='$regelID'>"
                                        . "<input style='width:30px' type='submit' name='bewerkRegel'  value='Bewerken'>"
                                        . "</form>"
                                        . "</td>";
                                    }
                                        
                                    if (isset($row2['ExtraBeschrijving'])) {
                                        print("<td>" . $row2['Naam'] . "</td>");
                                        print("<td>" . $row2['ExtraBeschrijving'] . "</td>");
                                    } else {
                                        print("<td>" . $row2['Naam'] . "</td>"   );
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
=======
                    $result = getSQLArray("SELECT * FROM Category WHERE CategoryID IN(SELECT distinct CategoryID FROM prijs)");
                    ?>
                    <div id="printable">
                        <button id="printbutton" type="button" onclick="printDiv()">Print</button>
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
>>>>>>> f64e5577f2731e6a133a866eafdf940e5f075796
                                    <td>" . $row2['PrijsVBA'] . "</td>
                                    <td>" . $row2['ProductenCC'] . "</td>
                                    <td>" . $row2['ProductenLaag'] . "</td>
                                    <td>" . $row2['ProductenTray'] . "</td>
                                </tr>");
                                    }
                                    echo "<form action='pricelist.php' method='post'>"
                                    . "<tr class='notranslate'> "
                                    . "<td>"
                                    . "<input type='hidden' name='id'  value='$catID'>"
                                    . "<input style='width:50%' type='submit' name='regel'  value='Regel toevoegen'>"
                                    . "<input style='width:50%' type='text' name='naam'>"
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
                                    . "<input type='number' name='prijskwekerij'>"
                                    . "</td> "
                                    . "<td>"
                                    . "<input type='number' name='prijsvba'>"
                                    . "</td> "
                                    . "<td>"
                                    . "<input type='number' name='percc'>"
                                    . "</td> "
                                    . "<td>"
                                    . "<input type='number' name='perlaag'>"
                                    . "</td> "
                                    . "<td>"
                                    . "<input type='number' name='pertray'>"
                                    . "</td> "
                                    . "</form>";
                                }
<<<<<<< HEAD
                                if (isset($_SESSION['logged_in'])) {
                                    echo "<form action='pricelist.php' method='post'>"
                                    . "<tr class='notranslate'> "
                                    . "<td>"
                                    . "<input type='hidden' name='id'  value='$catID'>"
                                    . "<input type='submit' name='regel'  value='Regel toevoegen'>"
                                    . "</td>"
                                    . "<td>"
                                    . "<input type='text' name='naam'>"
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
                            if (isset($_SESSION['logged_in'])) {
                                echo "<form action='pricelist.php' method='post'>"
                                . "<tr class='notranslate'> "
                                . "<td> "
                                . "<input style='width:50%' type='submit' name='category'  value='Category toevoegen'>"
                                . "<input style='width:50%' type='text' name='naam'>"
                                . "</td> "
                                . "</form>";
                            }
                            ?>
                    </table>

=======
                                ?>
                        </table>
                    </div>
>>>>>>> f64e5577f2731e6a133a866eafdf940e5f075796
                </section>
            </section>
        </section>
        <?php
        include '../Php/footer.php';
        ?>
<<<<<<< HEAD
=======

>>>>>>> f64e5577f2731e6a133a866eafdf940e5f075796
    </body>
</html>