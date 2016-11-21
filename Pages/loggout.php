<?php
session_destroy();
    echo "U bent succesvol uitgelogd!";
    header('Refresh: 4; url=/pages/index.php');
?>