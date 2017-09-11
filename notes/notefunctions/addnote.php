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
    <!--Verberg de div met de niewste vijf notes, om verwarring te voorkomen.-->
    <style type="text/css">
        .lastFiveNotes {
            display: none;
        }
    </style>
    <div class="addnote forms" >
    <h3 >New Note</h3 >

    <form enctype="multipart/form-data" method = "post" action = "notefunctions/submitnote.php" name = "fileupload" >
        <label><input type="text" name="note_name" placeholder="Give your note a name" required></label><br />
        <textarea name = "uploadedtext" placeholder = "Enter your text here" rows = "5" cols = "65" ></textarea ><br />
        <label ><input type = "file" name = "uploadedfile" id="uploadedfile" placeholder = "Upload a file" ></label ><br />
        <select name = "selectedCategory">
            <?php
            while ($categories = $categoriesResult->fetch_object()) {
                ?>
                <option value="<?php echo $categories->cat_id ?>"><?php echo $categories->category ?></option>
                <?php
            }
        ?>
        </select>
            <br/>
        <label><input type="submit" value="Upload"></label>
    </form>
    </div>
    <?php
} else {
    echo "Error: Connection with database could not be established. Please try again later";
}

