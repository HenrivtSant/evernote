<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 29-8-2017
 * Time: 09:53
 */

if (!(isset($_SESSION))) {
    session_start();
}

require_once "formcheckers.php";
require_once "../classes/database.php";
require_once "../config_and_connect/config.php";

/**
 * De gebruiker komt altijd binnen op index.php
 * Index.php checkt of de gebruiker een Session heeft of niet
 * Zo ja; de gebruiker krijgt dit te zien en heeft de optie om door te gaan naar Notes pagina
 * Zo niet; moet de gebruiker inloggen of een nieuw account maken
 * Vanaf zowel de inlog als de nieuw account pagina wordt de gebruiker geverifieerd via deze formsubmit.php
 * Hier wordt dan ook de session gestart
 */

/**
 * LOGIN CHECK
 * Stap 1: Check of de login.php $_POST is gevuld
 * Stap 2: Gebruik de checkers uit formcheckers.php om te checken of ze aan de voorwaarden voldoen
 * Stap 3: Check of de gebruiker bestaat
 * Stap 4: Check of het wachtwoord van de gebruiker overeenkomt
 * Stap 5: Set de sessie en redirect naar index.php
 */

// Checkt of username en password ingevuld zijn
if (isset($_POST['usrnm']) && isset($_POST['password'])) {
    $username = $_POST['usrnm'];
    $password = $_POST['password'];
    // Checkt of username en password aan de voorwaarden voldoen zoals gezet in formcheckers.php
    if (checkUsername($username) && checkPassword($password)) {
        // Checkt of de username en password bestaan in de database en correct zijn.
        // Dit door een object en method vanuit de database class
        $loginCheck = new database($host, $usernameDB, $passwordDB, $db, $username, $password);
        if ($loginCheck->checkLoginInDatabase($username, $password)){
            // Login data is correct
            $userID = $loginCheck->getUserIdAndName($username, $password);
            var_dump($userID);
            $_SESSION["name"] = $userID[0];
            $_SESSION["userid"] = $userID[1];
            header('Location: '. '../index.php');
        } else {
            // Password is niet correct
            header('Location: ' . 'login.php?loginfail=password');
        }
    } else {
        // Password en/of username voldoen niet aan de voorwaarden gesteld in formcheckers.php
        header('Location: ' . 'login.php?loginfail=passwordusername');
    }
}

/**
 * NEW ACCOUNT CHECK
 * Stap 1: Check of de newaccount.php $_POST is gevuld
 * Stap 2: Gebruik de checkers uit formcheckers.php om te checken of ze aan de voorwaarden voldoen
 * Stap 3: Check of de gebruiker al bestaat
 * Stap 4: Maak de gebruiker aan in de database
 * Stap 5: Laad de gebruiker in, in een user-object
 * Stap 6: Start de sessie voor de gebruiker vanuit het object en set de "name" en de "user_id"
 * Stap 7: Geef een melding als alles is gelukt
 */

echo $_POST['initusrnm'] . " username<br />";
echo $_POST['initpassword'] . " password<br />";

// Checkt of username en password ingevuld zijn
if (isset($_POST['initusrnm']) && isset($_POST['initpassword'])) {
    $username = $_POST['initusrnm'];
    $password = $_POST['initpassword'];
    // Checkt of username en password aan de voorwaarden voldoen zoals gezet in formcheckers.php
    if (checkUsername($username) && checkPassword($password)) {
        // Checkt of de username en password bestaan in de database en correct zijn.
        // Dit door een object en method vanuit de database class
        $loginCheck = new database($host, $usernameDB, $passwordDB, $db, $username, $password);
        if (!($loginCheck->checkForExistingUser($username))) {
            // Username bestaat nog niet en nieuwe user kan dus worden aangemaakt
            if ($loginCheck->addNewUser($username, $password)) {
                // Nieuwe user aanmaken is gelukt
                // De sessie wordt nu gestart
                $userID = $loginCheck->getUserIdAndName($username, $password);
                var_dump($userID);
                $_SESSION["name"] = $userID[0];
                $_SESSION["userid"] = $userID[1];
                header('Location: ' . '../index.php');
                echo "Succes!";
            } else {
                // Password genereren nieuw account niet gelukt
                // HIER NOG EEN ACTIE MET GET AAN VERBINDEN
                echo "<br />Genereren nieuw account niet gelukt";
            }
        } else {
            // Username already exists
            // HIER NOG EEN ACTIE MET GET AAN VERBINDEN
            echo "<br />Username already exists";
        }
    } else{
        // Password en/of username voldoen niet aan de voorwaarden gesteld in formcheckers.php
        header('Location: ' . 'newaccount.php?newaccountfail=passwordusername');
    }
}
