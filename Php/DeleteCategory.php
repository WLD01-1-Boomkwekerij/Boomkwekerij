<?php
if(isset($_POST['category'])){
    $naam = $_POST['naam'];                              

    doSQL("INSERT INTO category (`CategoryNaam`) 
        VALUES ('$naam')");
}


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

