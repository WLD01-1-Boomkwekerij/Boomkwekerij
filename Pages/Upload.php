<?php

//Directory to upload to
$target_dir = "../Images/";

//Path to and including the file to upload
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);


$uploadOk = 1;

//The file extension
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

//Checking if something is being uploaded and if it is a file
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

//Checking if the file aleady exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

//Upload the file
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>