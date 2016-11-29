<?php

include 'DatabaseInformation.php';

if(isset($_GET["htmlText"]) && isset($_GET["textID"])){
    print("hey");
    saveTextToDB($_GET["textID"], $_GET["htmlText"]);
}

