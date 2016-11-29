<?php

$db = "boomkwekerij";
$user = "root";
$pass = "usbw";
$pdo = new PDO($db, $user, $pass);
echo"nee";
if(isset($_POST['nr'])&& isset($_POST['potmaat'])&& isset($_POST['hoogte'])&& isset($_POST['prijskwek'])&& isset($_POST['prijsvba'])&& isset($_POST['percc'])&& isset($_POST['perlaag'])
        && isset($_POST['pertray'])){

$nr = $_POST['nr'];    
$potmaat = $_POST['potmaat'];
$hoogte = $_POST['hoogte'];
$prijskwek = $_POST['prijskwek'];
$prijsvba = $_POST['prijsvba'];
$percc = $_POST['percc'];
$perlaag = $_POST['perlaag'];
$pertray = $_POST['pertray'];




try {
    $conn = new PDO("mysql:host=localhost;dbname=boomkwekerij", 'root', 'usbw');
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO boomkwekerij (CategoryID, Potmaat, PrijsKwekerij, PrijsVBA, ProductenCC, ProductenLaag, ProductenTray)" . "VALUES ('$nr', '$potmaat','$hoogte', '$prijskwek','$prijsvba','$percc','$perlaag','$pertray')";
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "New record created successfully";
    }
catch(PDOException $e)
    {
    echo  $e->getMessage();
    }

$conn = null;

}

?>