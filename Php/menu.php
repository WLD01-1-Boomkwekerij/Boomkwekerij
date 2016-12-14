<section id="topmenu">
    <link rel="plant icon" href="../Images/plant_icon.png">
    <ul>
        <li><a href="../pages/index.php">Home</a></li>
        <li><a href="../pages/news.php">Aanbiedingen</a></li>
        <li><a href="../pages/catalog.php">Catalogus</a></li>
        <li><a href="../pages/pricelist.php">Prijslijst</a></li> 
        <li><a href="../pages/contact.php">Contact</a></li>
        <?php
        if (isset($_SESSION['logged_in'])) {
            print("<li><a href='../pages/logged_in.php'>Beheerderspagina</a></li>");

            //Uploading File
            if (isset($_POST["UploadUrl"]) && isset($_POST["submitUploadFile"])) {
                //Directory to upload to
                $target_dir = $_POST["UploadUrl"] . "/"; //"../Images/";
                //Path to and including the file to upload
                $target_file = $target_dir . basename($_FILES["UploadFile"]["name"]);


                $uploadOk = 1;

                //The file extension
                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

                //Checking if something is being uploaded and if it is a file
                $check = getimagesize($_FILES["UploadFile"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                }

                //Checking if the file aleady exists
                if (file_exists($target_file)) {
                    $uploadOk = 0;
                }

                //Upload the file
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                } else {
                    if (move_uploaded_file($_FILES["UploadFile"]["tmp_name"], $target_file)) {
                        
                    }
                }
            }
        }
        ?>
    </ul>
</section>
