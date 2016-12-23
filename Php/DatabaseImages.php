<?php

//The file for all Image Commands
//Insert Image
if (isset($_GET["insertImage"], $_GET["url"]))
{
    BeveiligDoSQL("INSERT INTO foto (FotoUrl, FotoNaam) VALUES (?, ?)", array($_GET["url"], $_GET["insertImage"]));
}

//Load image
if (isset($_GET["getImageByName"]))
{
    print(getSQL("SELECT FotoUrl FROM foto WHERE FotoNaam = '" . $_GET["getImageByName"] . "'", "FotoUrl"));
}

//Update
if (isset($_GET["updateImageByName"], $_GET["imageUrl"]))
{
    BeveiligDoSQL("UPDATE foto SET FotoNaam = ? , FotoUrl = ? WHERE FotoNaam = ?", array($_GET["updateImageByName"], $_GET["imageUrl"], $_GET["updateImageByName"]));
}

//Delete
if(isset($_GET["deleteImageByName"]))
{
    BeveiligDoSQL("DELETE FROM foto WHERE FotoNaam = ?", array($_GET["deleteImageByName"]));
}
