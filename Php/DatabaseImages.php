<?php

//The file for all Image Commands
//Insert Image
function insertImage($Url, $Name)
{
    BeveiligDoSQL("INSERT INTO foto (FotoUrl, FotoNaam) VALUES (?, ?)",array($Url, $Name));
}

//Load image
function loadImageById($Id)
{
    print(BeveiligdGetSQL("SELECT FotoUrl FROM foto WHERE FotoID = ?", "FotoUrl",array($Id)));
}

if(isset($_GET["getImageByName"]))
{
    print(getSQL("SELECT FotoUrl FROM foto WHERE FotoNaam = '" . $_GET["getImageByName"] . "'", "FotoUrl"));
}

//Update
function updateImageById($Id, $newUrl, $Name)
{
    BeveiligDoSQL("UPDATE foto SET FotoUrl = ?, FotoNaam = ? WHERE FotoID = ?",array($newUrl,$Name,$Id));
}

function deleteImageById($Id)
{
    BeveiligDoSQL("DELETE FROM foto WHERE FotoID = ?",array($Id));
}

//Delete
function deleteImageByName($Name)
{
    BeveiligDoSQL("DELETE FROM foto WHERE FotoNaam = ?",array($Name));
}