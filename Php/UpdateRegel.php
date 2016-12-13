<?php
if(isset($_POST['OpslaanRegel'])){
    $id = $_POST['id'];
    $potmaat = $_POST['potmaat'];
    $beschrijving = $_POST['beschrijving'];
    $percc = $_POST['percc'];
    $perlaag = $_POST['perlaag'];
    $pertray = $_POST['pertray'];
    $prijsKwekerij = $_POST['prijskwekerij'];
    $prijsVBA = $_POST['prijsvba'];
    $naam = $_POST['naam'];                              

    doSQL("UPDATE prijs SET PrijsKwekerij='$prijsKwekerij', PrijsVBA='$prijsVBA', ProductenCC='$percc', ProductenLaag='$perlaag', ProductenTray='$pertray', Naam='$naam', ExtraBeschrijving='$beschrijving', Potmaat='$potmaat' WHERE PrijsID=$id");
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

