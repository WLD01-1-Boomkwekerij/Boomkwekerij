<?php

include_once 'Database.php';

//The file for all Image Commands
//Insert Image
function insertImage($name, $url)
{
     ProtectedDoSQL("INSERT INTO foto (FotoUrl, FotoNaam) VALUES (?, ?)", array($url, $name));
}

//Load image
if (isset($_GET["getImageByName"]))
{
    print(ProtectedGetSQL("SELECT FotoUrl FROM foto WHERE FotoNaam = ?", "FotoUrl", array($_GET["getImageByName"])));
}

//Update
if (isset($_GET["updateImageByName"], $_GET["oldImageUrl"], $_GET["newImageUrl"]))
{
    rename($_GET["oldImageUrl"] . "/" . $_GET["updateImageByName"] , $_GET["newImageUrl"] . "/" . $_GET["updateImageByName"]);
    ProtectedDoSQL("UPDATE foto SET FotoNaam = ? , FotoUrl = ? WHERE FotoNaam = ?", array($_GET["updateImageByName"], $_GET["newImageUrl"], $_GET["updateImageByName"]));
}

//Delete
if(isset($_GET["deleteImageByName"]))
{
    ProtectedDoSQL("DELETE FROM foto WHERE FotoNaam = ?", array($_GET["deleteImageByName"]));
}
