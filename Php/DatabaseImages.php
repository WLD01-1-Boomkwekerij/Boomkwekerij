<?php

include_once 'Database.php';

//The file for all Image Commands
//Insert Image
function insertImage($name, $url)
{
    ProtectedDoSQL("INSERT INTO foto (FotoUrl, FotoNaam) VALUES (?, ?)", array($url, $name));
}

//Load image
if (isset($_GET["getImageByID"]))
{
    $statement = ProtectedGetSQLArray("SELECT FotoUrl, FotoNaam FROM foto WHERE FotoID = ?", array($_GET["getImageByID"]));
    $row = $statement->fetch();
    $fullURL = $row["FotoUrl"] . "/" . $row["FotoNaam"];
    print($fullURL);
}

if (isset($_GET["getImageIDByName"]))
{
    $name = ProtectedGetSQL("SELECT FotoID FROM foto WHERE FotoNaam = ?", "FotoID", array($_GET["getImageIDByName"]));
    print($name);
}

//Update
if (isset($_GET["updateImageByName"], $_GET["oldImageUrl"], $_GET["newImageUrl"]))
{
    rename($_GET["oldImageUrl"] . "/" . $_GET["updateImageByName"], $_GET["newImageUrl"] . "/" . $_GET["updateImageByName"]);
    ProtectedDoSQL("UPDATE foto SET FotoNaam = ? , FotoUrl = ? WHERE FotoNaam = ?", array($_GET["updateImageByName"], $_GET["newImageUrl"], $_GET["updateImageByName"]));
}

function rrmdir($dir)
{
    if (is_dir($dir))
    {
        $objects = scandir($dir);
        foreach ($objects as $object)
        {
            if ($object != "." && $object != "..")
            {
                if (filetype($dir . "/" . $object) == "dir")
                    rrmdir($dir . "/" . $object);
                else
                    unlink($dir . "/" . $object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

//Delete
if (isset($_GET["directory"], $_GET["deleteImageByName"], $_GET["type"]))
{

    if ($_GET["type"] == "file")
    {
        unlink($_GET["directory"] . "/" . $_GET["deleteImageByName"]);
        ProtectedDoSQL("DELETE FROM foto WHERE FotoNaam = ?", array($_GET["deleteImageByName"]));
    }
    else
    {
        rrmdir($_GET["directory"]);
        ProtectedDoSQL("DELETE FROM `foto` WHERE FotoUrl LIKE ?", array($_GET["directory"]));
    }
}