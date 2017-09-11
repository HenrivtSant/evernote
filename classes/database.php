<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 29-8-2017
 * Time: 11:06
 */


class database
{
    private $hostDB;
    private $userDB;
    private $passDB;
    private $dbname;
    private $connection;
    private $username;
    private $passwordUser;
    private $user_id;

    /**
     * database constructor.
     * @param $hostDB
     * @param $userDB
     * @param $passDB
     * @param $dbname
     * @param $connection
     * @param $username
     * @param $passwordUser
     */
    public function __construct($hostDB, $userDB, $passDB, $dbname, $username, $passwordUser='unset', $user_id='unset')
    {
        $this->hostDB = $hostDB;
        $this->userDB = $userDB;
        $this->passDB = $passDB;
        $this->dbname = $dbname;
        // Make error handling around this database connector
        $this->connection = new mysqli($hostDB, $userDB, $passDB, $dbname);
        $this->username = $username;
        $this->passwordUser = $passwordUser;
        $this->user_id = $user_id;
    }

    public function checkLoginInDatabase($username, $passwordUser) {
        $usernameCheckQuery = "SELECT username FROM users WHERE username = \"" . $username . "\"";
        // Check of de username bestaat
        if ($this->connection->query($usernameCheckQuery)) {
            // User bestaat
            // Check of password matcht bij de user
            $passwordCheckQuery = "SELECT username, password FROM users WHERE username = \"" . $username . "\"";
            $result = $this->connection->query($passwordCheckQuery);
            $passwordCheckQueryResult = $result->fetch_object();
            //if (password_verify($passwordUser, $passwordCheckQueryResult->password)) {
            if ($passwordCheckQueryResult->password == $passwordUser) {
                // Password matcht de username
                return true;
            } else {
                // Het password is fout
                // Hier nog error handling omheen bouwen
                return false;
            }
        } else {
            // Hier nog error handling omheen bouwen
            // De username bestaat niet in de database
            return false;
        }
    }

    public function checkForExistingUser($username) {
        // Check of de username bestaat
        $usernameCheckQuery = "SELECT username FROM users WHERE username = \"" . $username . "\"";
        if ($this->connection->query($usernameCheckQuery)) {
            $result = $this->connection->query($usernameCheckQuery);
                if ($result->num_rows == 0) {
                    return false;
                } else {
                    return true;
                }
        } else {
            return false;
        }
    }

    /**
     * @param $username
     * @param $passwordUser
     * @return bool
     */
    public function addNewUser($username, $passwordUser) {
        //$passwordUser = password_hash($passwordUser, PASSWORD_DEFAULT);
        // Maak de nieuwe user aan in de database
        $makeNewUserQuery = "INSERT INTO `users` (`username`, `password`) VALUES (\"" . $username . "\",\"" . $passwordUser . "\")";
        if ($this->connection->query($makeNewUserQuery)) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserIdAndName($username, $passwordUser) {
        // MySQL om user_id op te vragen, hierbij worden ook de username en password gecheckt
        $userIDQuery = "SELECT user_id, username FROM users WHERE username = \"" . $username . "\" AND password = \"" . $passwordUser . "\"";
            $result = $this->connection->query($userIDQuery);
            $userIDQueryResult = $result->fetch_object();
            // Check of de waarde ook echt is gevuld
            if ($userIDQueryResult->user_id) {
                // Stop de waarde in een variabele
                $userIdAndName = array();
                $userIdAndName[0] = $userIDQueryResult->username;
                $userIdAndName[1] = $userIDQueryResult->user_id;
                // Return de waarde zodat deze beschikbaar komt
                return $userIdAndName;
            } else {
                // De user_id niet geset voor deze user
                // Hier nog error handling omheen bouwen
                return false;
            }
        }

    public function getLatestNotes($user_id) {
        $notesQuery = "SELECT note_name, category, date, note_id FROM notes, category WHERE notes.user_id = \"" . $user_id . "\"  AND notes.cat_id = category.cat_id ORDER BY notes.date DESC LIMIT 5";
        if ($notes = $this->connection->query($notesQuery)) {
            return $notes;
        } else {
            return false;
        }
    }

    public function getNotes($user_id) {
        $notesQuery = "SELECT note_name, category, date, note_id FROM notes, category WHERE notes.user_id = \"" . $user_id . "\"  AND notes.cat_id = category.cat_id ORDER BY notes.date DESC";
        if ($notes = $this->connection->query($notesQuery)) {
            return $notes;
        } else {
            return false;
        }
    }

    // Pakt een note op basis van het ID en laat de title, text en category zien
    public function getNote($note_id) {
        $notesQuery = "SELECT note_name, notes.cat_id, text, notes.user_id, image FROM notes, category WHERE notes.note_id = \"" . $note_id . "\"";
        if ($notes = $this->connection->query($notesQuery)) {
            return $notes;
        } else {
            return false;
        }
    }

    public function getCategory($user_id) {
        $categoryQuery = "SELECT category, cat_id FROM users, category WHERE users.user_id = \"" . $user_id . "\"  AND users.user_id = category.user_id";
        if ($categories = $this->connection->query($categoryQuery)) {
            return $categories;
        } else {
            return false;
        }
    }

    public function getNotesByCategory($user_id, $catID) {
        $notesQuery = "SELECT note_name, category, date, note_id FROM notes, category WHERE notes.user_id = \"" . $user_id . "\"  AND notes.cat_id = category.cat_id AND notes.cat_id = $catID ORDER BY notes.date DESC";
        if ($notes = $this->connection->query($notesQuery)) {
            return $notes;
        } else {
            return false;
        }
    }

    public function uploadNote($user_id, $noteTitle, $noteText="NULL", $noteFile="NULL", $noteCategoryId) {
        $addNoteQuery = "INSERT INTO `notes` (`user_id`, `cat_id`, `note_name`, `text`, `image`) VALUES (\"" . $user_id . "\",\"" . $noteCategoryId . "\",\"" . $noteTitle . "\",\"" . $noteText . "\",\"" . $noteFile . "\")";
        if ($this->connection->query($addNoteQuery)) {
            return true;
        } else {
            return false;
        }
    }

    public function updateNote($note_id, $noteTitle, $noteText="NULL", $noteFile="NULL", $noteCategoryId) {
        $updateNoteQuery = "UPDATE `notes` SET`cat_id`=\"" . $noteCategoryId . "\", `note_name`=\"" . $noteTitle . "\", `note_id`=\"" . $note_id . "\", `text`=\"" . $noteText . "\", `image`=\"" . $noteFile . "\" WHERE note_id=\"" . $note_id . "\"";
        if ($this->connection->query($updateNoteQuery)) {
            return true;
        } else {
            return false;
        }
    }

    public function addCategory ($user_id, $categoryname) {
        $addCategoryQuery = "INSERT INTO `category` (`user_id`, `category`) VALUES (\"" . $user_id . "\",\"" . $categoryname . "\")";
        if ($this->connection->query($addCategoryQuery)) {
            return true;
        } else {
            return false;
        }
    }
}