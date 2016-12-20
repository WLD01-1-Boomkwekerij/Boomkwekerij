<?php

$servername = "localhost";
$username = "root";
$password = "usbw";
$dbname = "boomkwekerij";

try {
    //$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO Prijs (CategoryID, Potmaat, Hoogte_max, PrijsKwekerij,
        PrijsVBA, ProductenCC, ProductenLaag, ProductenTray) 
    VALUES (:CategoryID, :Potmaat, :Hoogte, :PrijsKwekerij, :PrijsVBA, :ProductenCC, :ProductenLaag,
    :ProductenTray)");
    $stmt->bindParam(':CategoryID', $CategoryID);
    $stmt->bindParam(':Potmaat', $Potmaat);
    $stmt->bindParam(':Hoogte', $Hoogte);
    $stmt->bindParam(':PrijsKwekerij', $prijsKwekerij);
    $stmt->bindParam(':PrijsVBA', $prijsVBA);
    $stmt->bindParam(':ProductenCC', $ProductenCC);
    $stmt->bindParam(':ProductenLaag', $ProductenLaag);
    $stmt->bindParam(':ProductenTray', $ProductenTray);

    // insert a row
    $CategoryID = $_POST['nr'];
    $Potmaat = $_POST['potmaat'];
    $Hoogte = $_POST['hoogte'];
    $prijsKwekerij = $_POST['prijskwek'];
    $prijsVBA = $_POST['prijsvba'];
    $ProductenCC = $_POST['percc'];
    $ProductenLaag = $_POST['perlaag'];
    $ProductenTray = $_POST['pertray'];
    $stmt->execute();




    echo "New records created successfully";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
