<?php

include 'DatabaseInformation.php';

if (isset($_GET["htmlText"]) && isset($_GET["textID"])) {
    saveTextToDB($_GET["textID"], $_GET["htmlText"]);
}

if (isset($_GET["fileDirectory"])) {
    $dir = $_GET["fileDirectory"];
    $files1 = scandir($dir);

    for ($i = 2; $i < sizeof($files1); $i++) {

        print($files1[$i] . "*");
    }
}

