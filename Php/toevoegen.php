<?php

$servername = "localhost";
$username = "root";
$password = "usbw";
$dbname = "boomkwekerij";

try {
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// prepare sql and bind parameters
$stmt = $conn->prepare("INSERT INTO plant (Naam, PrijsID, PlantGroepID) 
    VALUES (:Naam, :PrijsID, :PlantGroepID);
    $stmt->bindParam(':Naam', $Naam);
    $stmt->bindParam(':PrijsID', $PrijsID);
    $stmt->bindParam(':PlantGroepID', $PlantGroepID");
            

       

    // insert a row
 
        
    $stmt->execute();




    echo 'New records created successfully';
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
$conn = null;
?>