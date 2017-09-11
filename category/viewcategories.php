<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 28-8-2017
 * Time: 15:35
 */
if ($databaseConnect = new database($host, $usernameDB, $passwordDB, $db, $_SESSION['name'], "unset", $_SESSION['userid'])) {
    $categoriesResult = $databaseConnect->getCategory($_SESSION['userid']);
    ?>
    <div class="overviewCategories" >
        <h3 >My Categories</h3 >
                <table>
                <?php
                while ($categories = $categoriesResult->fetch_object()) {
                    ?>
                    <td><a href="../account_and_verification/myaccount.php?viewallnotesincategory=<?php echo $categories->cat_id ?>"> <?php echo $categories->category ?> </a></td>
                    <?php
                }
                ?>
                </table>
    </div>
    <?php
} else {
    echo "Error: Connection with database could not be established. Please try again later";
}

