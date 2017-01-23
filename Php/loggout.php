<?php

// Makes and starts sessions
session_start();

// Deactivates all veriabels in a session
$_SESSION = array();

// If the session does not have to be destroyed it only destroys the cookies
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
    );
}

// Destroys the session
session_destroy();

// After the session is destroyed you will be redirected to the homepage.
header('refresh:0; url=../pages/index.php');
print('U wordt automtisch doorgestuurd, mocht dit niet gebeuren, <a href="../pages/index.php">klik dan hier</a>');
?>