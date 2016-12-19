<?php
if(isset($_POST['verwijderRegel'])){
    $id = $_POST['id'];                              

    doSQL("DELETE FROM plantfoto WHERE PlantID IN(SELECT PlantID FROM plant WHERE PrijsID='$id')");
    doSQL("DELETE FROM plant WHERE PrijsID='$id';");   
    doSQL("DELETE FROM prijs WHERE PrijsID='$id';");  
    
}


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

