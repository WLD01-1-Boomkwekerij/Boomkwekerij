<?php
if(isset($_POST['OpslaanCat'])){
    $id = $_POST['id'];
    $naam = $_POST['naam'];                              
    doSQL("UPDATE category SET CategoryNaam='$naam' WHERE CategoryID=$id");
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

