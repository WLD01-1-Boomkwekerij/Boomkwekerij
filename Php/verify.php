<?php
// Starts a session
session_start();

// Checks if the form is send 
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // Checks if all the fields have been filled in
    include_once 'Inlogverify.php';
    if (confirmIP($_SERVER['REMOTE_ADDR']) < 7)
    {
        include_once 'Database.php';
        $sGebruikerControle = trim($_POST['user']);
        $sWachtwoordControle = ProtectedGetSQL('SELECT Wachtwoord FROM gebruiker WHERE Naam=?', 'Wachtwoord', array($sGebruikerControle));
        // Configure username and password
        if (isset($_POST['user'], $_POST['pass']))
        {
            // Delete unneeded spacebars 
            $sGebruiker = htmlentities(trim($_POST['user']));
            $sWachtwoord = hash('sha256', htmlentities(trim($_POST['pass'])));
            // Check username and password
            if ($sGebruiker == $sGebruikerControle && $sWachtwoord == $sWachtwoordControle)
            {
                // Logs you i if the verification is correct 
                $_SESSION['logged_in'] = true;
                $_SESSION['gebruiker'] = $sGebruiker;
                $_SESSION['toegang'] = ProtectedGetSQL('SELECT Rol FROM gebruiker WHERE Naam=?', 'Rol', array($sGebruikerControle));
                $query = 'DELETE FROM `loginattempts` WHERE IP=?';
                $variable = array($_SERVER['REMOTE_ADDR']);
                ProtectedDoSQL($query, $variable);
                // Gives a message
                if ($_SESSION['toegang'] == 1)
                {
                    header('Refresh: 0; url=../pages/logged_in.php');
                    print('U wordt automtisch doorgestuurd, mocht dit niet gebeuren, <a href="../Pages/logged_in.php">klik dan hier</a>');
                }
                else
                {
                    header('Refresh: 0; url=../pages/index.php');
                    print('U wordt automtisch doorgestuurd, mocht dit niet gebeuren, <a href="../Pages/index.php">klik dan hier</a>');
                }
            }
            else
            {
                // Sends an error
                header('Refresh: 2; url=../pages/login.php');
                echo 'Deze combinatie van gebruikersnaam en wachtwoord is niet juist!';
            }
        }
        else
        {
            header('Refresh: 2;  url=../pages/login.php');
            echo 'Een vereist veld is niet ingevuld!';
        }
    }
    else
    {
        // Goes back to form
        Print('7 pogingen gehad, probeer het over 5 minuten weer.');
        header('Refresh: 5; url=../pages/login.php');
        exit();
    }
}
else
{
//    header('Refresh: 5; url=../Pages/login.php');
    exit();
}
?>