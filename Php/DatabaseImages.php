<?php

//The file for all Image Commands
//Insert Image
function insertImage($name, $url)
{
     ProtectedDoSQL("INSERT INTO foto (FotoUrl, FotoNaam) VALUES (?, ?)", array($name, $url));
}

//Load image
if (isset($_GET["getImageByName"]))
{
    print(getSQL("SELECT FotoUrl FROM foto WHERE FotoNaam = '" . $_GET["getImageByName"] . "'", "FotoUrl"));
}

//Update
if (isset($_GET["updateImageByName"], $_GET["imageUrl"]))
{
    ProtectedDoSQL("UPDATE foto SET FotoNaam = ? , FotoUrl = ? WHERE FotoNaam = ?", array($_GET["updateImageByName"], $_GET["imageUrl"], $_GET["updateImageByName"]));
}

//Delete
if(isset($_GET["deleteImageByName"]))
{
    ProtectedDoSQL("DELETE FROM foto WHERE FotoNaam = ?", array($_GET["deleteImageByName"]));
}
