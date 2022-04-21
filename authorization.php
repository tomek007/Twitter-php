<?php
session_start();
if (empty($_SESSION)){
    $_SESSION['auth'] = 0;
}
if ($_SESSION['auth'] == 1) {
    header("location:main_logged.php");
    die;
}
?>
