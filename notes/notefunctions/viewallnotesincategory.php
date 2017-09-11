<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 28-8-2017
 * Time: 15:34
 */

if ($databaseConnect = new database($host, $usernameDB, $passwordDB, $db, $_SESSION['name'], "unset", $_SESSION['userid'])) {
    $allNotes = $databaseConnect->getNotesByCategory($_SESSION['userid'], $_GET['viewallnotesincategory']);
    ?>
    <!--Verberg de div met de niewste vijf notes, om verwarring te voorkomen.-->
    <style type="text/css">
        .lastFiveNotes {
            display: none;
        }
    </style>
    <div class="allNotesInCategory">
    <?php
    //if ($allNotesResult = $allNotes->fetch_object()){
    //if ($_GET['viewallnotesincategory'] == $allNotesResult->cat_id) {
    //echo "<h3>Notes" . $allNotesResult->category . "</h3>";
    //}} ?>
    <table>
        <thead>
        <tr>
            <th>Filename</th>
            <th>Category</th>
            <th>Creation Date</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($allNotesResult = $allNotes->fetch_object()) {
            ?>
            <tr>
                <td><a href="note.php?viewnote=<?php echo $allNotesResult->note_id ?>"><?php echo $allNotesResult->note_name ?></a></td>
                <td><a href="note.php?viewnote=<?php echo $allNotesResult->note_id ?>"><?php echo $allNotesResult->category ?></a></td>
                <td><a href="note.php?viewnote=<?php echo $allNotesResult->note_id ?>"><?php echo $allNotesResult->date ?></a></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    </div><?php
}