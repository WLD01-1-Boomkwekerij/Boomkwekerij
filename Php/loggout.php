<?php

// Het aanmaken en starten van de sessie
session_start();

// Het deactiveren van alle variabelen van de sessie
$_SESSION = array();

// Als het niet nodig is de sessie te vernietigen, vernietig de cookies
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
    );
}

// Vernietig de sessie
session_destroy();

// Nadat de sessie vernietigd is, word je doorverwezen naar de Homepagina.
header('refresh:0; url=../pages/index.php');
print('U wordt automtisch doorgestuurd, mocht dit niet gebeuren, <a href="../Pages/index.php">klik dan hier</a>');
?>