<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 28-8-2017
 * Time: 15:34
 */

if ($databaseConnect = new database($host, $usernameDB, $passwordDB, $db, $_SESSION['name'], "unset", $_SESSION['userid'])) {
    $allNotes = $databaseConnect->getNotes($_SESSION['userid']);
    ?>
    <!--Verberg de div met de niewste vijf notes, om verwarring te voorkomen.-->
    <style type="text/css">
        .lastFiveNotes {
            display: none;
        }
    </style>
    <div class="allNotes">
    <h3>Notes</h3>
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
    <div class="linkButton">
        <a href="note.php?action=viewallnotes&download=download">Download overview</a>
    </div>
    </div>
    </tbody>
    </table>
    </div><?php
}