<?php

//The file for all Image Commands
function insertImage($Url, $Name)
{
    BeveiligDoSQL("INSERT INTO foto (FotoUrl, FotoNaam) VALUES (?, ?)",array($Url, $Name));
}

function loadImageById($Id)
{
    print(BeveiligdGetSQL("SELECT FotoUrl FROM foto WHERE FotoID = ?", "FotoUrl",array($Id)));
}

function loadImageByName($Name)
{
    print(BeveiligdGetSQL("SELECT FotoUrl FROM foto WHERE FotoNaam = ?", "FotoUrl",array($Name)));
}

function updateImageById($Id, $newUrl, $Name)
{
    BeveiligDoSQL("UPDATE foto SET FotoUrl = ?, FotoNaam = ? WHERE FotoID = ?",array($newUrl,$Name,$Id));
}

function deleteImageById($Id)
{
    BeveiligDoSQL("DELETE FROM foto WHERE FotoID = ?",array($Id));
}

function deleteImageByName($Name)
{
    BeveiligDoSQL("DELETE FROM foto WHERE FotoNaam = ?",array($Name));
}