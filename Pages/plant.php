<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="notranslate">Boomkwekerij - Home</title>
        <!-- Icon Pack -->
        <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">

        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link href="../Css/PlantStyle.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        <?php
        session_start();

        include_once '../Php/DatabaseInformation.php';

        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            print("<link href='../Css/EditableStyle.css' rel='stylesheet' type='text/css'>");
            print("<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>");
            print("<script src='../Javascript/InformationEditing.js'></script>");
        }
        ?>
        <link href="../Css/HomeStyle.css" rel="stylesheet" type="text/css">

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
                    <section id="PhotoFrame">
                        <div>
                            <img id="ImageFrame" src="../Catalogus fotos/Heesters/aucuba tray p13.jpg">
                        </div>
                        
                        
                        <!-- Left Arrow-->
                        <div class="Arrow">

                        </div>
                        <!-- Images-->                        
                        <img style="width: 100px; box-shadow: 0px 0px 2px 1px black;" src="../Catalogus fotos/Clematis/alpina.jpg">  
                        <img style="width: 100px; box-shadow: 0px 0px 2px 1px black;" src="../Catalogus fotos/Klimplanten/passiflora.jpg">                        
                        <img style="width: 100px; box-shadow: 0px 0px 2px 1px black;" src="../Catalogus fotos/Klimplanten/toscaanse jasmijn.jpg">

                        <!-- Right Arrow-->
                        <div class="Arrow">

                        </div>
                    </section>

                </section>
            </section>
        </section>
        <?php
        include '../Php/footer.php';
        ?>
    </body>
</html>
