<?php

include 'DatabaseInformation.php';

if (isset($_POST["plantID"])) {
    deletePlant($_POST["plantID"]);
}
