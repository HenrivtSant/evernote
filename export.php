<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4-9-2017
 * Time: 15:52
 */

// Check if session has been started
if (!(isset($_SESSION))) {
    session_start();
}

// fopen url
$url = $_GET['url'];


$openUrl = fopen($_GET['url'], "r");
$contents = fread($openUrl, filesize("notes/notefunctions/viewone.php"));
fclose($openUrl);


echo $openUrl;




    header("Content-type:application/pdf");

// It will be called downloaded.pdf
    header("Content-Disposition:attachment;filename='downloaded.pdf'");

    require_once "styling/vendor/autoload.php";

    $pdf = new CanGelis\PDF\PDF('/usr/bin/wkhtmltopdf');

//echo $pdf->loadHTML("<?php echo $contents ")->get();

echo $pdf->loadURL($openUrl)->get();

//echo $pdf->loadHTMLFile('/home/can/index.html')->lowquality()->pageSize('A2')->get();



    //echo $pdf->loadURL($_GET['url'])->get();