<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 28-8-2017
 * Time: 15:45
 */

// Check if session has been started
if (!(isset($_SESSION))) {
    session_start();
}

require_once "../classes/database.php";
require_once "../config_and_connect/config.php";

if ($databaseConnect = new database($host, $usernameDB, $passwordDB, $db, $_SESSION['name'], "unset", $_SESSION['userid'])) {
    ?>
    <div class="overviewCategories forms addCategory">
        <h3>Add a new category</h3>

        <form method="post" action="../category/submitcategory.php" name="new_category">
            <label><input type="text" name="category_name" placeholder="Enter a new category" required></label>
            <label><input type="submit" value="Upload"></label>
        </form>
    </div>
    <?php
}