<?php

if(isset($_POST['verwijderCat'])){
    $id = $_POST['id'];                              

    doSQL("DELETE FROM plantfoto WHERE PlantID IN(SELECT PlantID FROM plant WHERE PrijsID IN(SELECT PrijsID FROM prijs WHERE CategoryID='$id'))");
    doSQL("DELETE FROM plant WHERE PrijsID IN(SELECT PrijsID FROM prijs WHERE CategoryID='$id');");   
    doSQL("DELETE FROM prijs WHERE CategoryID='$id';");  
    doSQL("DELETE FROM category WHERE CategoryID='$id';");
    
}


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

