<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 30-8-2017
 * Time: 10:20
 */
if (!(isset($_SESSION))) {
    session_start();
}

$logout = $_GET['action'];

if ($logout="logout") {
    session_destroy();
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
