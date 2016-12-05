
<?php include'/../Php/Database.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="notranslate">Boomkwekerij - Catalogus</title>
        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link media="screen and (max-width:1288px)" href="../Css/CatalogStyleSmall.css" rel="stylesheet" type="text/css">
        <link media="screen and (min-width:1288px)" href="../Css/CatalogStyleBig.css" rel="stylesheet" type="text/css">
        <link rel="plant icon" href="../Images/plant_icon.png">
        <?php
        session_start();

        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            
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
                    <div id="google_translate_element"></div><script type="text/javascript">
                        function googleTranslateElementInit() {
                            new google.translate.TranslateElement({pageLanguage: 'nl', includedLanguages: 'en,it,nl,sv', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
                        }
                    </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                    <h3>Catalogus</h3>
                    <ul id="catalogus">
                        <?php
                        $sqlCategory = getSQLArray("SELECT * FROM category");
                        while ($row = $sqlCategory->fetch()) {
                            $categoryNaam = $row["CategoryNaam"];
                            $id = $row["CategoryID"];
                            echo "<a href='http://localhost:8080/pages/catalog.php?category=$id'><li>$categoryNaam</li></a>";
                        }
                        ?>
                    </ul>
                </section>
                <section id="maincontent">
                    <?php
                    if (!isset($_GET['category'])) {
                        $category = 1;
                    } else {
                        $category = $_GET['category'];
                    }
                    $sqlCategory = getSQLArray("SELECT * FROM category WHERE CategoryID = $category");
                    $categoryRegel = $sqlCategory->fetch();
                    $categoryNaam = $categoryRegel["CategoryNaam"];
                    echo "<h1>$categoryNaam</h1>";

                    $sqlPrijs = getSQLArray("SELECT * FROM prijs WHERE CategoryID = $category");
                    while ($row = $sqlPrijs->fetch()) {
                        $prijsID = $row["PrijsID"];
                        $potmaat = $row["Potmaat"];
                        $hoogte = $row["Potmaat"];
                        $prijsKwekerij = $row["PrijsKwekerij"];
                        $prijsVBA = $row["PrijsVBA"];
                        $perCC = $row["ProductenCC"];
                        $perLaag = $row["ProductenLaag"];
                        $perTray = $row["ProductenTray"];
                        $sqlPlant = getSQLArray("SELECT * FROM plant WHERE PrijsID = $prijsID");
                        while ($plant = $sqlPlant->fetch()) {



                            $naam = $plant['Naam'];
                            $Hoogte_min = $plant['Hoogte_min'];
                            $Hoogte_max = $plant['Hoogte_max'];
                            $bloeiwijze = $plant['Bloeiwijze'];
                            $bloeitijd = $plant['Bloeitijd'];

                            echo "<div class='item'>
                            <div>
                            <form method='post' action='delete.php'>
                           <table>
                                    <tr>
                                        <td>Naam:</td>
                                        <td>$naam</td>
                                            <tr>
                                        <td>Groep</td>
                                        <td>...</td>
                                        <tr>
                                        <td>Min.Hoogte:</td>
                                        <td>$Hoogte_min</td>
                                              <tr>
                                        <td>Max.Hoogte:</td>
                                        <td>$Hoogte_max</td>
                                              <tr>
                                        <td>Bloeiwijze:</td>
                                        <td>$bloeiwijze</td>
                                              <tr>
                                        <td>Bloeitijd:</td>
                                        <td>$bloeitijd</td>
                                            
                                  
                                </table>
                            <img src='/Catalogus fotos/Heesters/aucuba tray p13.jpg'>  
                            </form>
                            </div>
                               <input type='submit' name='btnvinkje' id='btnvinkje' value='&#x2613'>
                            </div>";
                        }
                    }
                    ?>
                    <?php
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {


                    echo "<div class='item'>
                            <div>
                             <table>
                             <form method='post' action='../php/toevoegen.php'>
                                
                               
                                <td><label>Naam:</label></td>
                                <td><input id='name' name='name'type='tekst'></td>
                                <tr>
                                <td><label>Groep:</label></td>
                                <td>
                                <select id='groep' name='groep'>";
                    $sqlPrijs = getSQLArray("SELECT * FROM prijs");
                    while ($row = $sqlPrijs->fetch()) {
                    $naamPrijs = $row["Naam"];
                    $IDPrijs = $row["PrijsID"];
                    echo "<option value='$IDPrijs'>$naamPrijs</option>";
                }
                echo "</select>
                                </td>
                                <tr>
                                <td>Min.Hoogte:</td>
                                <td><input name='hoogte_min' type='text'></td>
                                <tr>
                                <td>Max.Hoogte:</td>
                                <td><input name='hoogte_max' type='text'></td>
                                <tr>
                                <td>Bloeitijd:</td>
                                <td><input name='bloeitijd' type='text'> </td>
                                <tr>
                                <td>Bloeiwijze:</td>
                                <td><input name='bloeiwijze' type='text'></td>
                                 </table>
                            <img src='/Catalogus fotos/Heesters/aucuba tray p13.jpg'>  
                            </div>
                               <input type='submit' name='btnvinkje' id='btnvinkje' value='&#x2714'>
                            </div>";
            }
            ?>
                   


                </section>
            </section>
        </section>
<?php
include '../Php/footer.php';
?>
    </body>
</html>