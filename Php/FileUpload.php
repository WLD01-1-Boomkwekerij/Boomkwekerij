<?php

function return_bytes($val)
{
    $val = trim($val);
    $last = strtolower($val[strlen($val) - 1]);
    switch ($last)
    {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}

$count = count($_FILES['fileToUpload']['name']);

print(return_bytes(ini_get('upload_max_filesize')));


$test = 0;


foreach ($_FILES['fileToUpload']['size'] as $value)
{
    $test += $value;
}
if ($test < return_bytes(ini_get('post_max_size')))
{
    
}
else
{
    print("total File size is bigger than Maximum");
}



/*
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
                            insertImage($_FILES["UploadFile"]["name"][$i], $_POST["UploadUrl"]);
                        }
                    }
                }
            }
 */