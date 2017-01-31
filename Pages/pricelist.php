<!DOCTYPE html>
<html>
    <head>
        <script>
            function printDiv()
            {
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
                    include '../Php/Pricelist.php';

                    firstHalf();
                    ?>

                    <div id='printable'> 
                        <h1>Prijslijst</h1>
                        <section id='printbanner'>
                            <section id='titlediv' class="notranslate"><p id="imgtitle">FA.P.BOER BOOMKWEKERIJ</p></section>
                            <section id="top">
                                <section id="header">                                

                                </section>
                                <section id="topmenu">
                                    <ul>        
                                        <li>Rijneveld 125</li>
                                        <li>2771 XV Boskoop</li>
                                        <li>Email: info@boomkwekerijpboer.nl</li>
                                        <li>Robert: 06-22442190</li>
                                        <li>Peter: 06-57915055</li>
                                        <li>Fax: 0172-218627</li>
                                        <li>BGG: 0172-217308</li>
                                    </ul>
                                </section>                  
                            </section>
                        </section>

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
                            secondHalf();
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