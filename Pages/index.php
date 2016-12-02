<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="notranslate">Boomkwekerij - Aanbiedingen</title>
        <link href="../Css/MainStyle.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="plant icon" href="../Images/plant_icon.png">
        <?php
        session_start();
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            print("<link href='../Css/EditableStyle.css' rel='stylesheet' type='text/css'>");
            print("<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>");
            print("<script src='../Javascript/InformationEditing.js'></script>");
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
                    //Gebruik dit commando met de TextID van de tekst om hem altijd te laten werken
                    print("<div ");
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
                        print("class='ContentEditable'");
                    }
                    print("id = 'textID1'>");
                    loadTextFromDB(1);
                    print("</div>");
                    ?>
                    <br>
                </section>
                
                
                
                
                <!--BESTANDS BEHEERDER -->
                    <div id="FileManager">
                        <div id="Files">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <div id="BottomInfo">
                            <button style="
                                    position: absolute;
                                    margin-left: 5px;
                                    border: none;
                                    bottom: 5px;
                                    "
                                    >Cancel</button>
                            <button style="
                                    position: absolute;
                                    margin-right: 5px;
                                    border: none;
                                    bottom: 5px;
                                    right: 5px;
                                    " 
                                    >Select</button>
                            <div style="
                                    position: absolute;
                                    left: 50%;
                                    top: 10px;
                                 ">
                                <div id="currentPathSelected" style="
                                     position: relative;
                                     background-color: beige;
                                     width: 350px;
                                     height: 30px;
                                     box-shadow: 0px 0px 2px 0px black;
                                     left: -50%;
                                     "
                                     ></div>
                            </div>

                        </div>
                    </div>
                
                
                
                

            </section>
        </section>
        <?php
        include '../Php/footer.php';
        ?>
    </body>
</html>