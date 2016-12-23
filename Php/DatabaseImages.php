<?php

//The file for all Image Commands
function insertImage($Url, $Name)
{
    doSQL("INSERT INTO foto (FotoUrl, FotoNaam) VALUES ($Url, $Name)");
}

function loadImageById($Id)
{
    print(getSQL("SELECT FotoUrl FROM foto WHERE FotoID = $Id", "FotoUrl"));
}

if(isset($_GET["getImageByName"]))
{
    print(getSQL("SELECT FotoUrl FROM foto WHERE FotoNaam = '" . $_GET["getImageByName"] . "'", "FotoUrl"));
}

function updateImageById($Id, $newUrl, $Name)
{
    doSQL("UPDATE foto SET FotoUrl = $newUrl, FotoNaam = $Name WHERE FotoID = $Id");
}

function deleteImageById($Id)
{
    doSQL("DELETE FROM foto WHERE FotoID = $Id");
}

function deleteImageByName($Name)
{
    doSQL("DELETE FROM foto WHERE FotoNaam = $Name");
}