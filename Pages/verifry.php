

<?php

if(isset($_POST[''])){
$user = $_POST['user'];
$pass = $_POST['pass'];

if($user == 'Antoinnette' && $pass == 1234){
    echo "Welkom"  ." ".$user . " U word doorverwezen naar de beheerderspagina";
    header('Refresh: 4; url=/pages/logged_in.php');
}else{
    header('Refresh: 4; url=/pages/login.php');
    echo "Foutief wachtwoord! U wordt doorverwezen naar het beginscherm";
}
}else{
    echo "U heeft niet ingelogd! U wordt doorverwezen naar de loginpagina.";
    header('refresh:4; url=/pages/login.php');
}

?>