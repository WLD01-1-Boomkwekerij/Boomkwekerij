<?php
if(isset($_POST['regel'])){
    $id = $_POST['id'];
    $potmaat = $_POST['potmaat'];
    $hoogte = $_POST['hoogte'];
    $beschrijving = $_POST['beschrijving'];
    $percc = $_POST['percc'];
    $perlaag = $_POST['perlaag'];
    $pertray = $_POST['pertray'];
    $prijsKwekerij = $_POST['prijskwekerij'];
    $prijsVBA = $_POST['prijsvba'];
    $naam = $_POST['naam'];                              

    doSQL("INSERT INTO prijs (`PrijsKwekerij`, `PrijsVBA`, `ProductenCC`, `ProductenLaag`, `ProductenTray`, `Naam`, `ExtraBeschrijving`, `Potmaat`, `CategoryID`) 
        VALUES ('$prijsKwekerij', '$prijsVBA', '$percc', '$perlaag', '$pertray', '$naam', '$beschrijving', '$potmaat', '$id')");
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

