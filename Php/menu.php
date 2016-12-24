<section id="topmenu">
    <link rel="plant icon" href="../Images/plant_icon.png">
    <ul>
        <li><a href="../pages/index.php">Home</a></li>
        <li><a href="../pages/news.php">Aanbiedingen</a></li>
        <li><a href="../pages/catalog.php">Catalogus</a></li>
        <li><a href="../pages/pricelist.php">Prijslijst</a></li> 
        <li><a href="../pages/contact.php">Contact</a></li>
        <?php
        include 'DatabaseInformation.php';
        include 'DatabaseImages.php';

        if (isset($_SESSION['logged_in']) && $_SESSION['toegang'] == 1)
        {
            print("<li><a href='../pages/logged_in.php'>Beheerderspagina</a></li>");

            //Uploading File
            if (isset($_POST["UploadUrl"]) && isset($_POST["submitUploadFile"]))
            {
                //Directory to upload to
                $target_dir = $_POST["UploadUrl"] . "/"; //"../Images/Afbeeldingen";

                for ($i = 0; $i < sizeof($_FILES["UploadFile"]["name"]); $i++)
                {
                    //Path to and including the file to upload
                    $target_file = $target_dir . basename($_FILES["UploadFile"]["name"][$i]);
                    $uploadOk = 1;
                    //The file extension
                    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

                    //Checking if something is being uploaded and if it is a file 
                    //Or if it already exists
                    $check = getimagesize($_FILES["UploadFile"]["tmp_name"][$i]);
                    if ($check === false || file_exists($target_file))
                    {
                        $uploadOk = 0;
                    }

                    //Upload the file
                    if ($uploadOk === 1)
                    {
                         if (move_uploaded_file($_FILES["UploadFile"]["tmp_name"][$i], $target_file))
                         {
                             insertImage($_FILES["UploadFile"]["name"][$i], $_POST["UploadUrl"] . $_FILES["UploadFile"]["name"][$i]);
                         }
                    }
                }
            }
        }
        ?>
    </ul>
</section>
