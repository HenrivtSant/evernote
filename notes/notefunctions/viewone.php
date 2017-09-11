<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 28-8-2017
 * Time: 15:34
 */


if ($databaseConnect = new database($host, $usernameDB, $passwordDB, $db, $_SESSION['name'], "unset", $_SESSION['userid'])) {
    $noteResult = $databaseConnect->getNote($_GET['viewnote']);
    $note = $noteResult->fetch_object();
    $categoryResult = $databaseConnect->getCategory($_SESSION['userid']);
    $category = $categoryResult->fetch_object();
    ?>
    <!--Verberg de div met de niewste vijf notes, om verwarring te voorkomen.-->
    <style type="text/css">
        .lastFiveNotes {
            display: none;
        }
    </style>
    <div class="oneNote">
        <h3><?php echo $note->note_name ?></h3>
        <p id="categoryNote">Cat: <?php echo $category->category ?></p>
        <p><?php echo $note->text ?></p>
        <?php if (isset($note->image)) {
                $img_link = "http://$_SERVER[HTTP_HOST]/evernote/" . $note->image;
                echo "<img src='" . $img_link . "' width='200px'/>";
            }?>
    </div>

    <div class="linkButton">
        <a href="note.php?note_id=<?php echo $_GET['viewnote'] ?>" />Edit this file</a>
    </div>
        <div class="linkButton">
        <a href="note.php?viewnote=<?php echo $_GET['viewnote'] ?>&download=download "/>Download file</a>
    </div>

    <?php


}