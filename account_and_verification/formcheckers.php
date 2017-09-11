<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 29-8-2017
 * Time: 09:15
 */



// Deze functie checkt of de een username aan de voorwaarden van een username voldoet.
// Deze functie returnt true bij een goede username en false bij een verkeerde.
// NOG NIET GECHECKT
function checkUsername($username) {
    $pattern = '/^[a-z\d]+$/i';
    if (preg_match($pattern, $username)) {
        return true;
    } else {
        return false;
    }
}

// Deze functie checkt of het password voldoet aan de voorwaarden voldoet
// Deze functie returnt true bij een goed password en false + de desbetreffende fout bij een incorrect password
// NOG NIET GECHECKT
function checkPassword($password)  {
    $errors = "";
    $errors_init = $errors;
    $error = false;

    if (strlen($password) < 8) {
        $errors[] = "Password too short!";
        $error = true;
    }

    if (!preg_match("#[0-9]+#", $password)) {
        $errors[] = "Password must include at least one number!";
        $error = true;
    }

    if (!preg_match("#[a-zA-Z]+#", $password)) {
        $errors[] = "Password must include at least one letter!";
        $error = true;
    }
    if ($error == true) {
        return ($errors == $errors_init);
    } else {
        return true;
    }
}

// Deze functie checkt of de naam van de note aan de gestelde voorwaarden voldoet
function checkNoteName($notename) {
    if (strlen($notename) < 20) {
        $pattern = '/^[a-z\d]+$/i';
        if (preg_match($pattern, $notename)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}